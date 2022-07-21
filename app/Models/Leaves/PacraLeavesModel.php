<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class PacraLeavesModel extends Model
{
    protected $table = 'pacra_leaves';
    protected  $fillable =['id', 'user_id', 'leave_type', 'from_date', 'to_date', 'leave_days',
        'existing_balance', 'new_balance', 'reason', 'file', 'status', 'approved_by', 'recommend_by', 'is_edited'];
    public $timestamps = true;
}