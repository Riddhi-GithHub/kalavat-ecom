<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class Rating_images extends Model
{
    protected $table = 'rating_images';
    protected $primaryKey = 'id';
    protected $fillable = ['rating_id','images'];
    
	public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    } 

    public function ratings()
    {
        return $this->belongsTo('App\Models\Rating',"id","id");
    }
}
