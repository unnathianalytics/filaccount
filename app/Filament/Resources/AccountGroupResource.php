<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountGroupResource\Pages;
use App\Filament\Resources\AccountGroupResource\RelationManagers;
use App\Models\AccountGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountGroupResource extends Resource
{
    protected static ?string $model = AccountGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('primary_id')
                    ->numeric(),
                Forms\Components\Toggle::make('is_editable')
                    ->required(),
                Forms\Components\Toggle::make('is_deletable')
                    ->required(),
                Forms\Components\TextInput::make('user')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_editable')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_deletable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('user')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
