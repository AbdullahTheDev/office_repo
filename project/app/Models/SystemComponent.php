<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemComponent extends Model
{
    protected $fillable = ['subcategory_id','name','multiple_products', 'sort', 'status'];

    public function subcategory()
    {
    	return $this->belongsTo('App\Models\Subcategory');
    }

}
