<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;  
use App\Models\Category; 
use App\Models\Currency;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los productos con su categoría y mostramos la vista
        $products = Product::with(['currency','category'])->get(); 
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $categories = Category::all();
      $currencies = Currency::all();
      return view('products.create', compact('categories','currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'category_id'=>'required|exists:categories,id',
            'currency_id'=>'required|exists:currencies,id'
        ]);

        Product::create($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $currencies = Currency::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'currency_id' => 'required|exists:currencies,id'
        ]);

        $product->update($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}