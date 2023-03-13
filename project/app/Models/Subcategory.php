<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [ 'category_id', 'name', 'slug', 'image'];
    public $timestamps = false;

    // Child Category Relation 
    public function childs()
    {
    	return $this->hasMany('App\Models\Childcategory')->where('status','=',1);
    }

    // Category Relation 
    public function category()
    {
    	return $this->belongsTo('App\Models\Category')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

    // Product Relation 
    public function products()
    {
        return $this->hasMany('App\Models\Product')->where("price",'!=',0);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    // Comments
    public function attributes() {
        return $this->morphMany('App\Models\Attribute', 'attributable');
    }

}
