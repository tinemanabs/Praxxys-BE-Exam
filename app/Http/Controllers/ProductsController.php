<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function create()
    {
        return view('auth.features.products.create');
    }
}
