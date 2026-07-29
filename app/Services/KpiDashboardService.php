<?php

namespace App\Services;

use App\Models\ConsumptionEntry;
use App\Models\EmissionCategory;
use App\Models\EmissionFactor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class KpiDashboardService
{
    public function build(?string $from = null, ?string $to = null, ?string $perspective = null): array
    {
        $toDate = $to ? Carbon::parse($to)->endOfDay() : Carbon::today()->endOfDay();
        $fromDate = $from ? Carbon::parse($from)->startOfDay() : $toDate->copy()->subDays(29)->startOfDay();
        if ($fromDate->gt($toDate)) {
            [$fromDate, $toDate] = [$toDate->copy()->startOfDay(), $fromDate->copy()->endOfDay()];
        }

        $entries = ConsumptionEntry::with(['emissionFactor.category', 'user'])
            ->whereBetween('entry_date', [$fromDate, $toDate])->get();
        $previousEntries = ConsumptionEntry::whereBetween('entry_date', [
            $fromDate->copy()->subDays($fromDate->diffInDays($toDate) + 1)->startOfDay(),
            $fromDate->copy()->subDay()->endOfDay(),
        ])->get();

        $totalEmission = (float) $entries->sum('emissions');
        $previousEmission = (float) $previousEntries->sum('emissions');
        $activeUsers = $entries->pluck('user_id')->unique()->count();
        $days = max(1, $fromDate->diffInDays($toDate) + 1);
        $targetEmission = max(1, (float) (User::avg('dailyCarbonLimit') ?: 100) * $days);
        $categories = EmissionCategory::with('factors')->get();

        $details = $this->details($entries, $activeUsers, $totalEmission, $targetEmission, $days);
        if ($perspective && $perspective !== 'all') {
            $details = array_values(array_filter($details, fn (array $item) => $item['perspective'] === $perspective));
        }

        return [
            'filters' => ['from' => $fromDate->toDateString(), 'to' => $toDate->toDateString(), 'perspective' => $perspective ?: 'all'],
            'summary' => [
                'total_emission' => round($totalEmission, 2),
                'total_entries' => $entries->count(),
                'active_users' => $activeUsers,
                'target_emission' => round($targetEmission, 2),
                'achievement' => round(min(100, ($totalEmission / $targetEmission) * 100), 1),
                'delta' => round($previousEmission > 0 ? (($totalEmission - $previousEmission) / $previousEmission) * 100 : 0, 1),
            ],
            'perspectives' => $this->perspectiveSummary($details),
            'details' => $details,
            'charts' => [
                'line' => $this->lineChart($entries, $fromDate, $toDate),
                'bar' => $this->categoryChart($entries),
                'donut' => $this->perspectiveChart($details),
                'gauge' => ['value' => round(min(100, ($totalEmission / $targetEmission) * 100), 1)],
            ],
            'meta' => ['categories' => $categories->count(), 'factors' => EmissionFactor::count(), 'generated_at' => now()->toIso8601String()],
        ];
    }

    private function details(Collection $entries, int $activeUsers, float $emission, float $target, int $days): array
    {
        $growth = User::whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->count();
        return [
            ['perspective' => 'financial', 'label' => 'Efisiensi jejak karbon', 'value' => round(max(0, 100 - ($emission / $target * 100)), 1), 'target' => 20, 'unit' => '% penghematan', 'status' => $emission <= $target ? 'On track' : 'Perlu perhatian'],
            ['perspective' => 'customer', 'label' => 'Pengguna aktif', 'value' => $activeUsers, 'target' => max(1, User::count()), 'unit' => 'pengguna', 'status' => $activeUsers > 0 ? 'On track' : 'Belum ada data'],
            ['perspective' => 'internal', 'label' => 'Total pencatatan emisi', 'value' => $entries->count(), 'target' => max(1, $days * 3), 'unit' => 'pencatatan', 'status' => $entries->count() > 0 ? 'On track' : 'Belum ada data'],
            ['perspective' => 'internal', 'label' => 'Kategori emisi terukur', 'value' => $entries->pluck('emissionFactor.category_id')->filter()->unique()->count(), 'target' => EmissionCategory::count(), 'unit' => 'kategori', 'status' => 'On track'],
            ['perspective' => 'learning', 'label' => 'Pertumbuhan pengguna', 'value' => $growth, 'target' => max(1, User::count()), 'unit' => 'pengguna baru', 'status' => $growth > 0 ? 'On track' : 'Perlu perhatian'],
            ['perspective' => 'learning', 'label' => 'Faktor emisi tersedia', 'value' => EmissionFactor::count(), 'target' => max(1, EmissionFactor::count()), 'unit' => 'faktor', 'status' => 'On track'],
        ];
    }

    private function perspectiveSummary(array $details): array
    {
        $names = ['financial' => 'Financial', 'customer' => 'Customer / Stakeholder', 'internal' => 'Internal Process', 'learning' => 'Learning & Growth'];
        $result = [];
        foreach ($names as $key => $name) {
            $items = array_values(array_filter($details, fn (array $item) => $item['perspective'] === $key));
            $score = $items ? round(array_sum(array_map(fn (array $item) => min(100, ($item['value'] / max(1, $item['target'])) * 100), $items)) / count($items), 1) : 0;
            $result[] = ['key' => $key, 'name' => $name, 'score' => $score, 'count' => count($items)];
        }
        return $result;
    }

    private function lineChart(Collection $entries, Carbon $from, Carbon $to): array
    {
        $labels = $values = [];
        for ($date = $from->copy(); $date->lte($to); $date->addDay()) {
            $labels[] = $date->format('d M');
            $values[] = round((float) $entries->filter(fn ($entry) => $entry->entry_date->isSameDay($date))->sum('emissions'), 2);
        }
        return ['labels' => $labels, 'values' => $values];
    }

    private function categoryChart(Collection $entries): array
    {
        $grouped = $entries->groupBy(fn ($entry) => optional(optional($entry->emissionFactor)->category)->category_name ?: 'Lainnya');
        return ['labels' => $grouped->keys()->values(), 'values' => $grouped->map(fn ($items) => round((float) $items->sum('emissions'), 2))->values()];
    }

    private function perspectiveChart(array $details): array
    {
        $grouped = collect($details)->groupBy('perspective');
        return ['labels' => $grouped->keys()->map(fn ($key) => ucfirst($key))->values(), 'values' => $grouped->map(fn ($items) => round((float) collect($items)->sum('value'), 2))->values()];
    }
}
