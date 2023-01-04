<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = "menu";
    protected $fillable = ['category_id','name','img_1','link_1','img_2','link_2','sort'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function sub_categories()
    {
        return Subcategory::where("category_id",$this->category_id)->get();
    }

    public function cat()
    {
        return Category::select("slug")->where("id",$this->category_id)->first();
    }

    public function brands()
    {
        return Partner::where("menu_id",$this->id)->leftJoin("menu_brands","menu_brands.brand_id","partners.id")->get();
    }


}