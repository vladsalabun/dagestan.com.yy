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
    
    // Назва батьківської категорії:
    public function get_parent_name($id)
    {
        $q = AdsCategories::where('id',$id)->first();
        $q_parent = AdsCategories::where('id',$q->parent_id)->first();
        return $q_parent->name;
    }
    // Дерево категорий:
    public function get_tree()
    {   
        
        $q = AdsCategories::where('parent_id',0)->get();
        
        if ($q != null) {
            foreach ($q as $key => $value) {
                $q_sub = AdsCategories::where('parent_id',$value->id)->get();
                if ($q_sub != null) {
                    
                    $array[$value->name] = array();
                    
                    foreach ($q_sub as $key_sub => $value_sub) {
                        $array[$value->name][$value_sub->id] = $value_sub->name;
                    }
                }
                
            }
        } else {
           $array = array(); 
        }        
        
        return $array;
    }
    
}
