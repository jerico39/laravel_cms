<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyOption;
use App\Models\SurveyVote;
use App\Models\SurveyComment;
use Illuminate\Validation\Rule; // 追加: Ruleクラスをインポート(入力チェック)

class SurveyController extends Controller

{
    public function show($id)
    {
        $survey = Survey::with('options')->findOrFail($id);

            // 期限切れチェック
    if ($survey->expires_at && now()->gt($survey->expires_at)) {
        return view('survey.expired', compact('survey'));
    }

        return view('survey', compact('survey'));
    }

   public function vote(Request $request)
    {
    //dd($request->all()); // 送信されたデータを確認するためのデバッグコード。これを使用して、フォームから正しいデータが送信されているかを確認できます。
        $survey = Survey::findOrFail($request->survey_id);

        if ($survey->expires_at && now()->gt($survey->expires_at)) {
            
            //return back()->with('error', '期限切れ');
            return back()->with('error', __('messages.survey.expired')); // 変更: 言語ファイルからエラーメッセージを取得
        }
        
        $newOption = trim(mb_convert_kana($request->new_option, 'as'));

        $request->merge([
            'new_option' => $newOption
        ]);





        $request->validate([
            'survey_id' => 'required|exists:surveys,id',

            // 以下の記載方法はsurvey_options,idの存在チェックを行う。nullの可能性をかねてnullableを追加。
            //これだと追加の「new」が来た場合弾く。
            //'survey_option_id' => 'nullable|exists:survey_options,id',


            //「new」の文字列が送られてきた場合は、survey_option_idの存在チェックはスキップされるようにする。
            'survey_option_id' => [
            'nullable',
            Rule::excludeIf(fn () => $request->survey_option_id === 'new'),
            'exists:survey_options,id',
        ],


        'new_option' => [
            'nullable',
            'string',
            'max:100',

            //new選択時は必須
            Rule::requiredIf(fn () => $request->survey_option_id === 'new'),

            //new選択してないのに入力があったらNG
            Rule::prohibitedIf(fn () => $request->survey_option_id !== 'new'), //lang\ja\validation.php のcustom=>new_option=>prohibited よりカスタムメッセージを取得している。
            // 重複チェック
            Rule::unique('survey_options', 'option_text')
                ->where(fn ($q) => $q->where('survey_id', $request->survey_id)),
        ],

        'comment' => 'nullable|string|max:200',//lang\ja\validation.php のmax=>[string よりメッセージを取得している。
        
        ]);

        //選択なし
        if (empty($request->survey_option_id) && empty($request->new_option)) {
          
            //dd(request()->all());
            return back()->with('error', __('messages.survey.no_option')); // 変更: 言語ファイルからエラーメッセージを取得
 
        }

        // new_option優先（これが最強）
        if (!empty(trim($request->new_option))) {

            $option = SurveyOption::create([
                'survey_id' => $survey->id,
                'option_text' => trim($request->new_option),
                'is_user_generated' => true,
            ]);

        } elseif ($request->survey_option_id) {

            $option = SurveyOption::findOrFail($request->survey_option_id);

        } else {
            // ここは通常は通らないはずですが、念のための保険
            return back()->with('error', __('messages.survey.no_option'));
        }


        // 投票保存
        $vote = SurveyVote::create([
            'survey_id' => $survey->id,
            'survey_option_id' => $option->id,
            'user_ip' => request()->ip(),
        ]);
        /*
        dd([
            'comment' => $request->comment,
            'filled' => $request->filled('comment'),
            'option_id' => $option->id ?? null,
        ]);
        */

        // コメント保存
        if ($request->comment) {
            SurveyComment::create([
                'vote_id' => $vote->id, // ★ここが最重要
                'survey_id' => $survey->id,
                'survey_option_id' => $option->id,
                'comment' => $request->input('comment'),
            ]);
        }


        return back()->with('msg', __('messages.survey.vote'));
    }
   
}
