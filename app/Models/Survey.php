<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyOption;

class Survey extends Model
{
 protected $fillable = ['title', 'description', 'expires_at'];

    public function options()
    {
        return $this->hasMany(SurveyOption::class);
    }

    public function votes()
    {
        return $this->hasMany(SurveyVote::class);
    }

    public function comments()
    {
        return $this->hasMany(SurveyComment::class);
    }
}
