<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function testRequestSeats()
    {
        return request();
        $seleccionados = "Seleccionados";

        foreach (request('seat') as $key => $seat) {
            if ($seat == "selection") {
                $seleccionados .= " ".$key;
            }
        }
        return $seleccionados;
    }
}
