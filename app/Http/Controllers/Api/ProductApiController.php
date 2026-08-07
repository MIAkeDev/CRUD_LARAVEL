<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // 1. LISTAR
    public function index(Request $request)
    {
        logger('peticion', [$request->all()]);
        
        $products = Product::with(['category', 'currency'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    // 2. CREAR
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producto creado con éxito',
            'data' => $product
        ]);
    }

    // 3. EDITAR
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente'
        ]);
    }

    // 4. ELIMINAR
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente'
        ]);
    }
}