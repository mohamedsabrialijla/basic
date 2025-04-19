<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use SoftDeletes;

    protected $appends = ['full_name'];


    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }

    public function Position()
    {
        return $this->belongsTo(Position::class,'position_id');
    }


    public function getFullNameAttribute(){
        return $this->first_name .' '.$this->middle_name.' '. $this->last_name ;
    }

    public function getLogoAttribute($value)
    {
        return url($value);
        
    }

    
   
    






}


