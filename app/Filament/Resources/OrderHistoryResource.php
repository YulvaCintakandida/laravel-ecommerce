<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderHistoryResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class OrderHistoryResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Riwayat Pesanan';
    // protected static ?string $modelLabel = 'Order History';
    protected static ?string $pluralModelLabel = 'Riwayat Pesanan';

        public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', ['completed', 'cancelled'])  // ONLY show completed and cancelled
            ->with(['user', 'items', 'items.product'])
            ->tap(function (Builder $query) {
                Log::info('Order History Query', [
                    'sql' => $query->toSql(),
                    'bindings' => $query->getBindings()
                ]);
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label('No')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->label('Total Pembayaran')
                    ->sortable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Order $record) => route('order.download', $record))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Order ID')
                            ->disabled(),
                            Forms\Components\Placeholder::make('name')
                            ->label('Customer Name')
                            ->content(fn ($record) => $record->user?->name ?? '-'),  
                        Forms\Components\TextInput::make('total')
                            ->label('Total Pembayaran')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        
                            Forms\Components\Placeholder::make('delivery_method')
                            ->label('Metode Pengiriman')
                            ->content(function ($record) {
                                return match($record->delivery_method) {
                                    'pickup' => 'Pickup (Ambil di Toko)',
                                    'delivery' => 'Delivery (Dikirim ke Alamat)',
                                    default => $record->delivery_method
                                };
                            }),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Order Date')
                            ->disabled(),
                    ])->columns(2),

                    Forms\Components\Section::make('Order Items')
                    ->schema([
                        Forms\Components\Placeholder::make('order_items')
                            ->content(function ($record) {
                                if (!$record || !$record->items) {
                                    return 'No items found';
                                }
                                
                                $html = '<div class="overflow-x-auto"><table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Product</th>
                                            <th class="text-left">Quantity</th>
                                            <th class="text-left">Price</th>
                                            <th class="text-left">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                
                                    $subtotal = 0;
        
                                    foreach ($record->items as $item) {
                                        $product = $item->product ? $item->product->name : 'Unknown Product';
                                        $itemSubtotal = $item->price * $item->quantity;
                                        $subtotal += $itemSubtotal;
                                        
                                        $html .= "<tr>
                                            <td>{$product}</td>
                                            <td>{$item->quantity}</td>
                                            <td>Rp " . number_format($item->price, 0, ',', '.') . "</td>
                                            <td>Rp " . number_format($itemSubtotal, 0, ',', '.') . "</td>
                                        </tr>";
                                    }
                                    
                                    // Add discount row if applicable
                                    if ($record->voucher_id && $record->discount_amount > 0) {
                                        $html .= "<tr class='bg-base-200'>
                                            <td colspan='3' class='text-right font-medium'>Subtotal:</td>
                                            <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                                        </tr>
                                        <tr class='bg-base-200 text-success'>
                                            <td colspan='3' class='text-right font-medium'>Discount:</td>
                                            <td>- Rp " . number_format($record->discount_amount, 0, ',', '.') . "</td>
                                        </tr>
                                        <tr class='bg-base-200 font-bold'>
                                            <td colspan='3' class='text-right'>Total:</td>
                                            <td>Rp " . number_format($record->total, 0, ',', '.') . "</td>
                                        </tr>";
                                    } else {
                                        $html .= "<tr class='bg-base-200 font-bold'>
                                            <td colspan='3' class='text-right'>Total:</td>
                                            <td>Rp " . number_format($record->total, 0, ',', '.') . "</td>
                                        </tr>";
                                    }
                                
                                $html .= '</tbody></table></div>';
                                
                                return new \Illuminate\Support\HtmlString($html);
                            })
                    ]),

                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\Placeholder::make('email')
                        ->label('Email')
                        ->content(fn ($record) => $record->user?->email ?? '-'),       
                        Forms\Components\Placeholder::make('phone')
                            ->label('Telepon')
                            ->content(fn ($record) => $record->user?->phone ?? '-'),
                        Forms\Components\Placeholder::make('address')
                            ->label('Alamat')
                            ->content(fn ($record) => $record->user?->address ?? '-'),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);
        
        Log::info('Order Data', [
            'order' => $this->record->toArray(),
            'user' => $this->record->user?->toArray(),
            'items' => $this->record->items?->toArray()
        ]);
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListOrderHistories::route('/'),
        'view' => Pages\ViewOrderHistory::route('/{record}'),
    ];
}
}
