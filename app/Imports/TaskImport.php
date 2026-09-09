<?php

namespace App\Imports;

use App\Models\Tugas;
use App\Models\Proyek;
use App\Models\Perusahaan;
use App\Models\Divisi;
use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class TaskImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public $success = 0;
    public $failed = 0;
    public $errors = [];

    public function model(array $row)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. DATA DASAR
        |--------------------------------------------------------------------------
        */

        $namaPerusahaan = trim($row['nama_perusahaan'] ?? '');
        $namaProject    = trim($row['nama_proyek'] ?? '');
        $namaDivisi     = trim($row['nama_divisi'] ?? '');
        $namaPIC        = trim($row['nama_pic'] ?? '');
        $namaTugas      = trim($row['nama_tugas'] ?? '');

        if (
            $namaPerusahaan === '' ||
            $namaProject === '' ||
            $namaDivisi === '' ||
            $namaTugas === ''
        ) {
            $this->failed++;

            $this->errors[] =
                "Data wajib kosong untuk task: "
                . ($namaTugas !== '' ? $namaTugas : '(nama task kosong)');

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. FUNGSI NORMALISASI TEKS
        |--------------------------------------------------------------------------
        |
        | Menyamakan huruf besar/kecil dan menghilangkan spasi berlebih.
        |
        */

        $normalisasi = function ($text) {
            return strtolower(
                trim(
                    preg_replace('/\s+/', ' ', $text)
                )
            );
        };

        /*
        |--------------------------------------------------------------------------
        | 3. CARI PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $namaPerusahaanNormal = $normalisasi($namaPerusahaan);

        $perusahaan = Perusahaan::get()
            ->first(function ($item) use (
                $namaPerusahaanNormal,
                $normalisasi
            ) {
                return $normalisasi(
                    $item->nama_perusahaan
                ) === $namaPerusahaanNormal;
            });

        if (!$perusahaan) {
            $this->failed++;

            $this->errors[] =
                "Perusahaan tidak ditemukan: "
                . $namaPerusahaan
                . " | Task: "
                . $namaTugas;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 4. CARI PROJECT
        |--------------------------------------------------------------------------
        |
        | Spasi berlebih dianggap sama.
        |
        | Contoh:
        | RINTEK LB3 05
        | RINTEK LB3  05
        |
        | dianggap sebagai project yang sama.
        |
        */

        $namaProjectNormal = $normalisasi($namaProject);

        $project = Proyek::where(
            'perusahaan_id',
            $perusahaan->id
        )
        ->get()
        ->first(function ($item) use (
            $namaProjectNormal,
            $normalisasi
        ) {
            return $normalisasi(
                $item->nama_proyek
            ) === $namaProjectNormal;
        });

        if (!$project) {
            $this->failed++;

            $this->errors[] =
                "Project tidak ditemukan: "
                . $namaProject
                . " | Perusahaan: "
                . $namaPerusahaan
                . " | Task: "
                . $namaTugas;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 5. MAPPING DIVISI
        |--------------------------------------------------------------------------
        |
        | Database saat ini menggunakan:
        | PERTEK EMISI
        |
        | Jadi nama tersebut dicocokkan langsung.
        |
        */

        $namaDivisiNormal = $normalisasi($namaDivisi);

        $divisi = Divisi::get()
            ->first(function ($item) use (
                $namaDivisiNormal,
                $normalisasi
            ) {
                return $normalisasi(
                    $item->nama_divisi
                ) === $namaDivisiNormal;
            });

        if (!$divisi) {
            $this->failed++;

            $this->errors[] =
                "Divisi tidak ditemukan: "
                . $namaDivisi
                . " | Task: "
                . $namaTugas;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 6. CARI KARYAWAN / PIC
        |--------------------------------------------------------------------------
        |
        | Jika PIC berupa TIM, karyawan_id = NULL.
        |
        */

        $karyawan = null;

        if (
            $namaPIC !== '' &&
            !str_starts_with(
                strtoupper($namaPIC),
                'TIM '
            )
        ) {
            $namaPICNormal = $normalisasi($namaPIC);

            $karyawan = Karyawan::get()
                ->first(function ($item) use (
                    $namaPICNormal,
                    $normalisasi
                ) {
                    return $normalisasi(
                        $item->nama_karyawan
                    ) === $namaPICNormal;
                });
        }

        /*
        |--------------------------------------------------------------------------
        | 7. PRIORITAS
        |--------------------------------------------------------------------------
        */

        $prioritas = trim(
            $row['prioritas'] ?? ''
        );

        if (
            $prioritas === '' ||
            strtolower($prioritas) === 'none'
        ) {
            $prioritas = 'Low';
        }

        if (!in_array(
            $prioritas,
            ['Low', 'Medium', 'High']
        )) {
            $prioritas = 'Low';
        }

        /*
        |--------------------------------------------------------------------------
        | 8. STATUS DARI EXCEL
        |--------------------------------------------------------------------------
        */

        $statusExcel = strtolower(
            trim($row['status'] ?? '')
        );

        $status = match ($statusExcel) {

            'complete' =>
                'selesai',

            'in progress' =>
                'sedang_dikerjakan',

            'pending' =>
                'belum_dikerjakan',

            default =>
                'belum_dikerjakan',
        };

        /*
        |--------------------------------------------------------------------------
        | 9. PROGRESS
        |--------------------------------------------------------------------------
        |
        | Excel tidak memiliki kolom progress.
        |
        | Complete    = 100%
        | In Progress = 0%
        | Pending     = 0%
        |
        */

        $progress = 0;

        if ($status === 'selesai') {
            $progress = 100;
        }

        /*
        |--------------------------------------------------------------------------
        | 10. TANGGAL
        |--------------------------------------------------------------------------
        |
        | Start Date Excel kosong.
        | Database mewajibkan tanggal.
        |
        | Maka digunakan tanggal saat import.
        |
        */

        $tanggal = now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | 11. DEADLINE
        |--------------------------------------------------------------------------
        */

        $deadline = trim(
            $row['deadline'] ?? ''
        );

        if ($deadline === '') {
            $deadline = null;
        }

        /*
        |--------------------------------------------------------------------------
        | 12. CEK DUPLIKAT
        |--------------------------------------------------------------------------
        |
        | Spasi berlebih pada nama task dianggap sama.
        |
        */

        $namaTugasNormal = $normalisasi($namaTugas);

        $cek = Tugas::where(
            'proyek_id',
            $project->id
        )
        ->get()
        ->contains(function ($item) use (
            $namaTugasNormal,
            $normalisasi
        ) {
            return $normalisasi(
                $item->nama_tugas
            ) === $namaTugasNormal;
        });

        if ($cek) {
            $this->failed++;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | 13. SIMPAN TASK
        |--------------------------------------------------------------------------
        |
        | withoutEvents digunakan agar status dari Excel
        | tidak ditimpa oleh booted() pada model Tugas.
        |
        */

        Tugas::withoutEvents(function () use (
            $project,
            $divisi,
            $karyawan,
            $namaTugas,
            $tanggal,
            $row,
            $prioritas,
            $deadline,
            $status,
            $progress
        ) {
            Tugas::create([
                'proyek_id' =>
                    $project->id,

                'divisi_id' =>
                    $divisi->id,

                'karyawan_id' =>
                    $karyawan?->id,

                'tanggal' =>
                    $tanggal,

                'nama_tugas' =>
                    $namaTugas,

                'aktivitas' =>
                    $row['aktivitas'] ?? null,

                'prioritas' =>
                    $prioritas,

                'deadline' =>
                    $deadline,

                'status' =>
                    $status,

                'progres_persen' =>
                    $progress,

                'catatan' =>
                    $row['catatan'] ?? null,
            ]);
        });

        $this->success++;

        return null;
    }
}