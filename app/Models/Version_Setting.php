<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version_Setting extends Model
{
    protected $table = 'version_setting';
    protected $fillable = [
       'app_version'
   ];
}
