<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DropoutRiskService;
use App\Models\Student;

class EvaluateDropoutRisk extends Command
{
    protected $signature   = 'risk:evaluate {--student= : Evaluate a specific student ID}';
    protected $description = 'Evaluate dropout risk scores for all (or one) student(s).';

    public function handle(DropoutRiskService $service): void
    {
        if ($id = $this->option('student')) {
            $service->evaluate((int) $id);
            $this->info("✅ Risk evaluated for student #{$id}.");
            return;
        }

        $students = Student::all();
        $bar = $this->output->createProgressBar($students->count());
        $bar->start();

        foreach ($students as $student) {
            $service->evaluate($student->id);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Dropout risk evaluation complete for all students.');
    }
}
