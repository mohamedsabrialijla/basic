<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


// here custom
// Relation::morphMap([
//     'product' => 'App\Models\Product',
//     'service' => 'App\Models\Service',
// ]);


class Status extends Model
{
    use SoftDeletes;

    public $table = 'Status';
    // protected $fillable = ['Statustable_id', 'Statustable_type', 'Status', 'EmployeeID', 'RoleName' ,'DueDate','type' , 'Overdue', 'project_id','cycle','TaskProjectActivityID','TaskProjectID','ProjectsTemplateID','TaskProjectActivitySubActivityID'];



    public function Statustable()
    {
        return $this->morphTo();
    }

 



    

}
