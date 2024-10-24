<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemsResource\Pages;
use App\Filament\Resources\ItemsResource\RelationManagers;
use App\Models\Items;
use App\Models\Sizes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemsResource extends Resource
{
    protected static ?string $model = Items::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Items';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('items_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(\App\Models\Category::all()->pluck('categories_name', 'id')),

                // Optional field for price if no sizes are used
                Forms\Components\TextInput::make('items_price')
                    ->label('Price')
                    ->maxLength(255)
                    ->hidden(fn ($get) => $get('use_size')), // Hidden if use_size is enabled

                Forms\Components\Toggle::make('use_size')
                    ->label('Use Size Pricing')
                    ->reactive(),

                // Repeater for size and price (will be visible if 'use_size' is toggled on)
                Forms\Components\Repeater::make('sizes')
                    ->relationship('sizes') // Relasi ke tabel pivot item_size
                    ->schema([
                        Forms\Components\Select::make('size_id')
                            ->label('Size')
                            ->options(Sizes::all()->pluck('size', 'id')) // Mengambil opsi ukuran
                            ->required(),
                        Forms\Components\TextInput::make('pivot.price')
                            ->label('Price')
                            ->numeric()
                            ->required(),
                    ])
                    ->hidden(fn ($get) => !$get('use_size')) // Hidden if 'use_size' is false
                    ->columns(2)
                    ->minItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('items_name')
                    ->label('Item Name'),

                // Display prices for items with or without size
                Tables\Columns\TextColumn::make('items_price')
                    ->label('Price')
                    ->sortable()
                    ->hidden(fn ($record) => $record && $record->sizes()->exists()), // Hide if sizes exist

                // Display size-based prices
                Tables\Columns\TextColumn::make('sizes.pivot.price')
                    ->label('Size Price')
                    ->sortable()
                    ->hidden(fn ($record) => $record && !$record->sizes()->exists()), // Hide if sizes don't exist

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItems::route('/create'),
            'view' => Pages\ViewItems::route('/{record}'),
            'edit' => Pages\EditItems::route('/{record}/edit'),
        ];
    }
}
