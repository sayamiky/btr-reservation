<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Driver;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('reservation_date')
                    ->required()
                    ->format('Y-m-d'),
                Forms\Components\TextInput::make('voucher_code')
                    ->nullable(),
                Forms\Components\Select::make('payment_type')
                    ->options([
                        'cc' => 'Credit Card',
                        'cash' => 'Cash',
                    ]),
                Forms\Components\Select::make('partner_id')
                    ->label('Partner')
                    ->options(Partner::all()->pluck('name', 'id'))
                    ->searchable(),

                Forms\Components\Group::make()
                    ->relationship(
                        'transfer',
                        condition: fn (?array $state): bool => filled($state['driver_id']),
                    )
                    ->schema([
                        Forms\Components\Select::make('driver_id')
                            ->label('Driver')
                            ->options(Driver::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\TextInput::make('pickup_location')
                            ->label('Pick Up Location'),
                        Forms\Components\TextInput::make('pickup_time')
                            ->label('Pick Up Time'),
                        Forms\Components\TextInput::make('dropoff_location')
                            ->label('Drop Off Location'),
                        Forms\Components\TextInput::make('dropoff_time')
                            ->label('Drop Off Time'),
                        Forms\Components\TextInput::make('distance')
                            ->label('Distance')
                            ->numeric(),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric(),
                        Forms\Components\TextInput::make('Note')
                            ->label('Note'),
                        // Forms\Components\TextInput::make('email')
                        //     ->label('Email address')
                        //     ->email()
                        //     ->requiredWith('name'),
                    ]),
                Forms\Components\Repeater::make('Reservation Details')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\Select::make('pax_type')
                            ->options([
                                'adult' => 'Adult',
                                'child' => 'Child',
                            ]),
                        Forms\Components\TextInput::make('qty')->required(),
                    ])
                    ->columns(2),
                // Forms\Components\Textarea::make('description')
                //     ->required()
                //     ->cols(4)
                //     ->maxLength(65535),
                // Forms\Components\FileUpload::make('file')
                //     ->disk('local')
                //     ->directory('products')
                //     ->visibility('private'),
                // Forms\Components\Toggle::make('status')
                //     ->required()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservation_code')->limit(40),
                Tables\Columns\TextColumn::make('reservation_date')->limit(40),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\IconColumn::make('status'),
            ])
            ->filters([
                Tables\Filters\Filter::make('reservation_code'),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
