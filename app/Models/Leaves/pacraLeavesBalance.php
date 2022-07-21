<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class pacraLeavesBalance extends Model
{
    protected $table = 'pacra_leaves_balance';
    protected $fillable = ['id', 'user_id', 'current_balance', 'last_updated_by'];
    public $timestamps = true;
}
