<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run dropout risk evaluation every day at midnight
Schedule::command('risk:evaluate')->daily()->withoutOverlapping();

// Send daily Telegram alerts at 9:00 AM (low attendance + fee reminders)
Schedule::command('telegram:daily-alerts')->dailyAt('09:00')->withoutOverlapping();

