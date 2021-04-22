<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Catalog;
use App\User;

class Favourites extends Model
{
    protected $table="favourites";
    protected $primaryKey="fav_id";
    protected $fillable=['fav_id','product_id','catalog_id','user_id','status'];
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

    public function catalog(){
        return $this->belongsTo(Catalog::class,'catalog_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
