<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    //lang/ja/models.phpのUserを参照して自動翻訳するためのコード
    protected static ?string $modelLabel = null;
    public static function getModelLabel(): string
    {
        return __('models.' . class_basename(static::$model));
    }

    protected static ?string $pluralModelLabel = null;
    public static function getPluralModelLabel(): string
    {
        return __('models.' . class_basename(static::$model));
    }

      //グループ名をlang/ja/models.phpのgroups.siteから自動翻訳するためのコード
    protected static ?string $navigationGroup = null;
    public static function getNavigationGroup(): ?string
    {
        return __('models.groups.menu');
    }
    //END

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('menu_id')
                    ->relationship('menu', 'name')
                    ->label(columnLabel('menu'))
                    ->required(),

                TextInput::make('title')
                    ->label(columnLabel('title'))
                    ->required(),

                TextInput::make('url')
                    ->label(columnLabel('url'))
                    ->required(),

                TextInput::make('sort')
                    ->label(columnLabel('sort'))
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->label(columnLabel('title')),
                TextColumn::make('url')
                ->label(columnLabel('url')),
                TextColumn::make('menu.name')
                ->label(columnLabel('menu')),
                //
            ])
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
