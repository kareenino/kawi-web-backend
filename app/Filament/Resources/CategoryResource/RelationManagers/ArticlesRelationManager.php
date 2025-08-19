<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
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

class ArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')->sortable()->limit(50),
                TextColumn::make('slug')->sortable()->limit(50),
                IconColumn::make('is_published'),
                // SpatieMediaLibraryImageColumn::make('thumbnail')->collection('posts')
            ])

            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
