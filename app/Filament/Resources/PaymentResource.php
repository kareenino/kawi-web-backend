<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\PaymentResource\Pages;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon  = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $pluralModelLabel = 'Payments';
    protected static ?string $modelLabel       = 'Payment';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Who & What')
                ->columns(3)
                ->schema([
                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('swap_history_id')
                        ->label('Swap History')
                        ->relationship('swapHistory', 'id')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Select::make('method')
                        ->options([
                            'mpesa' => 'M-Pesa',
                            'cash'  => 'Cash',
                        ])
                        ->required(),
                ]),

            Section::make('Amounts & Status')
                ->columns(3)
                ->schema([
                    TextInput::make('amount')
                        ->numeric()
                        ->prefix('KES')
                        ->required(),

                    Select::make('status')
                        ->options([
                            'pending'   => 'Pending',
                            'succeeded' => 'Succeeded',
                            'failed'    => 'Failed',
                            'refunded'  => 'Refunded',
                        ])
                        ->required()
                        ->default('pending'),

                    TextInput::make('reference')
                        ->label('Reference / Receipt #')
                        ->maxLength(255),
                ]),

            Section::make('M-Pesa Details')
                ->columns(2)
                ->schema([
                    TextInput::make('mpesa_phone')
                        ->label('M-Pesa Phone (2547xxxxxxx)')
                        ->maxLength(20),

                    TextInput::make('mpesa_receipt')
                        ->label('M-Pesa Receipt')
                        ->maxLength(255),

                    TextInput::make('merchant_request_id')
                        ->maxLength(255)
                        ->helperText('Returned by STK init'),

                    TextInput::make('checkout_request_id')
                        ->maxLength(255)
                        ->helperText('Returned by STK init'),

                    TextInput::make('result_code')
                        ->label('Result Code')
                        ->maxLength(255),

                    TextInput::make('result_desc')
                        ->label('Result Description')
                        ->maxLength(255),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('swap_history_id')
                    ->label('Swap')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('method')
                    ->colors([
                        'primary' => 'mpesa',
                        'success' => 'cash',
                    ])
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Amount (KES)')
                    ->numeric(2)
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'succeeded',
                        'danger'  => 'failed',
                        'secondary' => 'refunded',
                    ])
                    ->sortable(),

                TextColumn::make('mpesa_receipt')
                    ->label('Receipt')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->options(['mpesa' => 'M-Pesa', 'cash' => 'Cash']),
                SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'succeeded' => 'Succeeded',
                        'failed'    => 'Failed',
                        'refunded'  => 'Refunded',
                    ]),
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
            'index'  => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit'   => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}