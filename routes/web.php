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
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\Admin\TaskController;

use App\Http\Controllers\BankAccountController;

use App\Http\Controllers\NotificationController;

use App\Http\Controllers\DailyTrackerController;

use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\EmployeeTaskController;





/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/


Route::get('/', function(){

    return view('welcome');

});





/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function(){



/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/


Route::get('/dashboard',[
    DashboardController::class,
    'index'
])
->name('dashboard');






/*
|--------------------------------------------------------------------------
| NOTIFICATION
|--------------------------------------------------------------------------
*/


Route::get('/notification',[
    NotificationController::class,
    'index'
])
->name('notification.index');



Route::get('/notification/read/{id}',[
    NotificationController::class,
    'read'
])
->name('notification.read');







/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/


Route::middleware('role:karyawan')->group(function(){



    Route::get('/daily-tracker',[
        DailyTrackerController::class,
        'index'
    ])
    ->name('daily-tracker.index');



    Route::get('/daily-tracker/{task}',[
        DailyTrackerController::class,
        'show'
    ])
    ->name('daily-tracker.show');



    Route::post('/daily-tracker',[
        DailyTrackerController::class,
        'store'
    ])
    ->name('daily-tracker.store');




    Route::get('/my-project',[
        EmployeeProjectController::class,
        'index'
    ])
    ->name('employee.project.index');




    Route::get('/my-task/{task}',[
        EmployeeTaskController::class,
        'show'
    ])
    ->name('employee.task.show');





    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    Route::get('/expense/create',[
        ExpenseRequestController::class,
        'create'
    ])
    ->name('expense.create');



    Route::post('/expense',[
        ExpenseRequestController::class,
        'store'
    ])
    ->name('expense.store');



    Route::get('/expense/my-history',[
        ExpenseRequestController::class,
        'history'
    ])
    ->name('expense.myhistory');



    Route::get('/expense/{id}/detail',[
        ExpenseRequestController::class,
        'detail'
    ])
    ->name('expense.detail');


});









/*
|--------------------------------------------------------------------------
| FINANCE APPROVAL
|--------------------------------------------------------------------------
*/


Route::middleware('role:bendahara,keuangan')->group(function(){



    Route::get('/expense/approval',[
        ExpenseApprovalController::class,
        'index'
    ])
    ->name('expense.approval');



    /*
    | DETAIL APPROVAL
    | Audit VIEW masuk di sini
    */


    Route::get('/expense/approval/{id}/detail',[
        ExpenseApprovalController::class,
        'detail'
    ])
    ->name('expense.approval.detail');



    Route::post('/expense/{id}/approve',[
        ExpenseApprovalController::class,
        'approve'
    ])
    ->name('expense.approve');



    Route::post('/expense/{id}/reject',[
        ExpenseApprovalController::class,
        'reject'
    ])
    ->name('expense.reject');



});









/*
|--------------------------------------------------------------------------
| FINANCE MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::middleware('role:keuangan')->group(function(){


    Route::get('/finance/deposit',[
        FinanceDepositController::class,
        'index'
    ])
    ->name('finance.deposit');



    Route::get('/finance/deposit/create',[
        FinanceDepositController::class,
        'create'
    ])
    ->name('finance.deposit.create');



    Route::post('/finance/deposit',[
        FinanceDepositController::class,
        'store'
    ])
    ->name('finance.deposit.store');



    Route::get('/finance/distribution',[
        DepositDistributionController::class,
        'index'
    ])
    ->name('finance.distribution');



    Route::resource(
        'finance/bank',
        BankAccountController::class
    )
    ->names('finance.bank');


});








/*
|--------------------------------------------------------------------------
| FINANCE BALANCE
|--------------------------------------------------------------------------
*/


Route::middleware('role:owner,keuangan')->group(function(){



    Route::get('/finance/balance',[
        DivisionBalanceController::class,
        'index'
    ])
    ->name('finance.balance');


});









/*
|--------------------------------------------------------------------------
| FINANCE REPORT
|--------------------------------------------------------------------------
*/


Route::middleware('role:bendahara,keuangan,owner')->group(function(){



    Route::get('/finance/report',[
        FinanceReportController::class,
        'index'
    ])
    ->name('finance.report');



    Route::get('/finance/report/export',[
        FinanceReportController::class,
        'exportExcel'
    ])
    ->name('finance.report.export');



    Route::get('/expense/approval/history',[
        ExpenseApprovalController::class,
        'history'
    ])
    ->name('expense.approval.history');


});









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









/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:admin'
])

->prefix('admin')

->name('admin.')

->group(function(){



    Route::get('/dashboard',[
        AdminDashboardController::class,
        'index'
    ])
    ->name('dashboard');




    Route::resource(
        'users',
        UserController::class
    );



    Route::resource(
        'projects',
        AdminProjectController::class
    );



    Route::resource(
        'divisions',
        DivisionController::class
    );



    Route::resource(
        'tasks',
        TaskController::class
    );




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





});



require __DIR__.'/auth.php';