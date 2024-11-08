<?php

use App\Console\Commands\SendEmails;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;



Schedule::command(SendEmails::class, [10001])->everyMinute();
