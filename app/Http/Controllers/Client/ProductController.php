<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail( $slug)
    {
          // Fetch the current product based on the slug
    $product = Product::where('slug', $slug)->first();

    // Fetch related or other products to display alongside
    $relatedProducts = Product::where('id', '!=', $product->id)->get();

    //Pass both product and related products to the view
    return view('client.pages.product_detail', compact('product', 'relatedProducts'));
    }

    public function show($productId)
    {
        // Fetch the product from the database using the product ID
        $product = Product::findOrFail($productId);

        // Return the product detail view with the product data
        return view('client.pages.product_detail', compact('product'));
    }

    public function index()
    {
        $product = Product::all(); // Fetch all products
        
        // Check if products exist, else return an empty array
        return view('client.pages.product_detail', compact('product'));
    }
    
}
