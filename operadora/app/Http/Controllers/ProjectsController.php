<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    //

  public function index(){

    $projects = Project::all();

    //return $projects;

    return view('projects.index',[
      'projects' => $projects
    ]);
  }

  public function show(Project $project)
  {
    //$project = Project::findOrFail($id);

    return view('projects.show', [
      'project' => $project
    ]);
  }

  public function create(){

    return view('projects.create');
  }

  public function store(){
    //return request()->all();

    request()->validate([
      'title' => ['required', 'min:3'],
      'description' => 'required'
    ]);

    $project = new Project();

    $project->title = request('title');
    $project->description = request('description');

    $project->save();

    return redirect('/projects');
  }

  public function edit($id)
  {
    $project = Project::findOrFail($id);

    return view('projects.edit',[
      'project' => $project
    ]);
  }

  public function update($id)
  {
    $project = Project::findOrFail($id);

    $project->title = request('title');
    $project->description = request('description');

    $project->save();

    return redirect('/projects');
  }

  public function destroy($id)
  {
    Project::findOrFail($id)->delete();

    return redirect('/projects');
  }
}
