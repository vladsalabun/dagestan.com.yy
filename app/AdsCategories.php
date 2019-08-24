<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsCategories extends Model
{
    protected $table = 'ads_categories';
    public $timestamps = false;
    
    // Get ads by category:
    public function ads()
    {   
        return $this->belongsToMany('App\Ads', 'ads_has_categories', 'category_id', 'ad_id');
    }
}
