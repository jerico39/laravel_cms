<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
        protected $fillable = [
        'menu_id',
        'title',
        'url',
        'sort',
        'name',
        'slug',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
