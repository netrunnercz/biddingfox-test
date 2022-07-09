<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Jobs\GenerateProductHash;

class ProductController extends Controller
{
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
       $validatedValues = $request->validate(['name' => 'required|max:255']);
       
       $product = new Product;
			 $product->name = $validatedValues['name'];
			 $product->save();
       
       GenerateProductHash::dispatch($product);
       
       return response()->json(['name' => $product->name, 'id' => $product->id]);
    }
}
