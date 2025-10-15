<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CategoryTitleTechnical extends Model
{

   
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }

    public function file()
    {
        return $this->hasOne(CriteriaDocument::class,'feature_id');
    }



    public function features_value() {
        return $this->hasMany(CategoryFeatureTechnical::class, 'title_id');
    }


   
   
    






}


