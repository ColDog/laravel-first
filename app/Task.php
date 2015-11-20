<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'intended_completion',
        'slug',
        'description',
        'actual_completion',
        'user_id'
    ];

    public function assignedTo()
    {
        return $this->belongsTo('App\User');
    }
}
