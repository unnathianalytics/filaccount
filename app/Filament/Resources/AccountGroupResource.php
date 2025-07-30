<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AccountGroup;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccountGroupResource\Pages;
use App\Filament\Resources\AccountGroupResource\RelationManagers;

class AccountGroupResource extends Resource
{
    protected static ?string $model = AccountGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Toggle::make('is_primary')
                    ->default(true)
                    ->live()
                    ->label('Is Primary Group'),
                Select::make('primary_id')
                    ->options(AccountGroup::all()->pluck('name', 'id'))
                    ->nullable()
                    ->hidden(fn($get) => $get('is_primary'))
                    ->required(fn($get) => !$get('is_primary')),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_id')
                    ->sortable(),
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
            'index' => Pages\ListAccountGroups::route('/'),
            'create' => Pages\CreateAccountGroup::route('/create'),
            'edit' => Pages\EditAccountGroup::route('/{record}/edit'),
        ];
    }
}
