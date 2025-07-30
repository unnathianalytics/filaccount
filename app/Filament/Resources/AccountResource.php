<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Account;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AccountGroup;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AccountResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccountResource\RelationManagers;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('group_id')
                    ->required()
                    ->options(AccountGroup::all()->pluck('name', 'id')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('mobile'),
                TextInput::make('email')
                    ->email(),
                Toggle::make('is_registered')
                    ->required(),
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required(),
                TextInput::make('gstin'),
                TextInput::make('pan'),
                Toggle::make('is_additive')
                    ->required(),
                TextInput::make('op_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Radio::make('cr_dr')
                    ->label('Cr/Dr')
                    ->options([
                        'cr' => 'Credit',
                        'dr' => 'Debit',
                    ])
                    ->default('dr')
                    ->required()
                    ->inline(),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_registered')
                    ->boolean(),
                Tables\Columns\TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gstin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_additive')
                    ->boolean(),
                Tables\Columns\TextColumn::make('op_balance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cr_dr')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make()
                    ->disabled(fn($record) => ! $record->is_deletable),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()

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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
