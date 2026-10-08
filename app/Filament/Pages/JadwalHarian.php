<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JadwalHarian extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Operasional';

    protected static ?string $navigationLabel = 'Jadwal Harian';

    protected static ?string $title = 'Jadwal Harian';

    protected string $view = 'filament.pages.jadwal-harian';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()->with(['unit', 'user'])->orderBy('start_at')
            )
            ->columns([
                TextColumn::make('start_at')->label('Mulai')->dateTime('d M H:i')->sortable(),
                TextColumn::make('end_at')->label('Selesai')->dateTime('H:i'),
                TextColumn::make('unit.name')->label('Unit')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Pemesan')->searchable(),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('date')->label('Tanggal')->default(now()->toDateString()),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['date'] ?? null,
                        fn (Builder $q, $date): Builder => $q->whereDate('start_at', $date),
                    ))->default(['date' => now()->toDateString()]),
                SelectFilter::make('unit_id')->label('Unit')->relationship('unit', 'name')->preload(),
                SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'paid' => 'Paid',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                    'rejected' => 'Rejected',
                ]),
            ]);
    }
}
