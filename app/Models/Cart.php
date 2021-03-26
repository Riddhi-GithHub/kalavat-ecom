<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\OrderDetails;
use App\User;

class Cart extends Model
{
    protected $table="carts";
    protected $primaryKey="cart_id";
    protected $fillable=['cart_id','product_id','user_id','color','size','quantity','sub_total_price','status'];
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

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderdetail(){
        return $this->belongsTo(OrderDetails::class,'order_cart_id');
    }
}
