<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = [
       'sale_title','sale_description','sale_end_date'
   ];

    public function product(){
        return $this->hasMany(Product::class,'sale_id');
    }
}
