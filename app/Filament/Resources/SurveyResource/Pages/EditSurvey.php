<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditSurvey extends EditRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
                    Action::make('view')
            ->label('フロントで表示')
            ->url(fn () => url('/survey/' . $this->record->id))
            ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

}
