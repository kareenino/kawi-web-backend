<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon  = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $pluralModelLabel = 'Payments';
    protected static ?string $modelLabel       = 'Payment';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Who & What')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\Select::make('swap_history_id')
                        ->label('Swap History')
                        ->relationship('swapHistory', 'id')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Forms\Components\Select::make('method')
                        ->options([
                            'mpesa' => 'M-Pesa',
                            'cash'  => 'Cash',
                        ])
                        ->required(),
                ]),

            Forms\Components\Section::make('Amounts & Status')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->prefix('KES')
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->options([
                            'pending'   => 'Pending',
                            'succeeded' => 'Succeeded',
                            'failed'    => 'Failed',
                            'refunded'  => 'Refunded',
                        ])
                        ->required()
                        ->default('pending'),

                    Forms\Components\TextInput::make('reference')
                        ->label('Reference / Receipt #')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('M-Pesa Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('mpesa_phone')
                        ->label('M-Pesa Phone (2547xxxxxxx)')
                        ->maxLength(20),

                    Forms\Components\TextInput::make('mpesa_receipt')
                        ->label('M-Pesa Receipt')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('merchant_request_id')
                        ->maxLength(255)
                        ->helperText('Returned by STK init'),

                    Forms\Components\TextInput::make('checkout_request_id')
                        ->maxLength(255)
                        ->helperText('Returned by STK init'),

                    Forms\Components\TextInput::make('result_code')
                        ->label('Result Code')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('result_desc')
                        ->label('Result Description')
                        ->maxLength(255),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('swap_history_id')
                    ->label('Swap')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('method')
                    ->colors([
                        'primary' => 'mpesa',
                        'success' => 'cash',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount (KES)')
                    ->numeric(2)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'succeeded',
                        'danger'  => 'failed',
                        'secondary' => 'refunded',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('mpesa_receipt')
                    ->label('Receipt')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->options(['mpesa' => 'M-Pesa', 'cash' => 'Cash']),
                Tables\Filters\SelectFilter::make('status')
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