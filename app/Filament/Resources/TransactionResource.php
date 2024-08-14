<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\APITransaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
// use Filament\Model;
use Filament\Tables\Table;
use Filament\Forms\Components;
use App\Filament\Resources\TransactionResource\RelationManagers\UserRelationManager;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\GlobalSearch\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
class TransactionResource extends Resource
{
    protected static ?string $model = APITransaction::class;
    protected static ?string $recordTitleAttribute = 'name';
    public static function getGloballySearchableAttributes(): array
    {
        return ['trans_id', 'trans_type', 'trans_name', 'api_source','created_at'];
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at', 'data_json', 'status','nin'
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Components\TextInput::make('trans_id')
                ->label('Transaction ID')
                ->disabled(),
    
                Components\TextInput::make('trans_type')
                ->label('Transaction Type')
                ->disabled(),

                Components\TextInput::make('trans_name')
                ->label('Transaction Name')
                ->disabled(),

                Components\TextInput::make('api_source')
                ->label('API Source')
                ->disabled(),
    
                Components\TextInput::make('amount')
                ->label('Amount (NGN)')
                ->disabled(),
                Components\TextInput::make('created_at')
           
                ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                    Tables\Columns\TextColumn::make('user.email')->label('User email'),
            
              

                Tables\Columns\TextColumn::make('trans_id')->label('Transaction Id'),

                Tables\Columns\TextColumn::make('trans_name')->label('Transaction Name'),        

                Tables\Columns\TextColumn::make('trans_type')->label('Transaction Type'),  
                Tables\Columns\TextColumn::make('isReversed')->label('Reversal status'),        
                // Tables\Columns\TextColumn::make('api_source')->label(' API Source'), 
                Tables\Columns\TextColumn::make('amount')->label('Amount (NGN)'),        
                Tables\Columns\TextColumn::make('created_at'),  
                   
                        
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public function isTableSearchable(): bool
{
    return true;
}
protected function isTablePaginationEnabled(): bool 
{
    return true;
} 
    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
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
            'view' => Pages\ViewTransactionResource::route('/{record}'),
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
