<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendaceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendace';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->required()
                    ->options(User::query()->pluck('name', 'id'))
                    ->unique(),
                Forms\Components\Checkbox::make('is_present'),
                Forms\Components\Checkbox::make('is_read'),
                Forms\Components\DateTimePicker::make('read_time')
                    ->default(now()),
                Forms\Components\Textarea::make('note')

            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('is_present'),
                Tables\Columns\TextColumn::make('note')
                    ->wrap(),
                Tables\Columns\TextColumn::make('read_time')
                    ->grow(false),
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
