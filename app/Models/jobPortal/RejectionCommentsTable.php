<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class RejectionCommentsTable extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'rejection_reasons';

    public function setCatAttribute($value)
    {
        $this->attributes['rejection_comment'] = json_encode($value);
    }

    /**
     * Get the categories
     *
     */
    public function getCatAttribute($value)
    {
        return $this->attributes['rejection_comment'] = json_decode($value);
    }
}
