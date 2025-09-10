<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\EcoPoint;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EcoPointResource\Pages;

class EcoPointResource extends Resource
{
    protected static ?string $model = EcoPoint::class;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon  = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Loyalty';
    protected static ?string $navigationLabel = 'EcoPoints';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Assignment')
                ->columns(2)
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            Section::make('Points')
                ->columns(3)
                ->schema([
                    TextInput::make('points_change')
                        ->label('Points (+/-)')
                        ->numeric()
                        ->required(),

                    TextInput::make('balance_after')
                        ->helperText('Auto-calculated if left empty')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('reason')
                        ->placeholder('swap_completed, bonus, adjustment')
                        ->maxLength(120),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('balance_after')
                    ->label('Balance')
                    ->sortable(),

                TextColumn::make('reason')
                    ->limit(24)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('gains')
                    ->label('Only Gains')
                    ->query(fn ($q) => $q->where('points_change', '>', 0)),

                Filter::make('deductions')
                    ->label('Only Deductions')
                    ->query(fn ($q) => $q->where('points_change', '<', 0)),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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