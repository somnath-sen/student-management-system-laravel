<?php

namespace App\Http\Controllers;

use App\Models\FacultyRegistration;
use App\Models\FacultyRegistrationQualification;
use App\Models\FacultyRegistrationExperience;
use App\Models\ApplicationDocument;
use App\Models\Subject;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacultyRegistrationController extends Controller
{
    public function store(Request $request)
    {
        if (!\App\Models\Setting::get('faculty_registration_enabled', true)) {
            return back()->withErrors(['email' => 'Faculty registrations are currently closed.'])->withInput();
        }

        // ── Validation ────────────────────────────────────────────────────────
        $validated = $request->validate([
            // Personal
            'first_name'      => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'last_name'       => 'required|string|max:100',
            'date_of_birth'   => 'nullable|date|before:today',
            'gender'          => 'nullable|in:male,female,other,prefer_not',
            'nationality'     => 'nullable|string|max:100',
            'blood_group'     => 'nullable|string|max:10',
            'marital_status'  => 'nullable|string|max:50',

            // Contact
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address'         => 'nullable|string|max:1000',
            'city'            => 'nullable|string|max:100',
            'state'           => 'nullable|string|max:100',
            'postal_code'     => 'nullable|string|max:20',
            'country'         => 'nullable|string|max:100',

            // Professional
            'department'           => 'nullable|string|max:255',
            'designation'          => 'nullable|string|max:150',
            'subjects'             => 'required|array|min:1',
            'subjects.*'           => 'exists:subjects,id',
            'years_experience'     => 'nullable|string|max:20',
            'current_institution'  => 'nullable|string|max:255',
            'teaching_mode'        => 'nullable|in:classroom,online,hybrid',
            'professional_summary' => 'nullable|string|max:2000',

            // Education (repeatable)
            'qualifications'                      => 'nullable|array',
            'qualifications.*.degree'             => 'required|string|max:150',
            'qualifications.*.institution'        => 'required|string|max:255',
            'qualifications.*.university'         => 'nullable|string|max:255',
            'qualifications.*.specialization'     => 'nullable|string|max:150',
            'qualifications.*.passing_year'       => 'nullable|string|max:10',
            'qualifications.*.percentage_cgpa'    => 'nullable|string|max:20',

            // Experience (repeatable)
            'experiences'                         => 'nullable|array',
            'experiences.*.institution'           => 'required|string|max:255',
            'experiences.*.designation'           => 'nullable|string|max:150',
            'experiences.*.department'            => 'nullable|string|max:150',
            'experiences.*.start_date'            => 'nullable|date',
            'experiences.*.end_date'              => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.is_current'            => 'nullable|boolean',
            'experiences.*.responsibilities'      => 'nullable|string|max:2000',

            // Identity
            'aadhaar'         => ['nullable', 'string', 'regex:/^\d{4}\s?\d{4}\s?\d{4}$/'],

            // Documents
            'doc_photo'              => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'doc_aadhaar'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_resume'             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_highest_cert'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_degree_cert'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_marksheet'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_teaching_cert'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_experience_cert'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_prev_employment'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_other'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // reCAPTCHA
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'email.unique'    => 'An application with this email already exists.',
            'aadhaar.regex'   => 'Aadhaar must be a valid 12-digit number.',
            'subjects.min'    => 'Please select at least one subject.',
        ]);

        // Prevent duplicate registrations
        $existingReg = FacultyRegistration::where('email', $validated['email'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingReg) {
            return back()->withInput()
                ->withErrors(['email' => 'An application with this email already exists. Please contact admin if you need assistance.']);
        }

        if (User::where('email', $validated['email'])->exists()) {
            return back()->withInput()
                ->withErrors(['email' => 'An account with this email already exists. Please login instead.']);
        }

        DB::beginTransaction();
        try {
            $fullName = trim("{$validated['first_name']} " . ($validated['middle_name'] ?? '') . " {$validated['last_name']}");

            // ── Application Number ────────────────────────────────────────────
            $year  = date('Y');
            $count = DB::table('faculty_registrations')->whereYear('created_at', $year)->count() + 1;
            $appNo = sprintf('EDF-FAC-%s-%05d', $year, $count);

            // ── Aadhaar encryption ────────────────────────────────────────────
            $aadhaarEncrypted = null;
            if (!empty($validated['aadhaar'])) {
                $aadhaarClean     = preg_replace('/\s+/', '', $validated['aadhaar']);
                $aadhaarEncrypted = Crypt::encryptString($aadhaarClean);
            }

            // ── Best-effort single qualification string (BC) ──────────────────
            $qualString = '';
            if (!empty($validated['qualifications'])) {
                $qualString = $validated['qualifications'][0]['degree'] ?? '';
            }
            $expString = $validated['years_experience'] ?? null;

            // ── Create faculty registration ───────────────────────────────────
            $registration = FacultyRegistration::create([
                'application_no'       => $appNo,
                'name'                 => $fullName,
                'first_name'           => $validated['first_name'],
                'middle_name'          => $validated['middle_name'] ?? null,
                'last_name'            => $validated['last_name'],
                'date_of_birth'        => $validated['date_of_birth'] ?? null,
                'gender'               => $validated['gender'] ?? null,
                'nationality'          => $validated['nationality'] ?? null,
                'blood_group'          => $validated['blood_group'] ?? null,
                'marital_status'       => $validated['marital_status'] ?? null,
                'email'                => $validated['email'],
                'phone'                => $validated['phone'],
                'alternate_phone'      => $validated['alternate_phone'] ?? null,
                'whatsapp_number'      => $validated['whatsapp_number'] ?? null,
                'address'              => $validated['address'] ?? null,
                'city'                 => $validated['city'] ?? null,
                'state'                => $validated['state'] ?? null,
                'postal_code'          => $validated['postal_code'] ?? null,
                'country'              => $validated['country'] ?? 'India',
                'department'           => $validated['department'] ?? null,
                'designation'          => $validated['designation'] ?? null,
                'subjects'             => implode(',', $validated['subjects']), // BC
                'years_experience'     => $expString,
                'current_institution'  => $validated['current_institution'] ?? null,
                'teaching_mode'        => $validated['teaching_mode'] ?? null,
                'professional_summary' => $validated['professional_summary'] ?? null,
                'qualification'        => $qualString,   // BC string
                'experience'           => $expString,    // BC string
                'aadhaar_encrypted'    => $aadhaarEncrypted,
                'status'               => 'pending',
                'submitted_at'         => now(),
            ]);

            // ── Qualifications (repeatable) ───────────────────────────────────
            foreach (($validated['qualifications'] ?? []) as $qual) {
                if (!empty($qual['degree']) && !empty($qual['institution'])) {
                    FacultyRegistrationQualification::create([
                        'faculty_registration_id' => $registration->id,
                        'degree'                  => $qual['degree'],
                        'institution'             => $qual['institution'],
                        'university'              => $qual['university'] ?? null,
                        'specialization'          => $qual['specialization'] ?? null,
                        'passing_year'            => $qual['passing_year'] ?? null,
                        'percentage_cgpa'         => $qual['percentage_cgpa'] ?? null,
                    ]);
                }
            }

            // ── Experiences (repeatable) ──────────────────────────────────────
            foreach (($validated['experiences'] ?? []) as $exp) {
                if (!empty($exp['institution'])) {
                    FacultyRegistrationExperience::create([
                        'faculty_registration_id' => $registration->id,
                        'institution'             => $exp['institution'],
                        'designation'             => $exp['designation'] ?? null,
                        'department'              => $exp['department'] ?? null,
                        'start_date'              => $exp['start_date'] ?? null,
                        'end_date'                => isset($exp['is_current']) ? null : ($exp['end_date'] ?? null),
                        'is_current'              => !empty($exp['is_current']),
                        'responsibilities'        => $exp['responsibilities'] ?? null,
                    ]);
                }
            }

            // ── Documents ─────────────────────────────────────────────────────
            $docMap = [
                'doc_photo'           => ['Profile Photo',                  'photo'],
                'doc_aadhaar'         => ['Aadhaar / Govt. ID',             'aadhaar'],
                'doc_resume'          => ['Resume / CV',                    'resume'],
                'doc_highest_cert'    => ['Highest Qualification Certificate', 'highest_cert'],
                'doc_degree_cert'     => ['Degree Certificate',             'degree_cert'],
                'doc_marksheet'       => ['Marksheet',                      'marksheet'],
                'doc_teaching_cert'   => ['Teaching Certificate',           'teaching_cert'],
                'doc_experience_cert' => ['Experience Certificate',         'experience_cert'],
                'doc_prev_employment' => ['Previous Employment Proof',      'prev_employment'],
                'doc_other'           => ['Other Document',                 'other'],
            ];

            $storageBase = "applications/faculty/{$year}/{$registration->id}";

            foreach ($docMap as $fieldKey => [$label, $docType]) {
                if ($request->hasFile($fieldKey) && $request->file($fieldKey)->isValid()) {
                    $file        = $request->file($fieldKey);
                    $uuid        = Str::uuid()->toString();
                    $ext         = $file->getClientOriginalExtension();
                    $storedPath  = "{$storageBase}/{$uuid}.{$ext}";

                    Storage::disk('local')->put($storedPath, file_get_contents($file->getRealPath()));

                    if ($docType === 'photo') {
                        $registration->update(['photo_path' => $storedPath]);
                    }

                    ApplicationDocument::create([
                        'application_type' => 'faculty',
                        'application_id'   => $registration->id,
                        'document_type'    => $docType,
                        'document_label'   => $label,
                        'original_name'    => $file->getClientOriginalName(),
                        'stored_path'      => $storedPath,
                        'disk'             => 'local',
                        'mime_type'        => $file->getMimeType(),
                        'file_size'        => $file->getSize(),
                        'uploaded_at'      => now(),
                    ]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['general' => 'An error occurred while submitting your application. Please try again. (' . $e->getMessage() . ')']);
        }

        return redirect()->route('register.faculty.success', ['app' => $registration->application_no]);
    }

    /**
     * Show application success page.
     */
    public function success(Request $request)
    {
        $appNo = $request->query('app');
        return view('register.application-success', [
            'appNo' => $appNo,
            'type'  => 'Faculty',
        ]);
    }
}
