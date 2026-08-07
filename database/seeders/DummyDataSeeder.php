<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Tugas;
use App\Models\ProjectDivisionAllocation;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA PROYEK (Dari Rekap Project Manager) [cite: 634]
        // ==========================================
        $projects = [
            ['nama_project' => 'CV BERDIKARI', 'progress' => 0.00, 'budget' => 150000000],
            ['nama_project' => 'CV SUNFAN JAYA PERSADA', 'progress' => 0.00, 'budget' => 50000000],
            ['nama_project' => 'CV TIGA SERANGKAI BINUANG', 'progress' => 0.00, 'budget' => 80000000],
            ['nama_project' => 'PT BERKAT BERSUJUD', 'progress' => 33.33, 'budget' => 120000000],
            ['nama_project' => 'PT BANDANGAN TIRTA AGUNG', 'progress' => 75.00, 'budget' => 90000000],
            ['nama_project' => 'PT PLANTINDO AGRO SUBUR', 'progress' => 75.00, 'budget' => 200000000],
            ['nama_project' => 'PT DORISFA GUNUNG MULIA', 'progress' => 60.00, 'budget' => 150000000],
            ['nama_project' => 'DINAS PERTANIAN KAB KAPUAS (RPU)', 'progress' => 100.00, 'budget' => 50000000]
        ];

        foreach ($projects as $p) {
            Project::create([
                'nama_project' => $p['nama_project'],
                'total_budget' => $p['budget'],
                'progress_keseluruhan' => $p['progress']
            ]);
        }

        // ==========================================
        // 2. DATA KARYAWAN & DIVISI [cite: 635]
        // ==========================================
        // (Asumsi ID Divisi berurutan dari 1-8 sesuai DivisionSeeder)
        $employees = [
            ['nama_karyawan' => 'TIRA', 'division_id' => 1],     // 1: UKL UPL [cite: 635]
            ['nama_karyawan' => 'NAYA', 'division_id' => 2],     // 2: AMDAL [cite: 635]
            ['nama_karyawan' => 'BELA', 'division_id' => 3],     // 3: PERTEK BMAL [cite: 635]
            ['nama_karyawan' => 'RAUDAH', 'division_id' => 4],   // 4: PERTEK EMISI [cite: 635]
            ['nama_karyawan' => 'SYIFA', 'division_id' => 5],    // 5: RINTEK LB3 [cite: 635]
            ['nama_karyawan' => 'YUNICA', 'division_id' => 6],   // 6: RKAB [cite: 635]
            ['nama_karyawan' => 'YASMIN', 'division_id' => 7],   // 7: PKKPRL [cite: 635]
            ['nama_karyawan' => 'MAULIDA', 'division_id' => 8],  // 8: PEMANTAUAN [cite: 635]
            ['nama_karyawan' => 'AUREL', 'division_id' => 1],    // Asumsi di UKL UPL/AMDAL [cite: 635]
            ['nama_karyawan' => 'ASRIN', 'division_id' => 1]     // Asumsi di UKL UPL [cite: 635]
        ];

        foreach ($employees as $e) {
            Employee::create($e);
        }

        // ==========================================
        // 3. DATA ALOKASI BUDGET DEFAULT 
        // ==========================================
        // Simulasi jika klien membayar setoran untuk CV BERDIKARI
        $projectBerdikari = Project::where('nama_project', 'CV BERDIKARI')->first();
        ProjectDivisionAllocation::insert([
            ['project_id' => $projectBerdikari->id, 'division_id' => 1, 'persentase' => 40.00], // UKL UPL
            ['project_id' => $projectBerdikari->id, 'division_id' => 2, 'persentase' => 30.00], // AMDAL
            ['project_id' => $projectBerdikari->id, 'division_id' => 3, 'persentase' => 30.00], // PERTEK BMAL
        ]);

        // ==========================================
        // 4. DATA TASK / DAILY TRACKER [cite: 720, 1156]
        // ==========================================
        
        // Task milik TIRA [cite: 720]
        $sunfan = Project::where('nama_project', 'CV SUNFAN JAYA PERSADA')->first();
        $tira = Employee::where('nama_karyawan', 'TIRA')->first();
        Task::create([
            'project_id' => $sunfan->id,
            'division_id' => 1,
            'employee_id' => $tira->id,
            'tanggal' => Carbon::create(2024, 5, 12),
            'nama_task' => 'UKL UPL 01',
            'aktivitas' => 'Perbaikan administrasi / Kendala: Pertek Air Limbah',
            'prioritas' => 'Low',
            'status' => 'In Progress',
            'progress_persen' => 23.00
        ]);

        $berkat = Project::where('nama_project', 'PT BERKAT BERSUJUD')->first();
        Task::create([
            'project_id' => $berkat->id,
            'division_id' => 1,
            'employee_id' => $tira->id,
            'tanggal' => Carbon::create(2024, 6, 24),
            'nama_task' => 'AMDAL BARU 04',
            'aktivitas' => 'Drafting SK',
            'prioritas' => 'Medium',
            'status' => 'Pending',
            'progress_persen' => 0.00
        ]);

        // Task milik AUREL [cite: 1156]
        $tigaSerangkai = Project::where('nama_project', 'CV TIGA SERANGKAI BINUANG')->first();
        $aurel = Employee::where('nama_karyawan', 'AUREL')->first();
        Task::create([
            'project_id' => $tigaSerangkai->id,
            'division_id' => 1,
            'employee_id' => $aurel->id,
            'tanggal' => Carbon::create(2025, 12, 22),
            'nama_task' => 'ADDENDUM TIPE A 01',
            'aktivitas' => 'Draft 70% (Kendala: data series pemantauan, pkkpr, penapisan amdalnet)',
            'prioritas' => 'Low',
            'status' => 'In Progress',
            'progress_persen' => 23.00
        ]);
    }
}