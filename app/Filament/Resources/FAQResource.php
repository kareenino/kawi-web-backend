<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FAQResource\Pages;
use App\Filament\Resources\FAQResource\RelationManagers;
use App\Models\FAQ;
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

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
                ->schema([
                    TextInput::make('question')
                        ->required(),
                    RichEditor::make('answer')
                        ->required(),
                    TextInput::make('rating')
                        ->required(),
                    // Toggle::make('is_published'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->sortable()->limit(40),
                TextColumn::make('answer')->sortable()->limit(40),
                TextColumn::make('rating')->sortable()->limit(40),
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
            'index' => Pages\ListFAQS::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}
