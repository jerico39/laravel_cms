<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;



    protected function getHeaderActions(): array
{
    return [
        
        Action::make('preview')
            ->label('プレビュー')
            ->icon('heroicon-o-eye')
            ->url(fn () => route('news.preview', $this->record->id))
            ->openUrlInNewTab(),
            
        Action::make('view_front')
            ->label('フロント表示')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->url(fn () => route('news.show', $this->record->slug))
            ->openUrlInNewTab(),
        Actions\DeleteAction::make(), // 既存の削除アクションも残す
    ];
}
}
