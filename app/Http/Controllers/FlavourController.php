<?php

namespace App\Http\Controllers;

use App\Models\Flavour;
use Illuminate\Http\Request;

class FlavourController extends Controller
{
    public function show(Flavour $flavour)
    {
        $products = $flavour->products()->paginate(12);
        return view('flavours.show', compact('flavour', 'products'));
    }
}