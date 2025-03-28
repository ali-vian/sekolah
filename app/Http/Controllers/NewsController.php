<?php

namespace App\Http\Controllers;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    //
    public function index()
    {
        $berita = DB::table('news')->paginate(10);
        return view('berita', ['berita' => $berita]);
    }

    public function show($slug)
    {
        return view('post', ['post' => News::where('slug',$slug)->firstOrFail()]);
    }

    public function search(Request $keyword)
    {
        $keyword = $keyword->search;
        return view('berita', ['berita' => News::where('title', 'like', '%'.$keyword.'%')
        ->paginate(10)]);
    }
}
