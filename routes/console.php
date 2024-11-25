<?php

use App\Console\Commands\SendEmails;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;



$data = User::where('email', '=', 'uriel.ss@hotmail.com')->first();

Schedule::command(SendEmails::class, [$data->id])->everyMinute();
