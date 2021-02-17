<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ContactUs extends Model
{
    protected $table = 'contact_us';
    protected $fillable = [
       'user_id','title','description',
   ];

   public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
