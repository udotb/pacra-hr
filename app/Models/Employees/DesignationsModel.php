<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class DesignationsModel extends Model
{
    
    protected $table = 'og_designations';
    protected  $fillable =['id', 'title','status', 'isActive', 'last_updated_by'];
    public $timestamps = true;
}
