<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'rfp_id',
        'questionable_id',
        'questionable_type',
        'question',
        'answer',
        'status',
    ];

    public function questionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
