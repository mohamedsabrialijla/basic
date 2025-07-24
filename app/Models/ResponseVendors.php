<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ResponseVendors extends Model
{
    protected $fillable = ['response', 'rfp_id'];

 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




}


