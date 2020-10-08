<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Title;

class TitleController extends Controller
{
    public function index() {
        $titles = Title::all();

        return $titles;
    }
}
