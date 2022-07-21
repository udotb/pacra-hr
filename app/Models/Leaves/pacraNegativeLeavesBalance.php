<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class pacraNegativeLeavesBalance extends Model
{
    protected $table = 'pacra_negative_leaves';
    protected  $fillable =['id', 'user_id', 'negative_balance', 'remaining_negative_balance'];
    public $timestamps = true;
}
