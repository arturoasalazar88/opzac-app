<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
  protected $guarded = [];

  public function tasks()
  {
    return $this->hasMany(Task::class);
  }

  public function addTask($description)
  {

    /// This will work Eloquent for the uppeer relationship

    $this->tasks()->create(['description' => $description]);

    // return Task::create([
    //   'project_id' => $this->id,
    //   'description' => $description
    // ]);
  }
}
