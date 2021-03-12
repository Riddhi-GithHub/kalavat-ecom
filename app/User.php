<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\address;
use App\Models\ContactUs;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'fullname','username', 'email','gender',
        'is_admin','is_delete','status','mobile','otp','otp_verify',
        'token','user_token','address','city','state','zip_code','contry'
    ];

    
    public function address(){
        return $this->hasOne(address::class,'user_id');
    }

    public function contact(){
        return $this->hasOne(ContactUs::class,'user_id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
