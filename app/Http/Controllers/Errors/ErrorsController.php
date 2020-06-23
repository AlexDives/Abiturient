<?php

namespace App\Http\Controllers\Errors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ErrorsController extends Controller
{

    public function Timeout()
    {
        return view('ErrorPages.TimeoutPage');
    }
}
