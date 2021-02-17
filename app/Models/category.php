<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{

    protected $table = 'categories';
    protected $fillable = [
       'cat_name','id'
   ];


    public function product(){
        return $this->hasMany(product::class,'cat_id');
    }
}
