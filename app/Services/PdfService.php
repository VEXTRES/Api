<?php

namespace App\Services;

use App\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
    protected $binary = '/Applications/Chromium.app/Contents/MacOS/Chromium';

    /**
     * Render the PDF.
     *
     * @param  \App\Invoice  $invoice
     * @return string
     */
    public function render(User $user)
    {
        $view = View::make('pdf.users', compact('user'))->render();

        $process = new Process(sprintf(
            $this->command,
            escapeshellarg($this->binary),
            escapeshellarg($path = tempnam(sys_get_temp_dir(), Str::random())),
            escapeshellarg('data:text/html,' . rawurlencode($view))
        ));

        try {
            $process->mustRun();

            return File::get($path);
        } catch (ProcessFailedException $exception) {
            //
        }
    }
}
