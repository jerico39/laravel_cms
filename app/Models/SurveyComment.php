<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyComment extends Model
{
    protected $fillable = ['survey_id', 'comment', 'survey_option_id'];

    public function option()
    {
        return $this->belongsTo(SurveyOption::class, 'survey_option_id');
    }
}
