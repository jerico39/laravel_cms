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

    // 期限チェック
    if ($survey->expires_at && now()->gt($survey->expires_at)) {
        return back()->with('error', '期限切れ');
    }

    // 🔥 新規選択肢（ここが重要）
    if ($request->filled('new_option')) {

        $option = SurveyOption::create([
            'survey_id' => $survey->id,
            'option_text' => trim($request->new_option),
            'is_user_generated' => true,
        ]);

    } else {

        $option = SurveyOption::findOrFail($request->option_id);
    }

    // 投票
    SurveyVote::create([
        'survey_id' => $survey->id,
        'survey_option_id' => $option->id,
        'user_ip' => request()->ip(),
    ]);

    // コメント
    if ($request->comment) {
        SurveyComment::create([
            'survey_id' => $survey->id,
            'comment' => $request->comment,
        ]);
    }

    return back()->with('success', '投票しました');
}
}
