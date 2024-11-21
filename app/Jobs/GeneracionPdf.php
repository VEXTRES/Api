<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\PdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class GeneracionPdf implements ShouldQueue
{
        use Queueable;

        /**
         * Create a new job instance.
         */

        private $pdf;
        public function __construct() {}

        /**
         * Execute the job.
         */
        public function handle(): void
        {
                $this->pdf = new PdfService();
                $data = User::limit(10)->get();
                $view = View::make('pdf.users', compact('data'))->render();
                $pagina = $this->pdf->render($view);
                $this->pdf->saveToStorage('documentos/users.pdf');
                Log::info($pagina);
        }
}
