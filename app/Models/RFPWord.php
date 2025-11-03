<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RFPWord extends Model
{
    use SoftDeletes;

 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }


    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }


   


    
    
    


    
   
    






}


