<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserNotificationPdf;
use Illuminate\Console\Command;

class SendEmailPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email {user}';

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
        $user->notify(new UserNotificationPdf($user));
        $this->info('Correo enviado');
    }
}
