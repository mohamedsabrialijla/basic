<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ItemsModelsResource extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['code', 'order_by'];
    protected $hidden = [  'pivot', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name','description'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function getCreatedAtAttribute($value){
        return date('Y-m-d H:i', strtotime($value));
    }

    public function type()
    {
        return $this->belongsTo(ItemsTypes::class,'type_id');
    }


    public function type_resource()
    {
        return $this->belongsTo(ItemsTypesResource::class,'type_resource_id');
    }

    
    

    public function category()
    {
        return $this->belongsTo(ItemsCategories::class,'category_id');
    }
    


    public function class()
    {
        return $this->belongsTo(ItemsClassesResource::class,'class_id');
    }



    public function vendor()
    {
        return $this->belongsTo(ItemsObjects::class,'vendor_id');
    }

 
    public function unit_of_measurement()
    {
        return $this->belongsTo(ItemsObjects::class,'units_of_measurement_id');
    }


    public function drawing()
    {
        return $this->belongsTo(ItemsObjects::class,'drawing_id');
    }


     public function getLogoAttribute($value)
    {
        return url($value);
        
    }


    
   
    






}


