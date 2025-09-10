<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use DeepCopy\Filter\Filter;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Reviews';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Review Details')
                ->schema([
                    Select::make('station_id')
                        ->label('Station')
                        ->relationship('station', 'name') // requires Station::getAttribute('name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name') // or 'email'
                        ->searchable()
                        ->preload()
                        ->required(),

                    Textarea::make('rating')
                        ->label('Rating')
                        ->min(1)->max(5)->step(1)
                        ->required(),

                    Textarea::make('comment')
                        ->label('Comment')
                        ->rows(4)
                        ->maxLength(2000)
                        ->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('station.name')
                    ->label('Station')->sortable()->searchable(),
                TextColumn::make('user.name')
                    ->label('User')->sortable()->searchable(),
                TextColumn::make('rating')
                    ->badge()
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state == 3 ? 'warning' : 'danger'))
                    ->sortable(),
                TextColumn::make('comment')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->since() // “2 hours ago”
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('station_id')
                    ->label('Station')
                    ->relationship('station', 'name'),
                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name'),
                TrashedFilter::make()->hidden(), // show if using SoftDeletes
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit'   => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}