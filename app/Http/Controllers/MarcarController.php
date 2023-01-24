<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarcarController extends Controller
{
    public function marcar() {
        return view('app.marcar');
    }
}
