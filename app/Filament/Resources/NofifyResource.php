<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NofifyResource\Pages;
use App\Filament\Resources\NofifyResource\RelationManagers;
use App\Models\Admin\Notify ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
class NofifyResource extends Resource
{
    protected static ?string $model = Notify::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('subject')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),  
                Forms\Components\Textarea::make('text')
            ->rows(5)
            ->required()
            ->columnSpanFull()
            ->cols(20),
            Forms\Components\Select::make('recipient')
            ->label('Users')
            ->options(
                [0 => 'All Users'] + \App\Models\User::whereNotNull('device_token')->pluck('name', 'id')->toArray()
                )        
                ->searchable()
            // ->multiple()
            ->required(),
            Forms\Components\Select::make('target')
            ->label('Target')
            ->options([
                'all'=>' Email and  Push notification',
                  'fcm'=>'   Push notification',
                  'email'=>'Email'
            ])
            ->searchable()
            // ->multiple()
            ->required(),
    
            ]);
          
        }
    public static function getPluralModelLabel(): string
    {
        return 'Notification';
    }

    public static function getNavigationLabel(): string
    {
        return 'Notification';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                //  'subject','text','status','target','recipient'

                TextColumn::make('subject'),
                // TextColumn::make('match_id'),
                TextColumn::make('text'),
                // TextColumn::make('away_name'),
                TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        // 'draft' => 'gray',
        'published' => 'success',
        'unpublished' => 'warning',
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNofifies::route('/'),
            'create' => Pages\CreateNofify::route('/create'),
            'edit' => Pages\EditNofify::route('/{record}/edit'),
        ];
    }
}
