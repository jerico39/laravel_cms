<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyComment extends Model
{
    protected $fillable = ['vote_id', 'survey_id', 'comment', 'survey_option_id'];

    public function option()
    {
        return $this->belongsTo(SurveyOption::class, 'survey_option_id');
    }

    public function vote()
    {
        return $this->belongsTo(SurveyVote::class, 'vote_id');
    }
}
