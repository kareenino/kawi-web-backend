<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EcoPointResource\Pages;
use App\Models\EcoPoint;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;

class EcoPointResource extends Resource
{
    protected static ?string $model = EcoPoint::class;

    protected static ?string $navigationIcon  = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Loyalty';
    protected static ?string $navigationLabel = 'EcoPoints';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Assignment')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            Forms\Components\Section::make('Points')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('points_change')
                        ->label('Points (+/-)')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('balance_after')
                        ->helperText('Auto-calculated if left empty')
                        ->numeric()
                        ->nullable(),

                    Forms\Components\TextInput::make('reason')
                        ->placeholder('swap_completed, bonus, adjustment')
                        ->maxLength(120),
                ]),
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

                // Tables\Columns\BadgeColumn::make('points_change')
                //     ->label('Δ Points')
                //     ->colors([
                //         'success' => fn ($state) => (int)$state > 0,
                //         'danger'  => fn ($state) => (int)$state < 0,
                //     ])
                //     ->sortable(),

                Tables\Columns\TextColumn::make('balance_after')
                    ->label('Balance')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reason')
                    ->limit(24)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('gains')
                    ->label('Only Gains')
                    ->query(fn ($q) => $q->where('points_change', '>', 0)),

                Tables\Filters\Filter::make('deductions')
                    ->label('Only Deductions')
                    ->query(fn ($q) => $q->where('points_change', '<', 0)),
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
            'index'  => Pages\ListEcoPoints::route('/'),
            'create' => Pages\CreateEcoPoint::route('/create'),
            'edit'   => Pages\EditEcoPoint::route('/{record}/edit'),
        ];
    }
}