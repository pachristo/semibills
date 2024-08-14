<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Admin\Referral;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefRelationManager extends RelationManager
{
    protected static string $relationship = 'ref';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('Referals')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Referals')
            ->columns([
                Tables\Columns\TextColumn::make('ref.name')
                ->label('Referree Details')
                ->description(function(Referral $record){
                  return  $record->ref->email;
                } ),
                Tables\Columns\TextColumn::make('user.name')
                ->label('Referrer Details')
                ->description(function(Referral $record){
                  return  $record->user->email;
                } ),

                Tables\Columns\TextColumn::make('created_at')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}