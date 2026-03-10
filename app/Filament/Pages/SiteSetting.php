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

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'サイト設定';

    protected static ?string $navigationGroup = 'サイト管理';

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
                    ->label('サイト名'),

                Forms\Components\TextInput::make('site_description')
                    ->label('サイト説明'),

                Forms\Components\TextInput::make('contact_email')
                    ->label('メール'),

                Forms\Components\FileUpload::make('logo')
                    ->label('ロゴ')
                    ->directory('site'),

            ]);
    }

public function save()
{
    $setting = Setting::first();

    $setting->update($this->form->getState());

    Notification::make()
        ->title('保存しました')
        ->success()
        ->send();
}
}