<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentRegistration;
use App\Models\StudentRegistrationGuardian;
use App\Models\ApplicationDocument;
use App\Models\Course;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Handle the student application form submission.
     */
    public function store(Request $request)
    {
        if (!\App\Models\Setting::get('student_registration_enabled', true)) {
            return back()->withErrors(['email' => 'Student registrations are currently closed.'])->withInput();
        }

        // ── Validation ────────────────────────────────────────────────────────
        $validated = $request->validate([
            // Personal
            'first_name'          => 'required|string|max:100',
            'middle_name'         => 'nullable|string|max:100',
            'last_name'           => 'required|string|max:100',
            'date_of_birth'       => 'required|date|before:today',
            'gender'              => 'required|in:male,female,other,prefer_not',
            'nationality'         => 'required|string|max:100',
            'blood_group'         => 'nullable|string|max:10',
            'category'            => 'nullable|string|max:50',
            'religion'            => 'nullable|string|max:50',

            // Contact
            'email'               => 'required|email|max:255|unique:student_registrations,email|unique:users,email',
            'phone'               => 'required|string|max:20',
            'alternate_phone'     => 'nullable|string|max:20',
            'whatsapp_number'     => 'nullable|string|max:20',
            'permanent_address'   => 'required|string|max:1000',
            'current_address'     => 'required|string|max:1000',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'postal_code'         => 'required|string|max:20',
            'country'             => 'required|string|max:100',

            // Guardian – Primary
            'guardian_primary_name'         => 'required|string|max:255',
            'guardian_primary_relationship' => 'required|string|max:100',
            'guardian_primary_phone'        => 'required|string|max:20',
            'guardian_primary_email'        => 'nullable|email|max:255',
            'guardian_primary_occupation'   => 'nullable|string|max:150',
            'guardian_primary_income'       => 'nullable|string|max:50',

            // Guardian – Secondary (optional)
            'guardian_secondary_name'         => 'nullable|string|max:255',
            'guardian_secondary_relationship' => 'nullable|string|max:100',
            'guardian_secondary_phone'        => 'nullable|string|max:20',
            'guardian_secondary_email'        => 'nullable|email|max:255',
            'guardian_secondary_occupation'   => 'nullable|string|max:150',
            'guardian_secondary_income'       => 'nullable|string|max:50',

            // Guardian – Emergency
            'guardian_emergency_name'         => 'nullable|string|max:255',
            'guardian_emergency_relationship' => 'nullable|string|max:100',
            'guardian_emergency_phone'        => 'nullable|string|max:20',

            // Academic
            'course_id'           => 'required|exists:courses,id',
            'last_institution'    => 'required|string|max:255',
            'board_university'    => 'nullable|string|max:255',
            'last_qualification'  => 'required|string|max:100',
            'passing_year'        => 'required|string|max:10',
            'percentage_cgpa'     => 'required|string|max:20',
            'roll_registration_no'=> 'nullable|string|max:100',
            'stream'              => 'nullable|string|max:100',

            // Identity
            'aadhaar'             => ['nullable', 'string', 'regex:/^\d{4}\s?\d{4}\s?\d{4}$/'],

            // Documents
            'doc_photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'doc_aadhaar'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_birth_cert'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_marksheet_10'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_marksheet_12'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_prev_marksheet'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_transfer_cert'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_migration_cert'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_character_cert'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_other'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // reCAPTCHA
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'email.unique'     => 'This email is already registered or an application is already pending.',
            'course_id.exists' => 'Please select a valid course.',
            'aadhaar.regex'    => 'Aadhaar must be a valid 12-digit number.',
        ]);

        DB::beginTransaction();
        try {
            // ── Derive name fields ────────────────────────────────────────────
            $fullName   = trim("{$validated['first_name']} " . ($validated['middle_name'] ?? '') . " {$validated['last_name']}");
            $course     = Course::find($validated['course_id']);
            $courseStr  = $course?->name ?? '';
            $parentName = $validated['guardian_primary_name'];
            $parentEmail= $validated['guardian_primary_email'] ?? '';

            // ── Application Number ────────────────────────────────────────────
            $year  = date('Y');
            $count = DB::table('student_registrations')->whereYear('created_at', $year)->count() + 1;
            $appNo = sprintf('EDF-STU-%s-%05d', $year, $count);

            // ── Aadhaar encryption ────────────────────────────────────────────
            $aadhaarEncrypted = null;
            if (!empty($validated['aadhaar'])) {
                $aadhaarClean     = preg_replace('/\s+/', '', $validated['aadhaar']);
                $aadhaarEncrypted = Crypt::encryptString($aadhaarClean);
            }

            // ── Create registration record ────────────────────────────────────
            $registration = StudentRegistration::create([
                'application_no'       => $appNo,
                'name'                 => $fullName,
                'first_name'           => $validated['first_name'],
                'middle_name'          => $validated['middle_name'] ?? null,
                'last_name'            => $validated['last_name'],
                'date_of_birth'        => $validated['date_of_birth'],
                'gender'               => $validated['gender'],
                'nationality'          => $validated['nationality'],
                'blood_group'          => $validated['blood_group'] ?? null,
                'category'             => $validated['category'] ?? null,
                'religion'             => $validated['religion'] ?? null,
                'email'                => $validated['email'],
                'phone'                => $validated['phone'],
                'alternate_phone'      => $validated['alternate_phone'] ?? null,
                'whatsapp_number'      => $validated['whatsapp_number'] ?? null,
                'permanent_address'    => $validated['permanent_address'],
                'current_address'      => $validated['current_address'],
                'city'                 => $validated['city'],
                'state'                => $validated['state'],
                'postal_code'          => $validated['postal_code'],
                'country'              => $validated['country'],
                'course_id'            => $validated['course_id'],
                'course'               => $courseStr,  // BC string
                'last_institution'     => $validated['last_institution'],
                'board_university'     => $validated['board_university'] ?? null,
                'last_qualification'   => $validated['last_qualification'],
                'passing_year'         => $validated['passing_year'],
                'percentage_cgpa'      => $validated['percentage_cgpa'],
                'roll_registration_no' => $validated['roll_registration_no'] ?? null,
                'stream'               => $validated['stream'] ?? null,
                'aadhaar_encrypted'    => $aadhaarEncrypted,
                'parent_name'          => $parentName,
                'parent_email'         => $parentEmail,
                'status'               => 'pending',
                'submitted_at'         => now(),
            ]);

            // ── Guardians ─────────────────────────────────────────────────────
            StudentRegistrationGuardian::create([
                'student_registration_id' => $registration->id,
                'guardian_type'           => 'primary',
                'full_name'               => $validated['guardian_primary_name'],
                'relationship'            => $validated['guardian_primary_relationship'],
                'phone'                   => $validated['guardian_primary_phone'],
                'email'                   => $validated['guardian_primary_email'] ?? null,
                'occupation'              => $validated['guardian_primary_occupation'] ?? null,
                'annual_income'           => $validated['guardian_primary_income'] ?? null,
            ]);

            if (!empty($validated['guardian_secondary_name'])) {
                StudentRegistrationGuardian::create([
                    'student_registration_id' => $registration->id,
                    'guardian_type'           => 'secondary',
                    'full_name'               => $validated['guardian_secondary_name'],
                    'relationship'            => $validated['guardian_secondary_relationship'] ?? null,
                    'phone'                   => $validated['guardian_secondary_phone'] ?? null,
                    'email'                   => $validated['guardian_secondary_email'] ?? null,
                    'occupation'              => $validated['guardian_secondary_occupation'] ?? null,
                    'annual_income'           => $validated['guardian_secondary_income'] ?? null,
                ]);
            }

            if (!empty($validated['guardian_emergency_name'])) {
                StudentRegistrationGuardian::create([
                    'student_registration_id' => $registration->id,
                    'guardian_type'           => 'emergency',
                    'full_name'               => $validated['guardian_emergency_name'],
                    'relationship'            => $validated['guardian_emergency_relationship'] ?? null,
                    'phone'                   => $validated['guardian_emergency_phone'] ?? null,
                ]);
            }

            // ── Documents ─────────────────────────────────────────────────────
            $docMap = [
                'doc_photo'          => ['Photo',                  'photo'],
                'doc_aadhaar'        => ['Aadhaar / Govt. ID',     'aadhaar'],
                'doc_birth_cert'     => ['Birth Certificate',       'birth_cert'],
                'doc_marksheet_10'   => ['Class 10 Marksheet',     'marksheet_10'],
                'doc_marksheet_12'   => ['Class 12 Marksheet',     'marksheet_12'],
                'doc_prev_marksheet' => ['Previous Qualification Marksheet', 'prev_marksheet'],
                'doc_transfer_cert'  => ['Transfer Certificate',   'transfer_cert'],
                'doc_migration_cert' => ['Migration Certificate',  'migration_cert'],
                'doc_character_cert' => ['Character Certificate',  'character_cert'],
                'doc_other'          => ['Other Document',         'other'],
            ];

            $storageBase = "applications/student/{$year}/{$registration->id}";

            foreach ($docMap as $fieldKey => [$label, $docType]) {
                if ($request->hasFile($fieldKey) && $request->file($fieldKey)->isValid()) {
                    $file      = $request->file($fieldKey);
                    $uuid      = Str::uuid()->toString();
                    $ext       = $file->getClientOriginalExtension();
                    $storedPath = "{$storageBase}/{$uuid}.{$ext}";

                    Storage::disk('local')->put($storedPath, file_get_contents($file->getRealPath()));

                    // If it's the photo, also set photo_path on registration
                    if ($docType === 'photo') {
                        $registration->update(['photo_path' => $storedPath]);
                    }

                    ApplicationDocument::create([
                        'application_type' => 'student',
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
            return back()
                ->withInput()
                ->withErrors(['general' => 'An error occurred while submitting your application. Please try again. (' . $e->getMessage() . ')']);
        }

        return redirect()->route('register.student.success', ['app' => $registration->application_no]);
    }

    /**
     * Show application success page.
     */
    public function success(Request $request)
    {
        $appNo = $request->query('app');
        return view('register.application-success', [
            'appNo' => $appNo,
            'type'  => 'Student',
        ]);
    }
}
