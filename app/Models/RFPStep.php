<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RFPStep extends Model
{
    use SoftDeletes;


    // protected $casts = [
    //     'commercial_commite' => 'array',
    // ];

 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }


    public function sections(){

        return $this->hasMany(RFPWord::class, 'rfp_id');
    }

     public function category()
    {
        return $this->belongsTo(ItemsCategories::class,'category_id');
    }


     public function contract()
    {
        return $this->belongsTo(ItemsCategories::class,'contract_id');
    }


     public function type_event()
    {
        return $this->belongsTo(ItemsCategories::class,'type_event_id');
    }


   


    
    
    


    
   
    






}


