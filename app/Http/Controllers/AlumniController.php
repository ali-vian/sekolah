<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    //
    public function index(){
        return view('alumni',['alumnis' => DB::table('alumnis')->paginate(20)]);
    }

    public function search(Request $keyword){
        $keyword = $keyword->search;
        return view('alumni',['alumnis' => \App\Models\Alumni::where('name', 'like', '%'.$keyword.'%')
        ->paginate(20)]);
    }
}
