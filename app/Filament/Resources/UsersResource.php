<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
// use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\Admin\User;
use App\Models\Referral;
use App\Models\Support;
use App\Models\Beneficiary;
use App\Models\APITransaction;
// use App\Models\
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
// use Filament\Model;
use Filament\Tables\Table;
use Filament\Forms\Components;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\GlobalSearch\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Validation\Rule;
use App\Filament\Resources\UserResource\RelationManagers\RefRelationManager;
class UsersResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone', 'wallet_ngn'];
    }
    public static function validationRules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(request()->route('record')->id ?? null),
            ],
            // other validation rules for other fields...
        ];
    }
    public static function form(Form $form): Form
    {

        // 'id', 'name', 'firstname', 'lastname', 'email', 'state', 'lga', 'phone', 'bank_name', 'bank_account_no', 'bank_account_name', 'device_token', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'address', 'pass_token', 'email_verified', 'email_code', 'wallet_ngn', 'username', 'acct_name', 'acct_no', 'acct_status', 'acct_customer_id', 'acct_email', 'acct_phone', 'dod', 'nin', 'wema_tracking_id', 'pin', 'pin_token', 'ps_cus_code', 'ps_cus_id'
        return $form->schema([
            //
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
     
    
            Components\TextInput::make('bank_account_no')
            ->maxLength(25),
    
            Components\TextInput::make('bank_account_name')
            ->maxLength(25),

            Forms\Components\TextInput::make('acct_name')
            ->label('SafeHaven Account Name')
            ->disabled(),
            Forms\Components\TextInput::make('acct_no')
            ->label('SafeHaven Account number')
            ->disabled(),
            Forms\Components\TextInput::make('acct_status')
            ->label('SafeHaven Account Status')
            ->disabled(),
         
            
           
            

    

        ]);
    }
 
  
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('wallet_ngn'),
                Tables\Columns\TextColumn::make('created_at'),
               
 
IconColumn::make('email_verified')
    ->options([
   
        'heroicon-s-no-symbol' => '0',
        'heroicon-s-check-badge' => '1',
    ])
    ->size('md')
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // ...
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()    ->requiresConfirmation()
                    ->action(function (User $record) {
                        Referral::where('user_id', $record->id)->orWhere('referer',$record->id)->delete();
                        Beneficiary::where('user_id', $record->id)->delete();
                        APITransaction::where('user_id', $record->id)->delete();
                        Support::where('user_id', $record->id)->delete();

                    
                    }),
                ]),
            ])->paginatedWhileReordering();

    }


    public static function getRelations(): array
    {
        return [
                //
           'Referrals'=>     RefRelationManager::class,
            ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }
    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUsers::route('/create'),
            // 'edit' => Pages\EditUsers::route('/{record}/edit'),
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'view' => Pages\ViewUsers::route('/{record}'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
    
        ];
    }

}
