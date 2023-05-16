<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\ExpensesController;
use App\Http\Controllers\Dashboard\OrderController as GlobalOrderController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

// routes/web.php

Route::group(['prefix' => "dash", "middleware" => ["web", "auth"]], function () {
    Route::name('dash.')->group(function () {
        Route::get('/', [DashboardController::class, "index"])->name("index");

        // user routes
        Route::resource('users', UserController::class)->except(["show"]);
        // category routes
        Route::resource('categories', CategoryController::class)->except(["show"]);
        // product routes
        Route::resource('products', ProductController::class)->except(["show"]);
        // client routes
        Route::resource('clients', ClientController::class)->except(["show"]);
        Route::resource('clients.orders', OrderController::class)->except(["show", 'destroy', "index"]);
        // Global Order routes
        Route::resource('orders', GlobalOrderController::class);
        Route::get('orders/{order}/products', [GlobalOrderController::class, "products"])->name("orders.products");
        // Trash routes
        Route::get('trash', [DashboardController::class, "trash"])->name("trash.index");
        Route::get('restore/{table}/{id}', [DashboardController::class, "restoreData"])->name("trash.restore");
        Route::get('forceDelete/{table}/{id}', [DashboardController::class, "forceDelete"])->name("trash.forceDelete");
        // Daily Invoice
        Route::get('daily-invoice', [DashboardController::class, "dailyInvoice"])->name("dailyInvoice");
        Route::get('yearly-invoice', [DashboardController::class, "yearlyInvoice"])->name("yearlyInvoice");
        // Expenses routes
        Route::get('expenses', [ExpensesController::class, "index"])->name("expenses.index");
        Route::post('expenses/store', [ExpensesController::class, "store"])->name("expenses.store");
        Route::get('daily-expenses', [ExpensesController::class, "dailyExpenses"])->name("dailyExpenses");
        Route::get('monthly-expenses', [ExpensesController::class, "monthlyExpenses"])->name("monthlyExpenses");

    });
});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'../auth.php';
