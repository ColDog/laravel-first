<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Project extends Model
{
    protected $fillable = [
        'name',
        'intended_completion',
        'user_id',
        'description',
        'actual_completion'
    ];

    public static function boot()
    {
        parent::boot();
        Project::updating(function($project){
            $msg = "<a href='/projects/{$project->id}'>The project: {$project->name} was updated.</a>";
            Redis::lpush('messages', $msg);
            Redis::publish('new-message', $msg);
        });
        Project::creating(function($project){
            $msg = "<a href='/projects/{$project->id}'>The project: {$project->name} was created.</a>";
            Redis::lpush('messages', $msg);
            Redis::publish('new-message', $msg);
        });
    }

    public function collaborators()
    {
        return $this->belongsToMany('App\User', 'collaborators', 'project_id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'project_id');
    }

}
