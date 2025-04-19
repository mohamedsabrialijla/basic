<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use SoftDeletes;

 
    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }

   


    
    
    

    public function category()
    {
        return $this->belongsTo(ItemsCategories::class,'category_id');
    }
    
 
    public function zone()
    {
        return $this->belongsTo(ItemsObjects::class,'zone_id');
    }


    public function client()
    {
        return $this->belongsTo(ItemsObjects::class,'client_id');
    }


    public function manager()
    {
        return $this->belongsTo(Employee::class,'manager_id');
    }



    
   
    






}


