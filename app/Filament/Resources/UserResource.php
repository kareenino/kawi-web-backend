<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Management';
    
    public static function getNavigationLabel(): string
    {
        return 'Users';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('password')
                    ->required()
                    ->readOnly()
                    ->visibleOn('create'),
                TextInput::make('role')->required(),
                TextInput::make('phone')->required(),
                Textarea::make('role'),
                Textarea::make('address'),
                FileUpload::make('image')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('image')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('primary'),
                // Tables\Columns\TextColumn::make('password')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('remember_token')
                //     ->dateTime()
                //     ->sortable(),
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
            // ->filtersFormColumns(3)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
