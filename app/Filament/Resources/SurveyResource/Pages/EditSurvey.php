<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\SurveyOption;

use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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




    protected function beforeSave(): void
    {
        $file = $this->form->getState()['options_csv'] ?? null;

        if (!$file) {
            return;
        }

        // 配列対応
        if (is_array($file)) {
            $file = array_values($file)[0] ?? null;
        }

        if (!$file instanceof TemporaryUploadedFile) {
            dd('型が違う', $file); // ← ここ重要
        }

        $path = $file->getRealPath();

        if (!$path || !file_exists($path)) {
            dd('tmpファイルなし', $path);
        }

        $csv = array_map('str_getcsv', file($path));

        foreach ($csv as $row) {
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue;
            }

            \App\Models\SurveyOption::firstOrCreate([
                'survey_id' => $this->record->id,
                'option_text' => trim($row[0]),
            ], [
                'is_user_generated' => false,
            ]);
        }
    }



    
}

    