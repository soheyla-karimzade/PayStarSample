<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function products(){
        $products = Product::all();
        return view('products',['products'=>$products]);
    }

    public function Product( $id){
        $product=DB::table('products')->find($id);
        return view('product',['product'=>$product]);
    }
}
