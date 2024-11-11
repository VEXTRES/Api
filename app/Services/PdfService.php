<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class PdfService
{
    /**
     * The command.
     * 
     * @var string
     */
    protected $command = '%s --headless --disable-gpu --print-to-pdf=%s %s 2>&1';

    /**
     * The binary.
     * 
     * @var string
     */
    protected $binary = '/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome';

    protected $path;


    /**
     * Render the PDF.
     *
     * @param  \App\Invoice  $invoice
     * @return string
     */
    public function render(String $view)
    {

        $viewpath = tempnam(sys_get_temp_dir(), Str::random()) . '.html';
        file_put_contents($viewpath, $view);


        $this->path = tempnam(sys_get_temp_dir(), Str::random());

        Process::run(sprintf(
            $this->command,
            $this->binary,
            escapeshellarg($this->path),
            $viewpath,
        ));
    }

    public function download($filename)
    {
        try {
            return response()->download($this->path, $filename);
        } catch (Exception $exception) {
            Log::error('Error al descargar el PDF: ', $exception);
        }
    }

    public function stream($filename)
    {
        try {
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => ('inline') . "; filename=" . $filename
            ];
            return response()->file($this->path, $headers);
        } catch (Exception $exception) {
            Log::error('Error al mostrar el PDF: ', $exception);
        }
    }
}
