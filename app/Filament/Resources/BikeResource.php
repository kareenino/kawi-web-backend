<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BikeResource\Pages;
use App\Models\Bike;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BikeResource extends Resource
{
    protected static ?string $model = Bike::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Bikes';
    protected static ?string $pluralModelLabel = 'Bikes';
    protected static ?string $modelLabel = 'Bike';
    protected static ?string $navigationGroup = 'Fleet';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Owner')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
            Forms\Components\Section::make('Identity')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('plate_number')
                        ->label('Plate Number')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('model')
                        ->maxLength(120)
                        ->placeholder('e.g., Spiro Automax 2015'),
                    Forms\Components\TextInput::make('year')
                        ->numeric()
                        ->minValue(1990)
                        ->maxValue(2100),
                ]),
            Forms\Components\Section::make('Status & Maintenance')
                ->columns(3)
                ->schema([
                    Forms\Components\DatePicker::make('insurance_expiry')
                        ->native(false)
                        ->label('Insurance Expiry')
                        ->placeholder('YYYY-MM-DD'),
                    Forms\Components\DatePicker::make('last_serviced_at')
                        ->native(false)
                        ->label('Last Serviced'),
                    Forms\Components\TextInput::make('odometer_km')
                        ->label('Odometer (km)')
                        ->numeric()
                        ->minValue(0),
                ]),
            Forms\Components\Section::make('Media')
                ->columns(1)
                ->schema([
                    Forms\Components\FileUpload::make('photo_url')
                        ->label('Bike Photo')
                        ->image()
                        ->directory('bikes')
                        ->imageEditor()
                        ->downloadable()
                        ->openable(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Plate')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insurance_expiry')
                    ->date()
                    ->label('Insurance')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_serviced_at')
                    ->date()
                    ->label('Serviced')
                    ->sortable(),
                Tables\Columns\TextColumn::make('odometer_km')
                    ->label('Odometer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'name'),
                Tables\Filters\TernaryFilter::make('insured')
                    ->label('Insurance Active')
                    ->trueLabel('Active / in future')
                    ->falseLabel('Expired / missing')
                    ->queries(
                        true: fn (Builder $q) => $q->whereDate('insurance_expiry', '>=', now()->toDateString()),
                        false: fn (Builder $q) => $q->whereNull('insurance_expiry')->orWhereDate('insurance_expiry', '<', now()->toDateString()),
                        blank: fn (Builder $q) => $q,
                    ),
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
            'index'  => Pages\ListBikes::route('/'),
            'create' => Pages\CreateBike::route('/create'),
            'edit'   => Pages\EditBike::route('/{record}/edit'),
        ];
    }
}