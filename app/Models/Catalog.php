<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Catalog extends Model
{
    protected $table = 'catalogs';
    protected $fillable = [
        'catalog_title','catalog_description','catalog_image','product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
}
