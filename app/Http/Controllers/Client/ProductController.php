<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail( $slug)
    {
        
    $product = Product::where('slug', $slug)->first();

   
    $relatedProducts = Product::where('id', '!=', $product->id)->get();

 
    return view('client.pages.product_detail', compact('product', 'relatedProducts'));
    }

    public function show($productId)
    {
      
        $product = Product::findOrFail($productId);

      
        return view('client.pages.product_detail', compact('product'));
    }

    public function index()
    {
        $product = Product::all(); 
        
        
        return view('client.pages.product_detail', compact('product'));
    }
    
}
