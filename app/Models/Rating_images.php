<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;
use App\Models\Catalog_rating;

class Rating_images extends Model
{
    protected $table = 'rating_images';
    protected $primaryKey = 'id';
    protected $fillable = ['rating_id','catalog_rating_id','images'];
    
	public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    } 

    public function catalograting()
    {
        return $this->belongsTo(Catalog_rating::class, 'catalog_rating_id');
    }

    // public function ratings()
    // {
    //     return $this->belongsTo('App\Models\Rating',"id","id");
    // }
}
