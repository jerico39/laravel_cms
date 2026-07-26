<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyOption;

class Survey extends Model
{
    public const VOTE_LIMIT_NONE = 'none';
    public const VOTE_LIMIT_IP_ONCE = 'ip_once';
    public const VOTE_LIMIT_IP_DAILY = 'ip_daily';

    protected $fillable = ['title', 'description', 'expires_at', 'vote_limit_type'];

    protected $attributes = [
        'vote_limit_type' => self::VOTE_LIMIT_NONE,
    ];

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
