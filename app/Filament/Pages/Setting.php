<?php

namespace App\Filament\Pages;

use App\Models\Setting as Model;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Setting extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $title = 'Pengaturan';

    protected static string $view = 'filament.pages.setting';

    public function mount(): void
    {
        $this->form->fill(
            [
                'visi' => '',
                'misi' => '',
                'about' => '',

                ...Model::query()
                    ->where('key', 'LIKE', 'visi%')
                    ->orWhere('key', 'LIKE', 'misi%')
                    ->orWhere('key', 'LIKE', 'about%')
                    ->pluck('value', 'key')
                    ->toArray()
            ]
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Visi & Misi')
                    ->schema([
                        Forms\Components\Textarea::make('visi'),
                        Forms\Components\Textarea::make('misi'),
                    ])->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ]),
                Forms\Components\Fieldset::make('Tentang')
                    ->schema([
                        Forms\Components\Textarea::make('about')
                            ->label(''),
                    ])->extraAttributes([
                        'class' => 'bg-white dark:bg-gray-800',
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $input = $this->form->getState();

        foreach ($input as $key => $value) {
            Model::firstOrCreate([
                'key' => $key,
            ])->update([
                'value' => $value,
            ]);
        }

        Notification::make()
            ->title('Pengaturan Umum berhasil disimpan')
            ->success()
            ->send();
    }
}
