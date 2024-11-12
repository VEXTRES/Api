<?php

namespace App\Http\Controllers;

use App\Jobs\GeneracionPdf;
use App\Models\User;
use App\Services\PdfService;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    protected $pdf;

    public function __construct(PdfService $pdf)
    {
        $this->pdf = $pdf;
    }

    public function index()
    {
        //$this->pdf = new PdfService();

        $data = User::limit(10)->get();
        $view = View::make('pdf.users', compact('data'))->render();

        $this->pdf->render($view);
        //return $this->pdf->download('test.pdf');

        return $this->pdf->saveToStorage('test.pdf');
        //GeneracionPdf::dispatch();
    }
}
