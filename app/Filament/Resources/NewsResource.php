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
use Filament\Tables\Actions\Action;
//公開判定を未来対応に変更
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;

use App\Support\Label;

function L($name) {
    //return Label::column($name);
}

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     //サイドメニュー等、メニュータイトル　lang/ja/models.phpのUserを参照して自動翻訳するためのコード
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
    protected static ?int $navigationSort = 10;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
                ->label(columnLabel('title'))
                ->required(),
            Forms\Components\TextInput::make('slug')
                ->label(columnLabel('slug'))
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\Select::make('category_id')
                ->label(columnLabel('category_id'))
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('tags')
                ->label(columnLabel('tags'))
                ->multiple()
                ->relationship('tags', 'name')
                ->preload(),

            Forms\Components\FileUpload::make('image')
                ->label(columnLabel('thumbnail'))
                ->image()   //拡張子が    jpg、png、webp、gif
                ->disk('public')
                ->directory('pages')
                ->visibility('public')
                ->preserveFilenames() //リネーム防止
                ->nullable()
                ->dehydrated(fn ($state) => filled($state)),

            Forms\Components\RichEditor::make('content')
                ->label(columnLabel('content'))
                ->columnSpanFull(),
            
            //▼公開判定を未来対応に変更
            Forms\Components\Toggle::make('is_published')
                ->label(columnLabel('is_published'))
                ->label('公開する')
                ->reactive(),

            Forms\Components\DateTimePicker::make('published_at')
                ->label(columnLabel('published_at'))
                ->seconds(false)
                ->visible(fn ($get) => $get('is_published'))
                ->required(fn ($get) => $get('is_published')),
            //▲公開判定を未来対応に変更


                ]);
    }

    //管理画面のニュース一覧の項目表示(直接指定)
    public static function table(Table $table): Table
    {
        return $table
        ->actions([
            Action::make('view_front')
                ->label('フロント表示')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn ($record) => route('news.show', $record->slug))
                ->openUrlInNewTab(),
        ])
        ->columns([
            ImageColumn::make('image')
                ->label(columnLabel('image'))
                ->square(),

            TextColumn::make('title')
                ->label(columnLabel('title'))
                ->searchable()
                ->sortable(),

            TextColumn::make('category.name')
                ->label(columnLabel('category_id'))
                ->sortable(),

            IconColumn::make('is_published')
                ->label(columnLabel('is_published'))
                ->boolean(),

            TextColumn::make('published_at')
                ->label(columnLabel('published_at'))
                ->dateTime('Y-m-d')
                ->sortable(),

            TextColumn::make('created_at')
                ->label(columnLabel('created_at'))
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
