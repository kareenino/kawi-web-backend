<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers\TagsRelationManager;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
                ->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->required(),
                    TextInput::make('title')
                        ->reactive()
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', Str::slug($state));
                        })
                        ->required(),
                    TextInput::make('slug')->required(),
                    // SpatieMediaLibraryImageEntry::make('thumbnail')->collection('articles'),
                    RichEditor::make('content'),
                    Toggle::make('is_published'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')->sortable()->limit(50),
                TextColumn::make('slug')->sortable()->limit(50),
                IconColumn::make('is_published'),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('posts')
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
            // TagsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
