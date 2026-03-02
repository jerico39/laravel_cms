<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; //公開判定を未来対応に変更



class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'published_at',
        'category_id',
    ];

    //$casts に datetime を書かないと自動で Carbon に変換されません。
    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    //公開判定を未来対応に変更
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    //管理画面にてin_publishedを更新した際、published_atも自動で更新する
    protected static function booted()
    {
        static::saving(function ($news) {

            if ($news->is_published && !$news->published_at) {
                $news->published_at = now();
            }

            if (!$news->is_published) {
                $news->published_at = null;
            }

        });
    }


    
}

