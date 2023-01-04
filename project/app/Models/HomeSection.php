<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $table = 'home_sections';
    public $timestamps = false;

    public static function products($id,$type,$category = 0,$subcat = 0,$childcat = 0)
    {   
    	if($type == "products"){
    	    return \Cache::remember($id, 60, function() use ($id){ 
    		    return Product::with('category')->leftJoin("section_products","section_products.product_id","products.id")->where('price','!=',0)->where("status",1)->where("section_id",$id)->take(12)->get();
    		});
    	}
    	if($type == "category"){
            if($subcat != "" || $subcat != 0){
                return \Cache::remember($id, 60, function() use ($subcat){
                    return Product::with('category')->where("status",1)->where('price','!=',0)->where('subcategory_id', $subcat)->take(12)->get();
                });
            }
            if($childcat != "" || $childcat != 0){
                return \Cache::remember($id, 60, function() use ($childcat){
                    return Product::with('category')->where("status",1)->where('price','!=',0)->where('childcategory_id', $childcat)->take(12)->get();
                });
            }
    		return \Cache::remember($id, 60, function() use ($category){ 
    		    return Product::with('category')->where("status",1)->where('price','!=',0)->where('category_id', $category)->take(12)->get();
    		});
    	}
        return [];
    }
}
