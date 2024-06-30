<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Kegiatan')
                    ->description('Input data kegiatan')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->disk('public')
                            ->directory('event')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('event'),
                        Forms\Components\DateTimePicker::make('start_datetime')
                            ->native()
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_datetime')
                            ->native(),
                        Forms\Components\Checkbox::make('is_endedtime')
                            ->label('Sampai Selesai'),
                        Forms\Components\Select::make('user_id')
                            ->options(fn () => User::query()->pluck('name', 'id'))
                            ->default(auth()->id())
                            ->searchable()
                    ])
                    ->columns(2)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->grow(),
                Tables\Columns\TextColumn::make('start_datetime')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_datetime')
                    ->default('-'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('author'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }

    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Infolists\Components\Split::make([
    //                 Infolists\Components\Section::make()
    //                     ->schema([
    //                         Infolists\Components\ImageEntry::make('thumbnail'),
    //                     ]),
    //                 Infolists\Components\Section::make()
    //                     ->schema([
    //                         Infolists\Components\TextEntry::make('title')
    //                     ])
    //             ])
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}/detail')
        ];
    }
}
