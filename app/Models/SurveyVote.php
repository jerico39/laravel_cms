<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    protected $fillable = ['survey_id', 'survey_option_id', 'user_ip'];


    public function option()
    {
        return $this->belongsTo(SurveyOption::class, 'survey_option_id');
    }

    public function comment()
    {
        return $this->hasOne(SurveyComment::class, 'vote_id');
    }

}
