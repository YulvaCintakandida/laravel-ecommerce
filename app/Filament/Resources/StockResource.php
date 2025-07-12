<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $pluralModelLabel = 'Stok';

    protected static ?string $modelLabel = 'Stok';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label('No')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_in')
                    ->label('Stok Masuk')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()->label('Total Stock In'),
                    ]),
                Tables\Columns\TextColumn::make('stock_out')
                    ->label('Stok Keluar')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()->label('Total Stock Out'),
                    ]),
                Tables\Columns\TextColumn::make('current_stock')
                    ->label('Stok Tersedia')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->label('Produk')
                    ->relationship('product', 'name')
            ])
            ->groups([
                'product.name',
                'created_at',
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
        ];
    }
}