<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;

class TasksController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($projectId, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects', ['id' => $projectId]))
                ->withErrors($validator)
                ->withInput();
        }

        $project = Project::findOrFail($projectId);
        $task = new Task($request->all());
        $task->project_id = $project->id;
        $task->save();

        return redirect(route('projects.show', ['id' => $projectId]))->with([
            'success' => 'Successfully created project.'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Add the completion flag resource.
     *
     * @param  int  $projectId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completion($projectId, Request $request)
    {
        $task = Task::findOrFail($request->input('id'));
        $task->completed = !$task->completed;
        $task->save();
        return $task;
    }

    /**
     * Add the assigned user resource.
     *
     * @param  int  $projectId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assigned($projectId, Request $request)
    {
        $task = Task::findOrFail($request->input('taskId'));
        $task->user_id = $request->input('userId');
        $task->save();
        return User::find($request->input('userId'))->tasks()->count();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $projectId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $id)
    {
        Task::findOrFail($id)->delete();
        return redirect(route('projects.show', ['id' => $projectId]))->with([
            'success' => 'Successfully removed task.'
        ]);

    }
}
