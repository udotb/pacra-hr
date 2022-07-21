<?php

namespace App\Models\Resignation;

use Illuminate\Database\Eloquent\Model;

class PacraSeparation extends Model
{
    protected $table = 'pacra_emp_separation';
    protected  $fillable =['id', 'user_id', 'resign_id', 'emp_reason_short_notice', 'emp_check_list', 'date_by_emp', 'section_two_name',
        'section_two_designation', 'section_two_date', 'section_two_comment', 'commentShortNotice' 
        , 'section_two_check_list'
        , 'section_three_name', 'section_three_designation', 'section_three_date', 'section_three_comment', 'section_three_check_list'
        , 'section_four_name', 'section_four_designation', 'section_four_date', 'section_four_comment', 'section_four_check_list', 'section_four_cost'
        , 'section_five_name', 'section_five_designation', 'section_five_date', 'section_five_comment', 'section_five_check_list', 'leave_balance'
        , 'section_six_name', 'section_six_designation', 'section_six_date', 'section_six_comment', 'noticeRequired', 'noticeShort'
        , 'section_seven_name', 'section_seven_designation', 'section_seven_date', 'section_seven_comment', 'section_seven_check_list', 'settlement_date'
        , 'section_eight_name', 'section_eight_designation', 'section_eight_date', 'section_eight_comment'
    ];
    public $timestamps = true;
}
