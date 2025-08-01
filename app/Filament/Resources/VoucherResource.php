<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $modelLabel = 'Voucher';
    protected static ?string $pluralModelLabel = 'Voucher';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Voucher')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('discount_type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('discount_value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix(fn (Forms\Get $get) => $get('discount_type') === 'percentage' ? '%' : 'Rp'),
                Forms\Components\TextInput::make('max_usage')
                    ->label('Maksimal Penggunaan')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Toggle::make('is_vip_only')
                    ->label('Khusus Member VIP')
                    ->helperText('Jika diaktifkan, voucher hanya tersedia untuk member VIP')
                    ->default(false),
                    Forms\Components\Select::make('product_id')
                    ->label('Produk Spesifik (Opsional)')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Berlaku untuk semua produk')
                    ->helperText('Jika dipilih, voucher hanya berlaku untuk produk ini saja'),    
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                ->label('Tanggal Berakhir')
                    ->required()
                    ->afterOrEqual('start_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc') // Tambahkan baris ini untuk mengurutkan dari terbaru
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label('No')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Voucher')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_value')
                    ->label('Nilai Diskon')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->discount_type === 'percentage' 
                            ? "{$state}%" 
                            : "Rp " . number_format($state, 2)),
                Tables\Columns\TextColumn::make('current_usage')
                    ->label('Terpakai')
                    ->formatStateUsing(fn ($state, $record) => 
                        "{$state} / {$record->max_usage}"),
                        Tables\Columns\IconColumn::make('is_vip_only')
                        ->label('VIP Only')
                        ->boolean()
                        ->trueIcon('heroicon-o-star')
                        ->falseIcon('heroicon-o-minus-small')
                        ->trueColor('success'),
                Tables\Columns\TextColumn::make('product.name')
                        ->label('Produk Spesifik')
                        ->placeholder('Semua Produk'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('discount_type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ]),
                Tables\Filters\Filter::make('is_vip_only')
                    ->label('VIP Vouchers')
                    ->query(fn (Builder $query): Builder => $query->where('is_vip_only', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}