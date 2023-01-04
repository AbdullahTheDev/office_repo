<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SystemComponent;
use Session;

class SystemBuilderController extends Controller
{

    public function index()
    {
        $cmps = SystemComponent::with("subcategory")->where("status",1)->orderBy("sort","asc")->get();
        $components = $cart_components = [];

        if (!empty(Session::get('cart'))) {
            $cart_components = collect(Session::get('cart')->items)->pluck("item")->pluck("id");
        }
        
        $products = Product::with("user")->whereIn("id",$cart_components)->get();
        
        
        if (!empty($cmps)) {
            foreach ($cmps as $component) {
                $p = $products->where("subcategory_id",$component->subcategory_id); 
                $components[] = [
                    "component" => $component,
                    "products" => $p
                ];
            }
        }

        // dd($components);

        return view('front.system_builder',compact("components")); 
    }

}
