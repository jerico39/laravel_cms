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

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_id');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
