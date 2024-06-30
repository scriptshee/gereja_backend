<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form User')
                    ->description('Tambahkan user')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                        // Forms\Components\TextInput::make('username')
                        //     ->unique(ignoreRecord: true)
                        //     ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->unique(ignoreRecord: true),
                        Password::make('password')
                            ->maxLength(255)
                            ->nullable(fn (?string $operation) => $operation === 'edit')
                            ->required(fn (?string $operation) => $operation === 'create')
                            ->dehydrateStateUsing(static function (?string $state, string $operation) {
                                if ($operation === 'create') {
                                    return !empty($state) ? Hash::make($state) : null;
                                } elseif ($state) {
                                    return Hash::needsRehash($state) ? Hash::make($state) : $state;
                                }
                            })
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generate')
                                    ->tooltip('Generate Password')
                                    ->icon('heroicon-o-sparkles')
                                    ->action(function (Forms\Set $set) {
                                        $set('password', Str::random(6));
                                    })
                            ),
                        // Forms\Components\Select::make('roles')
                        //     ->multiple()
                        //     ->preload()
                        //     ->relationship('roles', 'name'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
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
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
