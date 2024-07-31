<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->get('table');

        $page = DB::table($table)->orderBy('id','desc')->limit(10)->get();

        return json_encode($page);

    }

}
