<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    Public function index(Request $request)
    {
        logger('peticion',[$request->all()]);
        $products = Product::with(['category', 'currency',])->get();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
