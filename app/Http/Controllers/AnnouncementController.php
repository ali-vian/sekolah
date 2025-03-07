<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //
    public function index(){
        $anoun = DB::table('announcements')->paginate(10);
        return view('pengumuman', ['pengumuman' => $anoun]);
    }

    public function show($id)
    {
        return view('post-pengumuman', ['post' => Announcement::find($id)]);
    }

    public function search(Request $keyword) {
        $keyword = $keyword->search;
        return view('pengumuman', ['pengumuman' => Announcement::where('title', 'like', '%'.$keyword.'%')
        ->paginate(10)]);
    }

}