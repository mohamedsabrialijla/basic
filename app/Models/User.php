<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['role','permission','role_name','document'];



    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function getRoleAttribute()
    {
        
        $role = ModelHasRole::where('model_id', $this->id)->pluck('role_id')->first();
        $Permissions = role_has_permissions::where('role_id',$role)->pluck('permission_id')->toArray();
        $per = Permission::whereIn('id',$Permissions)->pluck('name')->toArray();
        
        return $per;
    }

     public function getPermissionAttribute()
    {
        $p = ModelHasRole::where('model_id',$this->id)->first();
        return $p ;
        
    }

    public function getRoleNameAttribute()
    {
        $p = ModelHasRole::where('model_id',$this->id)->first();
        if($p != '')
            return Role::where('id',$p->role_id)->first();
        return '';
        
    }


    public function getLogoAttribute($value)
    {
        return url($value);
        
    }


    public function getCreatedAtAttribute($value){
        return date('Y-m-d', strtotime($value));
    }


    public function getDocumentAttribute() {
    $raw = $this->attributes['documents'] ?? '[]';

    // تحويل JSON string إلى array ثم إلى أرقام
    $ids = array_map('intval', json_decode($raw, true));

    return ItemsCategories::whereIn('id', $ids)->get();
}



}
