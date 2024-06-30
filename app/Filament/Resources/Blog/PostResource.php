<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Filament\Resources\Blog\PostResource\RelationManagers;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Berita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Berita / Artikel')
                    ->description('Buat berita atau artikel')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->disk('public')
                            ->directory('news')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->live(onBlur: true)
                            ->debounce(1000)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->searchable()
                            ->options(fn () => BlogCategory::query()->pluck('title', 'id')),
                        Forms\Components\DatePicker::make('published_date')
                            ->label('Tanggal Publikasi')
                            ->native(false),
                        Forms\Components\RichEditor::make('content')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('news')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('user_id')
                            ->label('Author')
                            ->searchable()
                            ->options(fn () => User::query()->pluck('name', 'id'))
                            ->columnSpanFull()
                            ->required()
                    ])->columns(2)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->grow(),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('published_date'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('category')
                    ->options(fn () => BlogCategory::query()->pluck('title', 'id'))
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
