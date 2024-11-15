<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\UserNotificationExcel;
use Illuminate\Support\Facades\Log;

class EnviarEmail implements ShouldQueue
{
    use Queueable;


    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->user->notify(new UserNotificationExcel($this->user));
    }
}
