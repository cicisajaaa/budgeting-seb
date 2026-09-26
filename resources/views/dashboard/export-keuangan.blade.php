<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan SEB</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 10pt; color: #334155; line-height: 1.5; margin: 0; padding: 0; }
        .text-center { text-align: center; } .text-right { text-align: right; } .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        
        .header-table { width: 100%; border-bottom: 2px solid #0f172a; padding-bottom: 15px; margin-bottom: 20px; }
        .company-name { font-size: 20px; font-weight: bold; color: #0f172a; margin: 0; }
        .company-sub { font-size: 10px; color: #64748b; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 1px; }
        .report-title { font-size: 18px; font-weight: bold; color: #b48629; margin: 0; }
        .report-period { font-size: 11px; color: #475569; margin: 5px 0 0 0; background: #f1f5f9; display: inline-block; padding: 4px 8px; border-radius: 4px; }

        .summary-table { width: 100%; margin-bottom: 30px; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; text-align: center; width: 32%; }
        .summary-box-dark { background-color: #0f172a; color: #ffffff; border: 1px solid #0f172a; padding: 15px; text-align: center; width: 32%; }
        .summary-label { font-size: 10px; text-transform: uppercase; margin-bottom: 5px; display: block; color: #64748b;}
        .summary-value { font-size: 16px; font-weight: bold; }

        .section-title { font-size: 12px; font-weight: bold; color: #0f172a; margin-bottom: 10px; border-left: 3px solid #b48629; padding-left: 8px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #cbd5e1; padding: 10px; vertical-align: middle; }
        .data-table th { background-color: #f1f5f9; color: #0f172a; font-size: 10px; text-transform: uppercase; }
        .data-table td { font-size: 11px; }
        
        .signature-table { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .signature-box { width: 30%; text-align: center; }
        .signature-line { border-top: 1px solid #000; margin-top: 60px; padding-top: 5px; font-weight: bold; font-size: 11px; }
    </style>
</head>
<body>

    @php
        $totalMasuk = $deposits->sum('jumlah_setoran');
        $totalKeluar = $expenses->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;
        $periodeBulan = $filterBulan ? \Carbon\Carbon::create()->month($filterBulan)->translatedFormat('F') : 'Semua Bulan';
        $periodeTahun = $filterTahun ? $filterTahun : 'Semua Tahun';
        
        $path = public_path('images/logo-cv.png');
        $logoBase64 = file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : '';
    @endphp

    <!-- KOP SURAT BERLOGO -->
    <table class="header-table">
        <tr>
            <td width="15%" class="text-left" style="vertical-align: middle;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo SEB" style="max-width: 65px;">
                @endif
            </td>
            <td width="45%" class="text-left" style="vertical-align: middle;">
                <h1 class="company-name">Sahabat Eksplorasi Banua</h1>
                <p class="company-sub">Sistem Manajemen Keuangan & Proyek</p>
            </td>
            <td width="40%" class="text-right" style="vertical-align: top;">
                <h2 class="report-title">Laporan Finansial</h2>
                <div class="report-period">Periode: {{ $periodeBulan }} {{ $periodeTahun }}</div>
            </td>
        </tr>
    </table>

    <table class="summary-table">
        <tr>
            <td class="summary-box">
                <span class="summary-label">Total Dana Masuk</span>
                <span class="summary-value" style="color: #059669;">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
            </td>
            <td width="2%"></td>
            <td class="summary-box">
                <span class="summary-label">Total Pengeluaran</span>
                <span class="summary-value" style="color: #dc2626;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
            </td>
            <td width="2%"></td>
            <td class="summary-box-dark">
                <span class="summary-label" style="color:#94a3b8;">Saldo Bersih</span>
                <span class="summary-value" style="color: #ffffff;">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">A. RINCIAN DANA MASUK</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Tanggal</th>
                <th width="45%">Alokasi / Sumber Project</th>
                <th width="30%" class="text-right">Nominal Masuk (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deposits as $index => $deposit)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $deposit->tanggal_setoran ? \Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d/m/Y') : '-' }}</td>
                    <td class="font-bold">{{ $deposit->proyek?->nama_proyek ?? 'Kas Internal Perusahaan' }}</td>
                    <td class="text-right font-bold" style="color: #059669;">+ {{ number_format($deposit->jumlah_setoran ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center" style="padding: 20px;">Tidak ada transaksi penerimaan dana.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL DANA MASUK:</th>
                <th class="text-right" style="color: #059669;">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">B. RINCIAN PENGELUARAN</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Tanggal</th>
                <th width="45%">Tujuan / Induk Project</th>
                <th width="30%" class="text-right">Nominal Keluar (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $index => $expense)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $expense->tanggal ? \Carbon\Carbon::parse($expense->tanggal)->format('d/m/Y') : '-' }}</td>
                    <td class="font-bold">{{ $expense->pengajuanDana?->proyek?->nama_proyek ?? 'Operasional Umum' }}</td>
                    <td class="text-right font-bold" style="color: #dc2626;">- {{ number_format($expense->jumlah ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center" style="padding: 20px;">Tidak ada pengeluaran dana.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL PENGELUARAN:</th>
                <th class="text-right" style="color: #dc2626;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <table class="signature-table">
        <tr>
            <td width="60%"></td>
            <td class="signature-box">
                <div style="font-size: 11px; margin-bottom: 5px;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div style="font-size: 11px;">Mengetahui,</div>
                <div class="signature-line">Bagian Keuangan</div>
            </td>
        </tr>
    </table>

</body>
</html>