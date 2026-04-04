<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyOption;
use App\Models\SurveyVote;
use App\Models\SurveyComment;


class SurveyController extends Controller
{
    public function show($id)
    {
        $survey = Survey::with('options')->findOrFail($id);
        return view('survey', compact('survey'));
    }

   public function vote(Request $request)
{
   
    $survey = Survey::findOrFail($request->survey_id);

    if ($survey->expires_at && now()->gt($survey->expires_at)) {
        
        return back()->with('error', '期限切れ');
    }
     
    // 🔥 new_option優先（これが最強）
    if (!empty(trim($request->new_option))) {

        $option = SurveyOption::create([
            'survey_id' => $survey->id,
            'option_text' => trim($request->new_option),
            'is_user_generated' => true,
        ]);

    } elseif ($request->option_id) {

        $option = SurveyOption::findOrFail($request->option_id);

    } else {

        return back()->with('error', '選択してください');
    }

    SurveyVote::create([
        'survey_id' => $survey->id,
        'survey_option_id' => $option->id,
        'user_ip' => request()->ip(),
    ]);

    return back()->with('success', '投票しました');
}
   
}
