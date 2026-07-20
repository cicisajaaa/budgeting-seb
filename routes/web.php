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
| AUTH USER
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
| KARYAWAN DAILY TRACKER
|--------------------------------------------------------------------------
*/


Route::get('/daily-tracker',[
    DailyTrackerController::class,
    'index'
])
->middleware('role:karyawan')
->name('daily-tracker.index');




Route::get('/daily-tracker/{task}',[
    DailyTrackerController::class,
    'show'
])
->middleware('role:karyawan')
->name('daily-tracker.show');




Route::post('/daily-tracker',[
    DailyTrackerController::class,
    'store'
])
->middleware('role:karyawan')
->name('daily-tracker.store');








/*
|--------------------------------------------------------------------------
| PROJECT KARYAWAN
|--------------------------------------------------------------------------
*/


Route::get('/my-project',[
    EmployeeProjectController::class,
    'index'
])
->middleware('role:karyawan')
->name('employee.project.index');





/*
|--------------------------------------------------------------------------
| DETAIL TASK KARYAWAN
|--------------------------------------------------------------------------
*/


Route::get('/my-task/{task}',[
    EmployeeTaskController::class,
    'show'
])
->middleware('role:karyawan')
->name('employee.task.show');








/*
|--------------------------------------------------------------------------
| EXPENSE KARYAWAN
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



Route::get('/expense/my-history',[
    ExpenseRequestController::class,
    'history'
])
->middleware('role:karyawan')
->name('expense.myhistory');









/*
|--------------------------------------------------------------------------
| FINANCE
|--------------------------------------------------------------------------
*/


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



Route::get('/finance/distribution',[
    DepositDistributionController::class,
    'index'
])
->middleware('role:bendahara,owner')
->name('finance.distribution');



Route::get('/finance/balance',[
    DivisionBalanceController::class,
    'index'
])
->middleware('role:bendahara,owner')
->name('finance.balance');



Route::resource(
    'finance/bank',
    BankAccountController::class
)
->names('finance.bank');



Route::get('/finance/report/export',[
    FinanceReportController::class,
    'exportExcel'
])
->middleware('role:bendahara,owner')
->name('finance.report.export');



Route::get('/finance/report',[
    FinanceReportController::class,
    'index'
])
->middleware('role:bendahara,owner')
->name('finance.report');









/*
|--------------------------------------------------------------------------
| APPROVAL BENDAHARA
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



Route::get('/expense/approval/history',[
    ExpenseApprovalController::class,
    'history'
])
->middleware('role:bendahara,owner')
->name('expense.approval.history');










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



Route::resource(
    'tasks',
    TaskController::class
);



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





require __DIR__.'/auth.php';