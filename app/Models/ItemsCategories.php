<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ItemsCategories extends Model
{
    use SoftDeletes, Translatable;
    protected $with = ['criteria'];
    protected $appends = ['users'];
    protected $fillable = ['code', 'order_by'];
    protected $hidden = [  'pivot', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name'];

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


    public function getUsersAttribute() {
       
        $raw = $this->attributes['users'] ?? '[]';
        $ids = array_map('intval', json_decode($raw, true));
        return User::whereIn('id', $ids)->get();
        
    }

    public function features() {
        return $this->hasMany(CategoryTitle::class, 'items_category_id');
    }


    public function criteria() {
    $rfp_id = Request::get('rfp_id'); // أو Request::input('rfp_id')
    $user_id = auth('sanctum')->id();

    return $this->hasOne(Document::class, 'criteria_id')
                ->where('user_id', $user_id)
                ->where('rfp_id', $rfp_id);
}
    
   
    






}


