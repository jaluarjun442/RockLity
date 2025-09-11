<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function questions(Request $request) {
        $result = Question::paginate(10);

        // $pageNo = isset($request->page) ? $request->page : 1;
        // $result = $result->forPage($pageNo,15);

        return response()->json($result);
    }

    public function answer($questionId) {
        $result = Answer::where('question_id',$questionId)->get();

        return response()->json($result);
    }
}
