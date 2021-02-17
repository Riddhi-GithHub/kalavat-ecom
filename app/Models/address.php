<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\address;

class address extends Model
{
    protected $table="addresses";
    protected $primaryKey="address_id";
    protected $fillable=['address_id','user_id','address','city','state','zip_code','contry'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

     public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
