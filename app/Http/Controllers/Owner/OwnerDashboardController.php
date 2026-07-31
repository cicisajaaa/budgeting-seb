<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;

class OwnerDashboardController extends Controller
{

    public function index()
    {

        $totalProject = Project::count();


        $totalBudget = Project::sum('total_anggaran');


        $totalDeposit = ProjectDeposit::sum('jumlah_setoran');


        $totalExpense = ExpenseRequest::sum('jumlah');


        $sisaDana = $totalDeposit - $totalExpense;


        $progressProject = Project::avg('progres_keseluruhan') ?? 0;


        $pendingApproval = ExpenseRequest::where(
            'status',
            'pending'
        )->count();



        return view(
            'dashboard.owner',
            compact(
                'totalProject',
                'totalBudget',
                'totalDeposit',
                'totalExpense',
                'sisaDana',
                'progressProject',
                'pendingApproval'
            )
        );

    }

}