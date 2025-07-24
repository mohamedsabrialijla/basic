<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Approve extends Model
{
    protected $fillable = ['status', 'rfp_id', 'type', 'deadline', 'date_approved'];

    protected $appends=['dead','approv','disable'];
 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getdeadAttribute(){
        if($this->deadline && $this->deadline!= null){
            return Carbon::parse($this->deadline)->format('F d, Y');
        }else{
            return '';
        }
        
    }



     public function getApprovAttribute(){
        return Carbon::parse($this->date_approved)->format('F d, Y');
    }

      public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }


    public function getDisableAttribute(){
        
        $id = auth('sanctum')->id();
        if($this->user_id == $id){
            return 1;
        }else{
            return 0;
        }
    }

   


    
    
    


    
   
    






}


