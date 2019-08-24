<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';
    public $timestamps = false;

    // Get all ad stars:
    public function stars()
    {
        return $this->hasMany('App\UserStars', 'ad_id', 'id');
    }
    
    // Get all ad categories:
    public function categories()
    {
        return $this->belongsToMany('App\AdsCategories', 'ads_has_categories', 'ad_id', 'category_id');
    }
    
}
