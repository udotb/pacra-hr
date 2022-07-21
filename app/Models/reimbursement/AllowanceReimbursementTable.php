<?php

namespace App\Models\Reimbursement;

use Illuminate\Database\Eloquent\Model;

class AllowanceReimbursementTable extends Model
{
    protected $table = 'allowance_reimbursement';
    protected $fillable = ['user_id', 'user_grade', 'dated', 'from_date', 'to_date', 'type', 'description',
        'client', 'attachment', 'status', 'approved_by', 'actual', 'amount', 'paid_status', 'travel_type', 'medical_type', 'other_client', 'decline_reason', 'other_amount'];
}
