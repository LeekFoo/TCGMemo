<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Symbol;

class SymbolController extends Controller
{
    public function index() {
        $symbols = Symbol::all();

        return $symbols;
    }
}
