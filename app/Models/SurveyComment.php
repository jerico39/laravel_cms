<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyComment extends Model
{
    protected $fillable = ['survey_id', 'comment'];
}
