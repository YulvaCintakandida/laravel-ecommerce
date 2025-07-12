<?php

namespace App\Filament\Pages\Auth;
use Filament\Pages\Auth\Register as BaseRegister;

use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister 
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getAddressFormComponent(),
                        // $this->getRoleFormComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }
 
    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->options([
                'seller' => 'seller',
                'customer' => 'customer',
            ])
            ->default('seller')
            ->required();
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->tel()
            ->required()
            ->maxLength(15);
    }

    protected function getAddressFormComponent(): Component
    {
        return Textarea::make('address')
            ->required()
            ->maxLength(255)
            ->rows(3);
    }
}
