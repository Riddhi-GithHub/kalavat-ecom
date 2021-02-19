<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;

class product_images extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $fillable = ['product_id','images'];
    
	public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    } 

    public function products()
    {
        return $this->belongsTo('App\Models\Product',"id","id");
    }
}
