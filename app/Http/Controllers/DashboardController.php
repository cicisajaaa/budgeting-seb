<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();


        switch($user->role)
        {

            case 'owner':

                return redirect()
                    ->route('owner.dashboard');


            case 'admin':

                return redirect()
                    ->route('admin.dashboard');


            case 'keuangan':

                return redirect()
                    ->route('finance.dashboard');


            case 'karyawan':

                return redirect()
                    ->route('employee.dashboard');

            default:

                abort(403);

        }

    }

}