<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Setting;
use App\Models\Student;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendTelegramDailyAlerts extends Command
{
    protected $signature   = 'telegram:daily-alerts';
    protected $description = 'Send automated daily Telegram alerts: low attendance warnings and fee reminders.';

    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    public function handle(): int
    {
        if (! Setting::get('telegram_enabled', true)) {
            $this->info('Telegram notifications are disabled. Skipping.');
            return 0;
        }

        $this->info('[' . now() . '] Running Telegram daily alerts...');

        $this->sendLowAttendanceWarnings();
        $this->sendPendingFeeReminders();

        $this->info('Daily Telegram alerts dispatched successfully.');
        return 0;
    }

    /**
     * Check all students with overall attendance < 75% and notify.
     */
    protected function sendLowAttendanceWarnings(): void
    {
        $this->info('Checking low attendance...');
        $count = 0;

        Student::with(['user', 'parents', 'course'])->each(function (Student $student) use (&$count) {
            // Calculate attendance percentage
            $total = Attendance::where('student_id', $student->id)
                ->whereHas('subject', fn($q) => $q->where('course_id', $student->course_id))
                ->count();

            if ($total === 0) return;

            $present = Attendance::where('student_id', $student->id)
                ->whereHas('subject', fn($q) => $q->where('course_id', $student->course_id))
                ->where('present', 1)
                ->count();

            $percentage = round(($present / $total) * 100, 1);

            if ($percentage >= 75) return;

            // Warn student
            if ($student->user && $student->user->telegram_chat_id) {
                $this->telegram->sendMessage(
                    $student->user->telegram_chat_id,
                    "⚠️ *Low Attendance Alert*\n\nHello {$student->user->name},\n\nYour current attendance is *{$percentage}%*, which is below the required *75%*.\n\nPlease attend classes regularly to avoid academic penalties.",
                    'low_attendance',
                    'student',
                    $student->user->id
                );
                $count++;
            }

            // Warn parents
            foreach ($student->parents as $parent) {
                if ($parent->telegram_chat_id) {
                    $this->telegram->sendMessage(
                        $parent->telegram_chat_id,
                        "⚠️ *Low Attendance Warning*\n\nDear Parent,\n\nYour child *{$student->user->name}* has an attendance of *{$percentage}%*, which is below the required 75%.\n\nPlease encourage regular class attendance.",
                        'low_attendance',
                        'parent',
                        $parent->id
                    );
                    $count++;
                }
            }
        });

        $this->info("Low attendance warnings sent: {$count}");
    }

    /**
     * Check all students with pending fee payments and send reminders.
     */
    protected function sendPendingFeeReminders(): void
    {
        $this->info('Checking pending fees...');
        $count = 0;

        // Get all fees that are due
        $dueFees = Fee::where('due_date', '<=', now()->addDays(3))
            ->get();

        if ($dueFees->isEmpty()) {
            $this->info('No due fees found.');
            return;
        }

        Student::with(['user', 'parents', 'course'])->each(function (Student $student) use ($dueFees, &$count) {
            foreach ($dueFees as $fee) {
                // Skip if this fee isn't for the student's course (or is global)
                if ($fee->course_id && $fee->course_id !== $student->course_id) continue;

                // Check if student already paid
                $paid = FeePayment::where('student_id', $student->id)
                    ->where('fee_id', $fee->id)
                    ->where('status', 'completed')
                    ->exists();

                if ($paid) continue;

                $dueDate = $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : 'N/A';

                // Notify student
                if ($student->user && $student->user->telegram_chat_id) {
                    $this->telegram->sendMessage(
                        $student->user->telegram_chat_id,
                        "💰 *Fee Payment Reminder*\n\nHello {$student->user->name},\n\nYour fee *{$fee->title}* of ₹{$fee->amount} is due on *{$dueDate}*.\n\nPlease clear your dues to avoid penalties.",
                        'fee_reminder',
                        'student',
                        $student->user->id
                    );
                    $count++;
                }

                // Notify parents
                foreach ($student->parents as $parent) {
                    if ($parent->telegram_chat_id) {
                        $this->telegram->sendMessage(
                            $parent->telegram_chat_id,
                            "💰 *Fee Reminder*\n\nDear Parent,\n\nFee payment *{$fee->title}* (₹{$fee->amount}) for your child *{$student->user->name}* is due on *{$dueDate}*.\n\nKindly ensure timely payment.",
                            'fee_reminder',
                            'parent',
                            $parent->id
                        );
                        $count++;
                    }
                }
            }
        });

        $this->info("Fee reminders sent: {$count}");
    }
}
