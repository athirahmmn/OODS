<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\SupervisorStockController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\DeliveryStatusController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\AdminOrderStatusController;
use App\Http\Controllers\AdminOrderHistoryController;
use App\Http\Controllers\ManageDeliveriesController;
use App\Http\Controllers\DeliveryTrackingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;

// Home route redirects to login
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisorIndex'])->name('supervisor.dashboard');

    // Supervisor routes
    Route::prefix('supervisor')->group(function () {

        Route::get('/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
        Route::post('/remove-alert', [SupervisorController::class, 'removeAlert'])->name('remove.alert');

        // View Stock
        Route::get('/requestPage', [SupervisorStockController::class, 'index'])->name('supervisor.requestPage');
        Route::post('/requestPage/filter', [SupervisorStockController::class, 'filter'])->name('supervisor.stocks.filter');
        Route::post('/updateStocks', [SupervisorStockController::class, 'updateStocks'])->name('supervisor.updateStocks');
        Route::post('/updateStockAfterDelivery/{deliveryID}', [SupervisorStockController::class, 'updateStockAfterOrderDelivery'])->name('supervisor.updateStockAfterDelivery');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart');

        // Checkout
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

        // Order Status
        Route::get('/orderStatus', [OrderStatusController::class, 'index'])->name('orderStatus');
        Route::get('/orderStatusDetails/{orderID}', [OrderStatusController::class, 'orderStatusDetails'])->name('supervisor.orderStatusDetails');
        Route::post('/cancelOrder/{orderID}', [OrderStatusController::class, 'cancelOrder'])->name('supervisor.cancelOrder');
        Route::get('/supervisor/getRejectionReason/{orderId}', [OrderStatusController::class, 'getRejectionReason']);

        Route::get('/orderHistory', [OrderHistoryController::class, 'index'])->name('supervisor.orderHistory');
        Route::get('/orderDetails/{orderID}', [OrderHistoryController::class, 'orderDetails'])->name('supervisor.orderDetails');
        Route::get('/deliveryDetails/{deliveryID}', [OrderHistoryController::class, 'deliveryDetails'])->name('supervisor.deliveryDetails');

        // Delivery Tracking
        Route::get('/deliveryTracking', [DeliveryTrackingController::class, 'index'])->name('supervisor.deliveryTracking');
        Route::post('/markAsReceived/{deliveryID}', [DeliveryTrackingController::class, 'markAsReceived'])->name('supervisor.markAsReceived');
        Route::get('/check-overdue-deliveries', [DeliveryTrackingController::class, 'checkOverdueDeliveries']);


    });

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/checkAlerts', [AdminController::class, 'checkAlerts'])->name('admin.checkAlerts');
        
        // Manage stock
        Route::get('/manageStock', [AdminStockController::class, 'manageStock'])->name('admin.manageStock');
        Route::post('/manageStock/store', [AdminStockController::class, 'store'])->name('admin.stocks.store');
        Route::put('/manageStock/{id}/update', [AdminStockController::class, 'update'])->name('admin.stocks.update');
        Route::delete('/manageStock/{id}/delete', [AdminStockController::class, 'destroy'])->name('admin.stocks.destroy');

        // Update Order Status
        Route::get('/updateOrderStatus', [AdminOrderStatusController::class, 'index'])->name('admin.updateOrderStatus');
        Route::put('/updateOrderStatus/{id}', [AdminOrderStatusController::class, 'update'])->name('admin.updateOrderStatus.update');
        Route::post('/createDelivery', [AdminOrderStatusController::class, 'createDelivery'])->name('admin.createDelivery');

        Route::get('/orderDetails/{orderID}', [AdminOrderStatusController::class, 'orderDetails'])->name('admin.orderDetails');
        Route::get('/checkStockAvailability/{orderID}', [AdminOrderStatusController::class, 'checkStockAvailability']);

        Route::put('/updateDeliveryStatus/{deliveryID}', [ManageDeliveriesController::class, 'updateDeliveryStatus'])->name('admin.updateDeliveryStatus');
        Route::get('/arrangeDelivery', [ManageDeliveriesController::class, 'index'])->name('admin.arrangeDelivery');
        Route::get('/getMinDate/{deliveryID}/{currentStatus}', [ManageDeliveriesController::class, 'getMinDate'])->name('admin.getMinDate');

        Route::get('/adminOrderHistory', [AdminOrderHistoryController::class, 'index'])->name('admin.adminOrderHistory');
        Route::get('/adminOrderDetails/{deliveryID}', [AdminOrderHistoryController::class, 'adminOrderDetails'])->name('admin.adminOrderDetails');
        Route::get('/adminDeliveryDetails/{deliveryID}', [AdminOrderHistoryController::class, 'adminDeliveryDetails'])->name('admin.adminDeliveryDetails');
    });
});