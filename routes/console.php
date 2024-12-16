<?php

use App\Console\Commands\SendEmailPdf;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

try {
    $data = User::where('email', '=', 'uriel.ss@hotmail.com')->firstOrFail();

    Schedule::command(SendEmailPdf::class, [$data->id])->saturdays()->at('16:00');
} catch (\Exception $e) {
}
