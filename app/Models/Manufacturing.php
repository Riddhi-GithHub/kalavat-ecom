<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    protected $table="manufacturings";
    protected $primaryKey="id";
    protected $fillable=['id','product_id','address','city','state','zip_code','contry','manufacture_by','manufacture_date'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

     public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
