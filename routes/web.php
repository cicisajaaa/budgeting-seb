<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\FinanceDepositController;
use App\Http\Controllers\DepositDistributionController;
use App\Http\Controllers\DivisionBalanceController;
use App\Http\Controllers\FinanceReportController;

use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\ExpenseApprovalController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController;

use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\BankAccountController;
/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/


Route::get('/', function () {

    return view('welcome');

});





/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function(){



    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get('/dashboard',[
        DashboardController::class,
        'index'
    ])
    ->name('dashboard');






    /*
    |--------------------------------------------------------------------------
    | BENDAHARA MODULE
    |--------------------------------------------------------------------------
    */


    // Input pembayaran client

    Route::get('/finance/deposit',[
        FinanceDepositController::class,
        'index'
    ])
    ->middleware('role:bendahara')
    ->name('finance.deposit');



    Route::post('/finance/deposit',[
        FinanceDepositController::class,
        'store'
    ])
    ->middleware('role:bendahara')
    ->name('finance.deposit.store');





    // Distribusi dana

    Route::get('/finance/distribution',[
        DepositDistributionController::class,
        'index'
    ])
    ->middleware('role:bendahara,owner')
    ->name('finance.distribution');





    // Saldo divisi

    Route::get('/finance/balance',[
        DivisionBalanceController::class,
        'index'
    ])
    ->middleware('role:bendahara,owner')
    ->name('finance.balance');



//Bank Accounts
Route::resource(
    'finance/bank',
    BankAccountController::class
)
->names('finance.bank');


    /*
    |--------------------------------------------------------------------------
    | REPORT
    |--------------------------------------------------------------------------
    */


    Route::get('/finance/report',[
        FinanceReportController::class,
        'index'
    ])
    ->middleware('role:bendahara,owner')
    ->name('finance.report');



    Route::get('/finance/report/export',[
        FinanceReportController::class,
        'exportExcel'
    ])
    ->middleware('role:bendahara,owner')
    ->name('finance.report.export');








    /*
    |--------------------------------------------------------------------------
    | KARYAWAN EXPENSE REQUEST
    |--------------------------------------------------------------------------
    */


    Route::get('/expense/create',[
        ExpenseRequestController::class,
        'create'
    ])
    ->middleware('role:karyawan')
    ->name('expense.create');



    Route::post('/expense',[
        ExpenseRequestController::class,
        'store'
    ])
    ->middleware('role:karyawan')
    ->name('expense.store');



    Route::get('/expense/history',[
        ExpenseRequestController::class,
        'history'
    ])
    ->middleware('role:karyawan')
    ->name('expense.history');








    /*
    |--------------------------------------------------------------------------
    | BENDAHARA APPROVAL
    |--------------------------------------------------------------------------
    */


    Route::get('/expense/approval',[
        ExpenseApprovalController::class,
        'index'
    ])
    ->middleware('role:bendahara')
    ->name('expense.approval');



    Route::post('/expense/{id}/approve',[
        ExpenseApprovalController::class,
        'approve'
    ])
    ->middleware('role:bendahara')
    ->name('expense.approve');



    Route::post('/expense/{id}/reject',[
        ExpenseApprovalController::class,
        'reject'
    ])
    ->middleware('role:bendahara')
    ->name('expense.reject');







    /*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    */


    Route::get('/notification/read/{id}',function($id){


        $notification = auth()
            ->user()
            ->notifications()
            ->find($id);



        if($notification)
        {

            $notification->markAsRead();

        }



        return redirect()
            ->route('expense.approval');



    })
    ->name('notification.read');







    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */


    Route::get('/profile',[
        ProfileController::class,
        'edit'
    ])
    ->name('profile.edit');



    Route::patch('/profile',[
        ProfileController::class,
        'update'
    ])
    ->name('profile.update');



    Route::delete('/profile',[
        ProfileController::class,
        'destroy'
    ])
    ->name('profile.destroy');



});

   /*
|--------------------------------------------------------------------------
| ADMIN MODULE
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:admin'
])
->prefix('admin')
->name('admin.')
->group(function(){



    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get('/dashboard',[
        AdminDashboardController::class,
        'index'
    ])
    ->name('dashboard');





    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */


    Route::resource(
        'users',
        UserController::class
    );





    /*
    |--------------------------------------------------------------------------
    | Project Management
    |--------------------------------------------------------------------------
    */


    Route::resource(
        'projects',
        ProjectController::class
    );



    /*
    |--------------------------------------------------------------------------
    | Division Management
    |--------------------------------------------------------------------------
    */


    Route::resource(
        'divisions',
        DivisionController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Allocation Budget
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/projects/{project}/allocation',
        [
            AllocationController::class,
            'index'
        ]
    )
    ->name('allocation.index');



    Route::post(
        '/projects/{project}/allocation',
        [
            AllocationController::class,
            'store'
        ]
    )
    ->name('allocation.store');



    Route::delete(
        '/allocation/{allocation}',
        [
            AllocationController::class,
            'destroy'
        ]
    )
    ->name('allocation.destroy');



});
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';