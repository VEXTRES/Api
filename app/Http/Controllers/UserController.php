<?php

namespace App\Http\Controllers;

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

        $data = User::get();
        $view = View::make('pdf.users', compact('data'))->render();

        $this->pdf->render($view);
        //return $this->pdf->download('test.pdf');

        return $this->pdf->stream('test.pdf');
    }
}
