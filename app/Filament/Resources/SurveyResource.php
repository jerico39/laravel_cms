<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Survey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\SurveyResource\Pages\ViewSurveyResults;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    protected static ?string $navigationGroup = null;
    public static function getNavigationGroup(): ?string
    {
        return __('models.groups.content');  // コンテンツ管理
    }

     //並び順
    protected static ?int $navigationSort = 70;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->label(columnLabel('title'))
                ->required(),
    
                Textarea::make('description')
                ->label(columnLabel('description')),

                DateTimePicker::make('expires_at')
                ->label(columnLabel('expires_end')),


                //CSVアップロードの実装
                FileUpload::make('options_csv')
                    ->label(columnLabel('options_csv'))
                    ->disk('local')
                    ->directory('csv')
                    ->acceptedFileTypes([
                        'text/csv',
                        'application/csv',
                        'text/plain',
                        'application/octet-stream', // ← これが重要
                    ])
                    ->storeFiles(false) // ← ★これ必須
                    ,

                Repeater::make('options')
                    ->label(columnLabel('options_csv'))
                    ->relationship()
                    ->schema([
                        Grid::make(3)->schema([
                            // 左：入力欄
                            TextInput::make('option_text')
                                ->required()
                                ->maxLength(255)
                                ->hiddenLabel()
                                ->columnSpan(2),
                            // 右：追加元（削除ボタン側に寄る）
                            Placeholder::make('source')
                                ->hiddenLabel()
                                ->content(fn ($record) => 
                                '追加元：' . ($record?->is_user_generated ? 'User' : 'Admin'))
                                ->extraAttributes(['class' => 'text-right']),
                        ])
                        ,
                    ])
                    ->createItemButtonLabel('選択肢を追加する'),


            ]);
    }

    //一覧
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id') // ← 追加（先頭）
                    ->label(columnLabel('id'))
                    ->sortable(),
                TextColumn::make('title')
                    ->label(columnLabel('title'))
                    ->sortable(),
                TextColumn::make('expires_at')->dateTime()
                    ->label(columnLabel('expires_end'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])

            
            
            ->actions([

                Tables\Actions\Action::make('view')
                ->label(columnLabel('frontend_view'))
                ->icon('heroicon-o-eye')
                ->url(fn ($record) => route('survey.show', $record->id))
                ->openUrlInNewTab(), // 任意（新規タブ）

                Tables\Actions\EditAction::make(),


                Tables\Actions\Action::make('results')
                ->label(columnLabel('results'))
                //->url(fn ($record) => static::getUrl('viewSurveyResults', ['record' => $record]))
                ->url(fn ($record) => static::getUrl('results', ['record' => $record]))
                ->icon('heroicon-o-chart-bar'),

                Tables\Actions\Action::make('csv')
                    ->label(columnLabel('export_csv'))
                    ->action(function ($record) {

                        return response()->streamDownload(function () use ($record) {

                            $handle = fopen('php://output', 'w');

                            // ヘッダー
                            fputcsv($handle, ['option', 'comment', 'IP', 'voted_at']);

                            // ★ votes単位で回すのが正解
                            foreach ($record->votes as $vote) {

                                fputcsv($handle, [
                                    $vote->option->option_text ?? '',
                                    $vote->comment->comment ?? '',
                                    $vote->user_ip,
                                    $vote->created_at,
                                ]);
                            }

                            fclose($handle);

                        }, 'survey.csv');

                    })



            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            //'viewSurveyResults' => Pages\ViewSurveyResults::route('/{record}/results'),
            'results' => ViewSurveyResults::route('/{record}/results'),
            
        ];
    }


  

  
}
