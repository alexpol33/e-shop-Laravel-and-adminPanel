<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($cat, $prod_id){
        $item =  Product::find($prod_id);

        return view('product.show', compact('item'));
    }

    public function showCategory(Request $request, $cat_alias){
        $cat = Category::where('alias', $cat_alias)->first();

        $products = Product::where('category_id', $cat->id)->get();

        if(isset($request->orderBy)){
            if($request->orderBy == 'price-low-high'){
                $products = Product::where('category_id', $cat->id)->orderBy('price')->get();
            }
            if($request->orderBy == 'price-high-low'){
                $products = Product::where('category_id', $cat->id)->orderBy('price', 'desc')->get();
            }
            if($request->orderBy == 'name'){
                $products = Product::where('category_id', $cat->id)->orderBy('title')->get();
            }
        }

        if($request->ajax()){
            return view('ajax.order-by', compact('products'))->render();
        }

        return view('categories.show', compact('cat'));
    }
}
