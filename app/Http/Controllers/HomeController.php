<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Keyword;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Sitemap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Question::where('answer_status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(30)
            ->onEachSide(1);
        return view('home', ['data' => $data]);
    }
    public function welcome()
    {
        return redirect()->route('admin.index');
        // return view('welcome');
    }
    public function single($id, $slug)
    {
        $data = Question::where('answer_status', 1)
            ->where('id', $id)
            ->first();
        $answer_data = Answer::where('question_id', $id)
            ->get();
        return view('single', ['data' => $data, 'answer_data' => $answer_data]);
    }
    public function test() {}
}
