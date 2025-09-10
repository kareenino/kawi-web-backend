<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SwapHistoryResource\Pages;
use App\Filament\Resources\SwapHistoryResource\RelationManagers;
use App\Models\SwapHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SwapHistoryResource extends Resource
{
    protected static ?string $model = SwapHistory::class;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('station_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('battery_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('swapped_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('station_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('battery_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('swapped_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSwapHistories::route('/'),
            'create' => Pages\CreateSwapHistory::route('/create'),
            'edit' => Pages\EditSwapHistory::route('/{record}/edit'),
        ];
    }
}
