<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan KPI Balanced Scorecard</title>
    <style>body{font-family:Arial,sans-serif;color:#172033;margin:32px}h1{color:#065f46}table{width:100%;border-collapse:collapse;margin-top:24px}th,td{border:1px solid #dbe3ec;padding:9px;text-align:left;font-size:12px}th{background:#ecfdf5}@media print{.no-print{display:none}}</style>
</head>
<body>
    <button class="no-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>Laporan KPI Balanced Scorecard</h1>
    <p>Periode: {{ $data['filters']['from'] }} s/d {{ $data['filters']['to'] }}</p>
    <p>Total emisi: <strong>{{ number_format($data['summary']['total_emission'], 2) }} kgCO₂e</strong> · Pencatatan: <strong>{{ $data['summary']['total_entries'] }}</strong></p>
    <table><thead><tr><th>Perspektif</th><th>Indikator</th><th>Nilai</th><th>Target</th><th>Satuan</th><th>Status</th></tr></thead><tbody>
    @foreach($data['details'] as $item)<tr><td>{{ ucfirst($item['perspective']) }}</td><td>{{ $item['label'] }}</td><td>{{ $item['value'] }}</td><td>{{ $item['target'] }}</td><td>{{ $item['unit'] }}</td><td>{{ $item['status'] }}</td></tr>@endforeach
    </tbody></table>
</body>
</html>
