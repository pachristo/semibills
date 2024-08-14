<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Filament\Resources\SettingsResource\RelationManagers;
use App\Models\Admin\Setting;
// use App\Filament\Resources\UserResource\Pages;
// use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\Admin\User;
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

class SettingsResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                  // 'ref_com', 'phone', 'email', 'misc', 'created_at', 'updated_at','trans_com'
                  Forms\Components\TextInput::make('ref_com')
                  ->label('Referral Commission')
                  ->required()
                  ->maxLength(255),
                  Forms\Components\TextInput::make('main_acct_no')
                  ->label('Main Account Number')
                  ->required()
                  ->maxLength(255),
                  Forms\Components\TextInput::make('trans_com')
                  ->label('Transfer  Commission')
                  ->required()
                  ->maxLength(255),
                  Forms\Components\TextInput::make('giftcard_com')
                  ->label('Giftcard  Commission')
                  ->required()
                  ->maxLength(255),
                  Forms\Components\TextInput::make('card_charge')
                  ->label('Card Creation  Charge')
                  ->required()
                  ->maxLength(255),
                  
                  
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ref_com')->label('Referral commission'),
            Tables\Columns\TextColumn::make('trans_com')->label('Transfer Commission'),
 
            
            Tables\Columns\TextColumn::make('giftcard_com')->label('Giftcard Commission'),
 

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSettings::route('/'),
            // 'create' => Pages\CreateSettings::route('/create'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }
}
