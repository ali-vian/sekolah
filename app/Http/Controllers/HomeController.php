<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(){
        return view('home',[
            'alumnis' => \App\Models\Alumni::all()->take(4) ,
            'kerjasamas' => \App\Models\Kerjasama::where('status', true)->get(),
            'beritas' => \App\Models\News::all()->take(3),
            'about' => \App\Models\About::first(),
            'jurusan'=> \App\Models\Jurusan::all(['name','icon','slug']),
            'ekstrakulikuler' => \App\Models\Extrakulikuler::all()
        ]);
    }

    public function about(){
        return view('about',[
            'about' => \App\Models\About::first(),
            'beritas' => \App\Models\News::orderBy('created_at','desc')->take(4)->get(),
        ]);
    }

    public function jurusan($slug){
        return view('jurusan',['jurusan' => \App\Models\Jurusan::where('slug',$slug)->firstOrFail()]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('success','berhasil logout');
    }

}
