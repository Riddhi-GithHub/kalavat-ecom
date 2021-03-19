<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $table="product_details";
    protected $primaryKey="id";
    protected $fillable=['id','product_id','title','description'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'created_at','updated_at'
    // ];

     public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
