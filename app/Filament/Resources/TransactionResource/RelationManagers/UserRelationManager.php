<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    public function form(Form $form): Form
    {
        return $form->schema([
            //
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label('Email address')
                ->email()
                // ->unique(column: 'email')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label('Phone number')
                ->tel()
                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                ->required(),
                Forms\Components\TextInput::make('wallet_ngn')
                ->label('wallet Balance')
                ->numeric()
                ,
                DatePicker::make('dod')->label('Date Of Birth'),
                Components\TextInput::make('bank_name')
                ->maxLength(25),
    
            Components\TextInput::make('bank_account_no')
            ->maxLength(25),
    
            Components\TextInput::make('bank_account_name')
            ->maxLength(25),

            Forms\Components\TextInput::make('acct_name')
            ->label('Paystack Account Name')
            ->disabled(),
            Forms\Components\TextInput::make('acct_no')
            ->label('Paystack Account number')
            ->disabled(),
            Forms\Components\TextInput::make('acct_status')
            ->label('Paystack Account Status')
            ->disabled(),
            Forms\Components\TextInput::make('ps_cus_id')
            ->label('Paystack Customer  ID ')
            ->disabled(),
            
           
            

    

        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('User')
            ->columns([
                // Tables\Columns\TextColumn::make('User'),
                      //
                      Tables\Columns\TextColumn::make('name'),
                      Tables\Columns\TextColumn::make('email'),
                      Tables\Columns\TextColumn::make('phone'),
                      Tables\Columns\TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
