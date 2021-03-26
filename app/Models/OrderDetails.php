<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Cart;
use App\User;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table="order_details";
    protected $primaryKey="order_detail_id";
    protected $fillable=['order_detail_id','order_user_id','order_product_id','quantity','total_order_price','delivery_date','order_status'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

     public function product(){
        return $this->belongsTo(Product::class,'order_product_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function cart(){
        return $this->belongsTo(Cart::class,'order_cart_id');
    }

}
