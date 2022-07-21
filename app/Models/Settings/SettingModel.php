<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table = 'salary_settings';
    protected  $fillable =['id', 'probMedicalAllowance', 'medicalAllowance', 'probPfEmplyee',
     'probPfEmployer', 'pfEmployee',
        'pfEmployer', 'probEobiEmployee', 'probEobiEmployer', 'eobiEmployee', 'eobiEmployeer'
        ];
    public $timestamps = true;
}
