<?php

namespace App\Filament\Resources\DistributorApplications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DistributorApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('company'),
                TextInput::make('country'),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('estimated_order_volume'),
                Textarea::make('message')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'new' => 'New',
            'reviewing' => 'Reviewing',
            'contacted' => 'Contacted',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'closed' => 'Closed',
        ])
                    ->default('new')
                    ->required(),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
            ]);
    }
}
