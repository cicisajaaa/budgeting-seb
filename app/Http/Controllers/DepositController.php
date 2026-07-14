<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\DepositDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller {
    public function create(Project $project) { return view('deposit.create', compact('project')); }

    public function previewDistribution(Request $request, Project $project) {
        $request->validate(['jumlah_setoran' => 'required|numeric|min:1', 'tanggal_setoran' => 'required|date']);
        $jumlahSetoran = $request->jumlah_setoran;
        $project->load('allocations.division');
        $defaultDistributions = $project->allocations->map(function ($allocation) use ($jumlahSetoran) {
            return [
                'division_id' => $allocation->division_id,
                'nama_divisi' => $allocation->division->nama_divisi,
                'nominal' => ($allocation->persentase / 100) * $jumlahSetoran
            ];
        });
        return view('deposit.preview', compact('project', 'jumlahSetoran', 'request', 'defaultDistributions'));
    }

    public function storeFinal(Request $request, Project $project) {
        $request->validate(['jumlah_setoran' => 'required|numeric', 'tanggal_setoran' => 'required|date', 'distribusi' => 'required|array']);
        if (array_sum($request->distribusi) != $request->jumlah_setoran) {
            return redirect()->back()->withErrors(['distribusi' => 'Total tidak sesuai dengan setoran awal.']);
        }
        DB::transaction(function () use ($request, $project) {
            $deposit = ProjectDeposit::create(['project_id' => $project->id, 'jumlah_setoran' => $request->jumlah_setoran, 'tanggal_setoran' => $request->tanggal_setoran]);
            foreach ($request->distribusi as $divisionId => $nominal) {
                if ($nominal > 0) DepositDistribution::create(['deposit_id' => $deposit->id, 'division_id' => $divisionId, 'nominal_diterima' => $nominal]);
            }
        });
        return redirect()->route('dashboard')->with('success', 'Setoran berhasil didistribusikan!');
    }
}