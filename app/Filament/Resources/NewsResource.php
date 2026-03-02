<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

//公開判定を未来対応に変更
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;


class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
            ->required(),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('tags')
                ->multiple()
                ->relationship('tags', 'name')
                ->preload(),

            Forms\Components\FileUpload::make('image')
                ->image()   //拡張子が    jpg、png、webp、gif
                ->disk('public')
                ->directory('pages')
                ->visibility('public')
                ->preserveFilenames() //リネーム防止
                ->nullable()
                ->dehydrated(fn ($state) => filled($state)),

            Forms\Components\RichEditor::make('content')
                ->columnSpanFull(),
            
            //▼公開判定を未来対応に変更
            Forms\Components\Toggle::make('is_published')
                ->label('公開する')
                ->reactive(),

            Forms\Components\DateTimePicker::make('published_at')
                ->label('公開日時')
                ->seconds(false)
                ->visible(fn ($get) => $get('is_published'))
                ->required(fn ($get) => $get('is_published')),
            //▲公開判定を未来対応に変更


                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ImageColumn::make('image')
                ->label('画像')
                ->square(),

            TextColumn::make('title')
                ->label('タイトル')
                ->searchable()
                ->sortable(),

            TextColumn::make('category.name')
                ->label('カテゴリ')
                ->sortable(),

            IconColumn::make('is_published')
                ->label('公開')
                ->boolean(),

            TextColumn::make('published_at')
                ->label('公開日')
                ->dateTime('Y-m-d')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('作成日')
                ->dateTime('Y-m-d'),
                
        ])
        ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }

    
}
