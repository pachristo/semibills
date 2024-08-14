<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportResource\Pages;
use App\Filament\Resources\SupportResource\RelationManagers;
use App\Models\Support;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// protected $fillable =['id', 'user_id', 'subject', 'type', 'text', 'status', 'created_at', 'updated_at'];
// 
use App\Filament\Resources\SupportResource\RelationManagers\UserRelationManager;
use Filament\Forms\Components;
// use Filament\Resources\Forms\Components;
use Filament\Resources\RelationManager;
use App\Models\User; // Assuming this is the model for the Profile resource


class SupportResource extends Resource
{
    protected static ?string $model = Support::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $form
        ->schema([
            Components\TextInput::make('subject')
                ->label('Transaction Type')
                ->disabled(),
            Components\TextInput::make('type')
                ->label('Type')
                ->disabled(),
            Components\Textarea::make('text')
                ->label('Text')
                ->disabled(),
            Components\TextInput::make('created_at')
                ->label('Created At')
                ->disabled(),
            // If you want to include more components, add them here
        ]);

    return $form;

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                //
                   
                Tables\Columns\TextColumn::make('user.email')->label('User email'),
            
              

                Tables\Columns\TextColumn::make('subject')->label('Subject '),

                Tables\Columns\TextColumn::make('type')->label('Type'),        

                Tables\Columns\TextColumn::make('trans_type')->label('Transaction Type'),        
                // Tables\Columns\TextColumn::make('api_source')->label(' API Source'), 
                // Tables\Columns\TextColumn::make('amount')->label('Amount (NGN)'),        
                Tables\Columns\TextColumn::make('created_at'),  
                   
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            // 'user' =>UserResource::class,
            UserRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
                'view' =>Pages\ViewSupportResource::route('/{record}'),
            'index' => Pages\ListSupports::route('/'),
            // 'create' => Pages\CreateSupport::route('/create'),
            // 'edit' => Pages\EditSupport::route('/{record}/edit'),
        ];
    }
}
