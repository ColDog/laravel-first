<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

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

    public static function boot()
    {
        parent::boot();
        Task::updating(function($task){
            $project = $task->project()->get();
            $msg = "<a href='/projects/{$project->id}'>The task, {$task->name}, on {$project->name} was updated.</a>";
            Redis::lpush('messages', $msg);
            Redis::publish('new-message', $msg);
        });
        Task::creating(function($task){
            $project = $task->project()->get();
            $msg = "<a href='/projects/{$project->id}'>The task, {$task->name}, on {$project->name} was created.</a>";
            Redis::lpush('messages', $msg);
            Redis::publish('new-message', $msg);
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
