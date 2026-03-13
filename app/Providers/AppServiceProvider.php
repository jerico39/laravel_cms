<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \View::composer('*', function ($view) {
            $menus = \App\Models\Menu::with(['children', 'menuItems'])->whereNull('menu_id')->orderBy('sort')->get();
            $view->with('menus', $menus);
        });
    }
}
