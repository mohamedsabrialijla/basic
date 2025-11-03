<?php
// app/Models/GanttTask.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanttTask extends Model
{
    protected $fillable = [
        'parent', 'number', 'text', 'duration',
        'reference', 'quantity', 'uom', 'unit_price', 'total_price','section_id','rfp_id'
    ];



    public function questions()
{
    return $this->morphMany(Question::class, 'questionable');
}

}
