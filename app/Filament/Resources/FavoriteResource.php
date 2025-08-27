<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FavoriteResource\Pages;
use App\Models\Favorite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class FavoriteResource extends Resource
{
    protected static ?string $model = Favorite::class;

    protected static ?string $navigationIcon  = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Engagement';
    protected static ?string $navigationLabel = 'Favorites';
    protected static ?string $pluralModelLabel = 'Favorites';
    protected static ?string $modelLabel       = 'Favorite';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Assign Favorite')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\Select::make('station_id')
                        ->label('Station')
                        ->relationship('station', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
                // Prevent duplicate pair (user_id, station_id)
                ->rules(function (callable $get, ?Favorite $record) {
                    return [
                        'user_id' => [
                            'required',
                            Rule::exists('users', 'id'),
                        ],
                        'station_id' => [
                            'required',
                            Rule::exists('stations', 'id'),
                            Rule::unique('favorites', 'station_id')
                                ->where(fn ($q) => $q->where('user_id', $get('user_id')))
                                ->ignore($record?->id),
                        ],
                    ];
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('station.name')
                    ->label('Station')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('station_id')
                    ->label('Station')
                    ->relationship('station', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
            'edit'   => Pages\EditFavorite::route('/{record}/edit'),
        ];
    }
}