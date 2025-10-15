<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CriteriaDocument extends Model
{
    protected $fillable = ['status', 'rfp_id', 'file', 'feature_id','user_id'];

 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


   
    
    
    


    
   
    






}


