<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'intended_completion',
        'user_id',
        'description',
        'actual_completion'
    ];

    public function collaborators()
    {
        return $this->belongsToMany('App\User', 'collaborators', 'project_id', 'user_id');
    }

}
