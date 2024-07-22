<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Blog\PostResource;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\UserResource;
use App\Models\Blog;
use App\Models\Event;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('News', Blog::query()->count())
                ->description('Total Berita')
                ->icon('heroicon-o-newspaper')
                ->url(PostResource::getUrl('index'))
                ->openUrlInNewTab(),
            Stat::make('Event', Event::query()->count())
                ->description('Total Event')
                ->icon('heroicon-o-calendar-days')
                ->url(EventResource::getUrl('index'))
                ->openUrlInNewTab(),
            Stat::make('Pengguna', User::query()->count())
                ->description('Total Pengguna')
                ->icon('heroicon-o-user-group')
                ->url(UserResource::getUrl('index'))
                ->openUrlInNewTab(),
        ];
    }
}
