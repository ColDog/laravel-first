<?php

namespace App\Http\Controllers;

use App\Project;
use \App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{

    /**
     * ProjectsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $users = User::lists('name', 'id');
        return view('projects.index', compact('projects', 'users'));
    }

    /**
     * Display a create form for the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::lists('name', 'id');
        return view('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('projects/create')
                ->withErrors($validator)
                ->withInput();
        }

        $project = Project::create($request->all());
        $project->collaborators()->sync($request->input('users'));
        return redirect('/projects')->with([
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
        $project = Project::findOrFail($id);
        $users = User::lists('name', 'id');
        return view('projects.show', compact('project', 'users'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        $project = Project::findOrFail($id);


        if ($validator->fails()) {
            return  Redirect::route('projects', array('id' => $project->id))
                ->withErrors($validator)
                ->withInput();
        }

        $project->update($request->all());

        dd($request->input('user_list'));
//        $project->collaborators()->sync($request->input('user_list'));

        return redirect('/projects')->with([
            'success' => 'Successfully edited project.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::findOrFail($id)->destroy();
        return redirect('/projects')->with([
            'success' => 'Successfully deleted project.'
        ]);
    }
}
