<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logger;
use Illuminate\Support\Facades\Input;

class LogsController extends Controller
{
    public function index()
    {
        $logs = Logger::orderBy('id', 'desc')->paginate(35);

        // Lets retrieve the search
        $q = Input::get ( 'q' );

        if( $q != ""){
            $logs = Logger::where('user', 'LIKE', '%' . $q . '%')
                        ->orWhere('method', 'LIKE', '%' . $q . '%')
                        ->orWhere('action', 'LIKE', '%' . $q . '%')
                        ->paginate(35)->setPath('');

            // and lets append the query search 'q'
            $pagination = $logs->appends(
                array('q' => Input::get ( 'q' ))
            );
            // if there is results
            if (count ( $logs ) > 0) {
                return view ( 'logs.index', [
                    'logs' => $logs,
                    'q' => $q
                ]);
            }
        }

        return view('logs.index', [
            'logs' => $logs,
        ]);
    }
}
