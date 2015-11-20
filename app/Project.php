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
        return $this->hasMany('App\Collaborator');
    }
}
