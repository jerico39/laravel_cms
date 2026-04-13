<?php

namespace App\Livewire;

use Livewire\Component;

class SurveyVote extends Component
{

    public $survey;
    public $option_text;

    /*
    protected function rules()
    {

    //テーブル survey_options における option_text カラムの値が、同じ survey_id を持つレコードの中で一意であることを検証するルールを定義しています。
    //つまり、既にある選択肢の追加を防止します。
        return [
            'option_text' => [
                'required',
                \Illuminate\Validation\Rule::unique('survey_options', 'option_text')
                    ->where('survey_id', $this->survey->id),
            ],
        ];
    }
*/
    public function addOption()
    {
        $this->validate();

        \App\Models\SurveyOption::create([
            'survey_id' => $this->survey->id,
            'option_text' => $this->option_text,
        ]);

        $this->option_text = '';
    }





    public function render()
    {
        return view('livewire.survey-vote');
    }
}
