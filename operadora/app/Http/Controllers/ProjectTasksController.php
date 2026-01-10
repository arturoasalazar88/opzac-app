<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    //

  public function update(Task $task)
  {
    // $task->update([
    //   'completed' => request()->has('completed')
    // ]);

    if (request()->has('completed')) {
      $task->complete();
    }
    else{
      $task->incomplete();
    }



    return back();
  }

  public function store(Project $project){
    //return request()->all();

    //$project->addTask(request('description'));

    request()->validate([
      'task' => 'required'
    ]);

    $project->addTask(request('task'));

    /*$task = new Task();

    $task->project_id = $project->id;
    $task->description = request('task');

    $task->save();*/

    return back();
  }
}
