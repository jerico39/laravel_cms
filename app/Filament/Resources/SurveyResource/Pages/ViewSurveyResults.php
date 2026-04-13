<?php

namespace App\Filament\Resources\SurveyResource\Pages;


//use Filament\Resources\Pages\ViewRecord;

use Filament\Resources\Pages\Page;
use App\Filament\Resources\SurveyResource;

//class ViewSurveyResults extends ViewRecord
class ViewSurveyResults extends Page
{
    protected static string $resource = \App\Filament\Resources\SurveyResource::class;

    protected static string $view = 'filament.resources.survey-resource.pages.view-survey-results';
    
    protected static ?string $title = '投票結果';

    public $record;
    public $survey;
    public $results;
    public $comments;

    
/*
    protected function getViewData(): array
    {
        $survey = $this->record;

        $results = $survey->options->map(function ($option) {
            return [
                'text' => $option->option_text,
                'count' => $option->votes()->count(),
            ];
        });

        $comments = $survey->comments()->latest()->get();

        return [
            'survey' => $survey,
            'results' => $results,
            'comments' => $comments,
        ];
    }
*/
    
    public function mount($record)
    {
        //$this->record = $record;
        /*
        $this->record = \App\Models\Survey::findOrFail($record);
        $this->survey = \App\Models\Survey::with('options.votes', 'comments')->findOrFail($record);
        $this->record = \App\Models\Survey::findOrFail($record);
        */

         $this->survey = \App\Models\Survey::with([
            'options.votes',
            'options.comments',
        ])->findOrFail($record);


        $this->results = $this->survey->options->map(function ($option) {
            return [
                //'text' => $option->option_text,
                'label' => $option->option_text, // ←変更
                'count' => $option->votes->count(),
            ];
        });

        $this->comments = $this->survey->comments;
    }
    
}