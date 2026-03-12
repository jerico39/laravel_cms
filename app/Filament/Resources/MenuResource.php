<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
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


class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

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
                TextInput::make('name')
                    ->label(columnLabel('menu.name'))
                    ->required(),

                TextInput::make('slug')
                    ->label(columnLabel('slug'))
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('name')
                ->label(columnLabel('menu.name'))
                ->searchable(),

            TextColumn::make('slug')
                ->label(columnLabel('slug'))
                ->searchable(),

            TextColumn::make('created_at')
                ->label(columnLabel('created_at'))
                ->dateTime('Y-m-d'),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
