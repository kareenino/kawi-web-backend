<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Bike;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
// use Filament\Actions\EditAction;
// use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
// use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\BikeResource\Pages;

class BikeResource extends Resource
{
    protected static ?string $model = Bike::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Bikes';
    // protected static ?string $pluralModelLabel = 'Bikes';
    // protected static ?string $modelLabel = 'Bike';
    protected static ?string $navigationGroup = 'Fleet';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Owner')
                ->columns(2)
                ->schema([
                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
            Section::make('Identity')
                ->columns(3)
                ->schema([
                    TextInput::make('plate_number')
                        ->label('Plate Number')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(50),
                    TextInput::make('name')
                        ->maxLength(120)
                        ->placeholder('e.g., Spiro Automax 2015'),
                ]),
            Section::make('Status & Maintenance')
                ->columns(3)
                ->schema([
                    DatePicker::make('insurance_expiry')
                        ->native(false)
                        ->label('Insurance Expiry')
                        ->placeholder('YYYY-MM-DD'),
                    DatePicker::make('last_serviced_at')
                        ->native(false)
                        ->label('Last Serviced'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plate_number')
                    ->label('Plate')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('insurance_expiry')
                    ->date()
                    ->label('Insurance')
                    ->sortable(),
                TextColumn::make('last_serviced_at')
                    ->date()
                    ->label('Serviced')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'name'),
                TernaryFilter::make('insured')
                    ->label('Insurance Active')
                    ->trueLabel('Active / in future')
                    ->falseLabel('Expired / missing')
                    ->queries(
                        true: fn(Builder $q) => $q->whereDate('insurance_expiry', '>=', now()->toDateString()),
                        false: fn(Builder $q) => $q->whereNull('insurance_expiry')->orWhereDate('insurance_expiry', '<', now()->toDateString()),
                        blank: fn(Builder $q) => $q,
                    ),
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
            'index'  => Pages\ListBikes::route('/'),
            'create' => Pages\CreateBike::route('/create'),
            'edit'   => Pages\EditBike::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    $user = Auth::user();

    if ($user && $user->hasRole('operator')) {
        $query->where('operator_id', $user->operator_id);
    }

    return $query;
}

}
