<?php

namespace App\Imports;

use App\Models\Proyek;
use App\Models\Perusahaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProjectImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public $success = 0;
    public $failed = 0;

    public function model(array $row)
    {
        // ==============================
        // 1. AMBIL NAMA PERUSAHAAN
        // ==============================
        $namaPerusahaan = trim($row['nama_perusahaan'] ?? '');

        if ($namaPerusahaan === '') {
            $this->failed++;
            return null;
        }

        // ==============================
        // 2. CARI PERUSAHAAN
        // ==============================
        $perusahaan = Perusahaan::whereRaw(
            'LOWER(TRIM(nama_perusahaan)) = ?',
            [strtolower($namaPerusahaan)]
        )->first();

        // ==============================
        // 3. JIKA BELUM ADA,
        //    BUAT PERUSAHAAN OTOMATIS
        // ==============================
        if (!$perusahaan) {
            $perusahaan = Perusahaan::create([
                'nama_perusahaan' => $namaPerusahaan,
                'alamat'          => null,
                'kontak'          => null,
                'email'           => null,
                'status'          => 'aktif',
            ]);
        }

        // ==============================
        // 4. AMBIL NAMA PROJECT
        // ==============================
        $namaProject = trim($row['nama_proyek'] ?? '');

        if ($namaProject === '') {
            $this->failed++;
            return null;
        }

        // ==============================
        // 5. CEK PROJECT DUPLIKAT
        // ==============================
        $cekProject = Proyek::where(
            'perusahaan_id',
            $perusahaan->id
        )
        ->whereRaw(
            'LOWER(TRIM(nama_proyek)) = ?',
            [strtolower($namaProject)]
        )
        ->exists();

        if ($cekProject) {
            $this->failed++;
            return null;
        }

        // ==============================
        // 6. SIMPAN PROJECT
        // ==============================
        $this->success++;

        $tanggalMulai = trim($row['tanggal_mulai'] ?? '');
        $tanggalSelesai = trim($row['tanggal_selesai'] ?? '');

        return new Proyek([
            'perusahaan_id'   => $perusahaan->id,
            'nama_proyek'     => $namaProject,
            'tanggal_mulai'   => $tanggalMulai !== '' ? $tanggalMulai : null,
            'tanggal_selesai' => $tanggalSelesai !== '' ? $tanggalSelesai : null,
            'pemilik_proyek'  => trim($row['pemilik_proyek'] ?? ''),
            'total_anggaran'  => $row['total_anggaran'] ?? 0,
        ]);
    }
}