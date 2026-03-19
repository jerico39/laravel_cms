<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Setting;
use Filament\Notifications\Notification;

class SiteSetting extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    //　lang/ja/models.phpのUserを参照して自動翻訳するためのコード
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public static function getModelLabel(): string
    {
        return __('models.' . class_basename(static::$model));
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.' . class_basename(static::$model));
    }
    //END

    //ページタイトルをlang/ja/models.phpのSiteSettingを参照して自動翻訳するためのコード
    public function getTitle(): string
    {
        return __('models.SiteSetting');
    }

    protected static ?string $navigationLabel = null;
    public static function getNavigationLabel(): string
    {        
        return __('models.SiteSetting');
    }

    //　lang/ja/models.phpのSiteSettingを参照して自動翻訳するためのコード
    protected static ?string $navigationGroup = null;
    public static function getNavigationGroup(): ?string
    {
        return __('models.groups.site');
    }

    protected static ?int $navigationSort = 2; // メニューの順番を指定

    protected static string $view = 'filament.pages.site-setting';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = Setting::first();

        $this->form->fill($setting->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([

                Forms\Components\TextInput::make('site_name')
                    ->label(columnLabel('site_name')),

                Forms\Components\TextInput::make('site_description')
                    ->label(columnLabel('site_description')),

                Forms\Components\TextInput::make('contact_email')
                    ->label(columnLabel('contact_email')),

                Forms\Components\FileUpload::make('logo')
                    ->label(columnLabel('logo'))
                    ->image()
                    ->directory('site')
                    ->disk('public')
                    ->multiple(false)
                    ->preserveFilenames()
                    ->storeFiles()
                    ->visibility('public'),

            ]);
    }

public function save()
{
   
    $data = $this->form->getState();

    //これを追加（超重要）
    if (is_array($data['logo'])) {
        $data['logo'] = $data['logo'][0] ?? null;
    }

    //$setting = Setting::first();
    $setting = \App\Models\Setting::firstOrCreate([]);

    $setting->update($data);
    Notification::make()
        ->title('保存しました')
        ->success()
        ->send();
}
}