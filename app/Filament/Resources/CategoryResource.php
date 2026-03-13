<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

//管理画面のカテゴリ一覧の項目表示
use Filament\Tables\Columns\TextColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
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

    protected static ?string $navigationGroup = null;
    public static function getNavigationGroup(): ?string
    {
        return __('models.groups.content');  // コンテンツ管理
    }

    protected static ?int $navigationSort = 40;


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
                ->label(columnLabel('slug'))
                ->searchable(),

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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
