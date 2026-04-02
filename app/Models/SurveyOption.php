<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
        protected $fillable = ['survey_id', 'option_text', 'is_user_generated'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function votes()
    {
        return $this->hasMany(SurveyVote::class);
    }

    
}
