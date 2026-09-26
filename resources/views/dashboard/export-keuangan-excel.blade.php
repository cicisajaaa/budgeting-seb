@php
    $totalMasuk = $deposits->sum('jumlah_setoran');
    $totalKeluar = $expenses->sum('jumlah');
    $saldo = $totalMasuk - $totalKeluar;
    $periodeBulan = $filterBulan ? \Carbon\Carbon::create()->month($filterBulan)->translatedFormat('F') : 'Semua Bulan';
    $periodeTahun = $filterTahun ? $filterTahun : 'Semua Tahun';
@endphp

<!-- GRID SUPER RAPI - WARNA SENADA PDF -->
<table border="1" style="border-collapse: collapse; font-family: Arial, sans-serif;">
    
    <!-- HEADER -->
    <tr>
        <th colspan="4" style="background-color: #0f172a; color: #ffffff; text-align: center; font-size: 16px; font-weight: bold; height: 30px;">
            SAHABAT EKSPLORASI BANUA
        </th>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #f8fafc; color: #64748b; text-align: center; font-size: 12px;">
            Sistem Manajemen Keuangan & Proyek
        </th>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #f8fafc; color: #b48629; text-align: center; font-size: 14px; font-weight: bold;">
            LAPORAN FINANSIAL
        </th>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #f8fafc; color: #475569; text-align: center; font-size: 12px;">
            Periode: {{ $periodeBulan }} {{ $periodeTahun }}
        </th>
    </tr>

    <!-- KOSONG (SPASI) -->
    <tr>
        <td colspan="4" style="border: none;"></td>
    </tr>

    <!-- SUMMARY -->
    <tr>
        <th colspan="2" style="background-color: #e2e8f0; color: #0f172a; font-weight: bold; padding: 10px; text-align: left;">
            TOTAL DANA MASUK
        </th>
        <th colspan="2" style="background-color: #e2e8f0; color: #059669; font-weight: bold; padding: 10px; text-align: right; font-size: 14px;">
            Rp {{ number_format($totalMasuk, 0, ',', '.') }}
        </th>
    </tr>
    <tr>
        <th colspan="2" style="background-color: #e2e8f0; color: #0f172a; font-weight: bold; padding: 10px; text-align: left;">
            TOTAL PENGELUARAN
        </th>
        <th colspan="2" style="background-color: #e2e8f0; color: #dc2626; font-weight: bold; padding: 10px; text-align: right; font-size: 14px;">
            Rp {{ number_format($totalKeluar, 0, ',', '.') }}
        </th>
    </tr>
    <tr>
        <th colspan="2" style="background-color: #0f172a; color: #ffffff; font-weight: bold; padding: 10px; text-align: left;">
            SALDO BERSIH
        </th>
        <th colspan="2" style="background-color: #0f172a; color: #ffffff; font-weight: bold; padding: 10px; text-align: right; font-size: 14px;">
            Rp {{ number_format($saldo, 0, ',', '.') }}
        </th>
    </tr>

    <!-- KOSONG (SPASI) -->
    <tr>
        <td colspan="4" style="border: none;"></td>
    </tr>

    <!-- TABEL DANA MASUK -->
    <tr>
        <td colspan="4" style="background-color: #b48629; color: #ffffff; font-weight: bold; font-size: 12px; height: 25px;">
            &nbsp; A. RINCIAN DANA MASUK
        </td>
    </tr>
    <tr>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: center; width: 40px;">No</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: center; width: 120px;">Tanggal</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: left; width: 350px;">Alokasi / Sumber Project</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: right; width: 150px;">Nominal (Rp)</th>
    </tr>
    
    @forelse($deposits as $index => $deposit)
        <tr>
            <td style="text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
            <td style="text-align: center; vertical-align: middle;">
                {{ $deposit->tanggal_setoran ? \Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d/m/Y') : '-' }}
            </td>
            <td style="vertical-align: middle; font-weight: bold;">
                {{ $deposit->proyek?->nama_proyek ?? 'Kas Internal Perusahaan' }}
            </td>
            <td style="text-align: right; color: #059669; font-weight: bold; vertical-align: middle;">
                {{ $deposit->jumlah_setoran }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center; color: #64748b;">Tidak ada transaksi penerimaan dana pada periode ini.</td>
        </tr>
    @endforelse

    <tr>
        <th colspan="3" style="background-color: #e2e8f0; color: #0f172a; text-align: right; font-weight: bold;">TOTAL DANA MASUK:</th>
        <th style="background-color: #e2e8f0; color: #059669; text-align: right; font-weight: bold;">
            {{ $totalMasuk }}
        </th>
    </tr>

    <!-- KOSONG (SPASI) -->
    <tr>
        <td colspan="4" style="border: none;"></td>
    </tr>

    <!-- TABEL PENGELUARAN -->
    <tr>
        <td colspan="4" style="background-color: #b48629; color: #ffffff; font-weight: bold; font-size: 12px; height: 25px;">
            &nbsp; B. RINCIAN PENGELUARAN
        </td>
    </tr>
    <tr>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: center;">No</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: center;">Tanggal</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: left;">Tujuan / Induk Project</th>
        <th style="background-color: #f1f5f9; color: #0f172a; font-weight: bold; text-align: right;">Nominal (Rp)</th>
    </tr>

    @forelse($expenses as $index => $expense)
        <tr>
            <td style="text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
            <td style="text-align: center; vertical-align: middle;">
                {{ $expense->tanggal ? \Carbon\Carbon::parse($expense->tanggal)->format('d/m/Y') : '-' }}
            </td>
            <td style="vertical-align: middle; font-weight: bold;">
                {{ $expense->pengajuanDana?->proyek?->nama_proyek ?? 'Operasional Umum' }}
            </td>
            <td style="text-align: right; color: #dc2626; font-weight: bold; vertical-align: middle;">
                {{ $expense->jumlah }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center; color: #64748b;">Tidak ada pengeluaran dana pada periode ini.</td>
        </tr>
    @endforelse

    <tr>
        <th colspan="3" style="background-color: #e2e8f0; color: #0f172a; text-align: right; font-weight: bold;">TOTAL PENGELUARAN:</th>
        <th style="background-color: #e2e8f0; color: #dc2626; text-align: right; font-weight: bold;">
            {{ $totalKeluar }}
        </th>
    </tr>

</table>