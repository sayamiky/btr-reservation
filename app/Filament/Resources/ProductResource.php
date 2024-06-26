<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
// use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->cols(4)
                    ->maxLength(65535),
                Forms\Components\FileUpload::make('file')
                    ->disk('local')
                    ->directory('products')
                    ->visibility('private'),
                Forms\Components\Toggle::make('status')
                    ->required()
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->limit(40),
                Tables\Columns\TextColumn::make('description')->limit(40),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\IconColumn::make('status')->boolean(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
