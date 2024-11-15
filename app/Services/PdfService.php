<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
    protected $binary;

    protected $path;

    public function __construct()
    {
        $this->binary = config('services.chrome.path');
    }


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
        return $this->path;
    }

    public function download($filename)
    {
        try {
            return response()->download($this->path, $filename);
        } catch (Exception $exception) {
            Log::error('Error al descargar el PDF: ', $exception);
        }
    }
        //para ver en vivo la pantalla del pdf
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
    public function saveToStorage($filename)
    {
        try {
            // Obtén el contenido del archivo PDF
            $pdfContent = file_get_contents($this->path);

            // Guarda el contenido en el almacenamiento de Laravel
            Storage::disk('public')->put($filename, $pdfContent);

            return true;
        } catch (Exception $exception) {
            Log::error('Error al guardar el PDF en el almacenamiento: ', $exception);
            return false;
        }
    }
}
