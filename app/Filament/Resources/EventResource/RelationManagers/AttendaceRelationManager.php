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
                    ->label('Anggota')
                    ->searchable()
                    ->required()
                    ->options(User::query()->pluck('name', 'id'))
                    ->unique(),
                Forms\Components\Checkbox::make('is_present')
                    ->label('Kehadiran'),
                Forms\Components\Checkbox::make('is_read')
                    ->label('Dibaca'),
                Forms\Components\DateTimePicker::make('read_time')
                    ->label('Tgl. Waktu dibaca')
                    ->required()
                    ->default(now()),
                Forms\Components\Textarea::make('note')
                    ->label('Catatan')
                    ->required()

            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('is_present')
                    ->getStateUsing(fn($record) => $record->is_present ? 'Hadir' : 'Tidak Hadir'),
                Tables\Columns\TextColumn::make('note')
                    ->wrap(),
                Tables\Columns\TextColumn::make('read_time')
                    ->grow(false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('lg'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
