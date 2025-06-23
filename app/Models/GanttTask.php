<?php
// app/Models/GanttTask.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanttTask extends Model
{
    protected $fillable = [
        'parent', 'number', 'text', 'duration',
        'reference', 'quantity', 'uom', 'unit_price', 'total_price'
    ];
}
