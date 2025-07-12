<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlavourResource\Pages;
use App\Models\Flavour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;


class FlavourResource extends Resource
{
    protected static ?string $model = Flavour::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $pluralModelLabel = 'Kategori Rasa';

    protected static ?string $modelLabel = 'Kategori Rasa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nama Varian Rasa')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if ($state !== null) {
                        $set('slug', Str::slug($state));
                    }
                }),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->disabled() // Make it read-only
                    ->dehydrated() // Will still be saved to database even though disabled
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Slug dibuat otomatis dari Nama Varian Rasa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label('No')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Varian Rasa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, Flavour $record) {
                        // Check if the flavour is used in any products
                        if ($record->products()->count() > 0) {
                            Notification::make()
                                ->title('Varian Rasa tidak dapat dihapus')
                                ->body('Varian Rasa ini sedang digunakan oleh ' . $record->products()->count() . ' produk.')
                                ->danger()
                                ->send();
                                
                            $action->cancel();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlavours::route('/'),
            'create' => Pages\CreateFlavour::route('/create'),
            'edit' => Pages\EditFlavour::route('/{record}/edit'),
        ];
    }
}