<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','photo','is_featured','footer_link','header_link','image','img1','link1','img2','link2','img3','link3','img4','link4','img5','link5','img6','link6','img7','link7','meta_title','meta_keywords','meta_description'];
    public $timestamps = false;

    public function subs()
    {
    	return $this->hasMany('App\Models\Subcategory')->where('status','=',1);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function attributes() {
        return $this->morphMany('App\Models\Attribute', 'attributable');
    }

    public function menu() {
        return $this->hasOne('App\Models\Menu', 'category_id');
    }
}
