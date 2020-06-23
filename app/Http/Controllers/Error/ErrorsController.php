<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;

class ErrorsController extends Controller
{

    public function Timeout()
    {

        return view('ErrorPages.TimeoutPage');
    }
}
