<?php

namespace App\Models\attendance;

use Illuminate\Database\Eloquent\Model;

class PacraClientVisit extends Model
{
    protected $table = 'pacra_client_visit';
    protected  $fillable =['id', 'user_id', 'dates','time', 'client_id', 'team', 'team_time','comments', 'status', 'approved_by'];
    public $timestamps = true;
}
