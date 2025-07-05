<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Approve extends Model
{
    protected $fillable = ['status', 'rfp_id', 'type', 'deadline', 'date_approved'];

    protected $appends=['created'];
 
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

    public function getCreatedAttribute(){
        return Carbon::parse($this->created_at)->format('F d, Y');
    }

   


    
    
    


    
   
    






}


