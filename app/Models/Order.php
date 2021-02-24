<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\User;

class Order extends Model
{
    protected $table="orders";
    protected $primaryKey="order_id";
    protected $fillable=['order_id','product_id','user_id','tracking_num','quantity','total_price','delivery_date','status'];
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
}
