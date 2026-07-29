<?php

namespace App\Http\Controllers;

use App\Services\KpiDashboardService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KpiReportExportController extends Controller
{
    public function __construct(private KpiDashboardService $kpiDashboard) {}

    public function refresh(Request $request)
    {
        return response()->json($this->kpiDashboard->build($request->query('from'), $request->query('to'), $request->query('perspective')));
    }

    public function report(Request $request)
    {
        $data = $this->kpiDashboard->build($request->query('from'), $request->query('to'), $request->query('perspective'));
        return view('pages.admin.reports.report', compact('data'));
    }

    public function csv(Request $request): StreamedResponse
    {
        $data = $this->kpiDashboard->build($request->query('from'), $request->query('to'), $request->query('perspective'));
        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Laporan KPI Balanced Scorecard']);
            fputcsv($handle, ['Periode', $data['filters']['from'] . ' s/d ' . $data['filters']['to']]);
            fputcsv($handle, []);
            fputcsv($handle, ['Perspektif', 'Indikator', 'Nilai', 'Target', 'Satuan', 'Status']);
            foreach ($data['details'] as $item) {
                fputcsv($handle, [$item['perspective'], $item['label'], $item['value'], $item['target'], $item['unit'], $item['status']]);
            }
            fclose($handle);
        }, 'laporan-kpi-' . now()->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
