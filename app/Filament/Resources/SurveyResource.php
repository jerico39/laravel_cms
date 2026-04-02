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

                Repeater::make('options')
                ->label(columnLabel('options'))
                // ->relationship()
                ->relationship('options') // ← 明示する！
                ->schema([
                TextInput::make('option_text')->required(),
                ])
                ->createItemButtonLabel('選択肢追加')
                ->collapsible()
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
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('csv')
                ->label('CSV')
                ->action(function ($record) {

                    return response()->streamDownload(function () use ($record) {

                        $handle = fopen('php://output', 'w');

                        fputcsv($handle, ['選択肢', '投票数']);

                        foreach ($record->options as $option) {
                            fputcsv($handle, [
                                $option->option_text,
                                $option->votes()->count(),
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
        ];
    }
}
