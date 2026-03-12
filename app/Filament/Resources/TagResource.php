<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

//管理画面のタグ一覧の項目表示
use Filament\Tables\Columns\TextColumn;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        //管理画面の登録フォーム
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(columnLabel('name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('slug')
                    ->label(columnLabel('slug'))
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }


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
   

    //管理画面のカテゴリ一覧の項目表示
    public static function table(Table $table): Table
    {
        return $table
         ->columns([
            TextColumn::make('name')
                ->label(columnLabel('name'))
                ->searchable()
                ->sortable(),

            TextColumn::make('slug')
                ->label(columnLabel('slug')),

            TextColumn::make('created_at')
                ->label(columnLabel('created_at'))
                ->dateTime('Y-m-d'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
