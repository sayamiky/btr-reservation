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
                        'transfer'
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
                        Forms\Components\TextInput::make('note')
                            ->label('Note'),
                    ]),

                Forms\Components\Group::make()
                    ->relationship(
                        'guest',
                    )
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->requiredWith('name'),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->cols(4)
                            ->maxLength(65535)
                            ->label('Address'),
                    ]),
                Forms\Components\Repeater::make('reservation_details')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservation_code')->limit(40)->copyable(),
                Tables\Columns\TextColumn::make('guest.name'),
                Tables\Columns\TextColumn::make('reservation_date')->date(),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\TextColumn::make('status')->enum([
                    'not paid' => 'Not Paid',
                    'paid' => 'Paid',
                    'cancel' => 'Cancel',
                ]),
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
