<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rarity;

class RarityController extends Controller
{
    public function index() {
        $rarities = Rarity::all();

        return $rarities;
    }
}
