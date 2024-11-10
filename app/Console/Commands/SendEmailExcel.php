<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserNotificationExcel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmailExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usuario = $this->argument('user');

        $user = User::find($usuario);

        $user->notify(new UserNotificationExcel($user));
        $this->info('Correo enviado');
    }
}
