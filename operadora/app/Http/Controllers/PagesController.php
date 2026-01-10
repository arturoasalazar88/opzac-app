<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
  public function exampleMethod(){
    $tasks = [
      'Go to the store',
      'Go to the market',
      'Go to work'
    ];

    return view('example',[
      'tasks' => $tasks,
      'foo' => 'foobar from example'
    ]);
  }
}
