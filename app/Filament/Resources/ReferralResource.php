<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralResource\Pages;
use App\Filament\Resources\ReferralResource\RelationManagers;
use App\Models\Admin\Referral;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

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
              ,
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
      public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // ->where('is_active', true)
            ->whereHas('user', function (Builder $query) {
                $query->whereNotNull('id'); // Ensures user exists
            })
            ->whereHas('ref', function (Builder $query) {
                $query->whereNotNull('id'); // Ensures referer exists
            });
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
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }
}
