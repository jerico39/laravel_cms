<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use Filament\Navigation\NavigationGroup;
use Filament\View\PanelsRenderHook;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{

    public function boot() //202
    {
        // フッターのクレジットやリンクを含むクラスを非表示にするCSSを注入
        FilamentView::registerRenderHook(
            'panels::footer.before',
            fn (): HtmlString => new HtmlString('<style>.fi-footer { display: none !important; }</style>'),
        );
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            //->default()
            ->brandName('バックオフィス') // ロゴやブランド名
            //->brandLogo(asset('images/logo.svg'))
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                //'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
               // Widgets\AccountWidget::class,   // 「ようこそ」カード
               // Widgets\FilamentInfoWidget::class,  // 「Filamentロゴ / ドキュメント / GitHub」カード
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('models.groups.content')),  // コンテンツ管理
                NavigationGroup::make()
                    ->label(__('models.groups.menu')),  // メニュー管理
                NavigationGroup::make()
                    ->label(__('models.groups.site')),  // サイト管理
            ])
            //サイドメニューのコンテンツ管理をデフォルトで開いた状態
            ->renderHook(
                PanelsRenderHook::SCRIPTS_BEFORE,
                fn (): string => <<<'HTML'
                    <script>
                        (function () {
                            try {
                                const key = 'alpinejs-store';
                                const raw = localStorage.getItem(key);

                                if (! raw) {
                                    return;
                                }

                                const state = JSON.parse(raw);

                                if (state && state.collapsedGroups) {
                                    delete state.collapsedGroups;
                                    localStorage.setItem(key, JSON.stringify(state));
                                }
                            } catch {
                                // ignore
                            }
                        })();
                    </script>
                HTML,
            )
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
