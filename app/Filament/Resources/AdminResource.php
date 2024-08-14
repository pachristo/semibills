<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin\Admin;
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
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // 'id', 'name', 'email', 'email_verified_at', 'avatar', 'phone_number', 'status', 'password', 'remember_token', 'created_at', 'updated_at', 'role', 'date_auth', 'type'
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label('Email address')
                ->email()
                // ->unique(column: 'email')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone_number')
                ->label('Phone number')
                ->tel()
                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        '0' => 'Supper-Admin',
                    '1' => 'Sub-Admin',
                        // 'user' => 'User',
                    ])
                    ->required(),
                     
                    Forms\Components\TextInput::make('password')
->password()
->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
->dehydrated(fn (?string $state): bool => filled($state))
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone_number'),
                Tables\Columns\TextColumn::make('created_at')
                ->since(),
           
                    Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn (string $state): string => $state === '0' ? 'Super Admin' : 'Sub Admin')
                    ->label('Admin type')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        // 'draft' => 'gray',
        '1' => 'warning',
        '0' => 'success',
        // 'rejected' => 'danger',
    })
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
