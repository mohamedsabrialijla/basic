<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{

    // protected $appends=['dead','approv'];
 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFileAttribute($value)
    {
        return url($value);
        
    }


   


    //  public function getApprovAttribute(){
    //     return Carbon::parse($this->date_approved)->format('F d, Y');
    // }

     
    
    


    
   
    






}


