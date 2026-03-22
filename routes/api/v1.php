<?php

use App\Api\V1\Http\Controllers\Auth\AuthController;
use App\Api\V1\Http\Controllers\Bank\BankController;
use App\Api\V1\Http\Controllers\Calculation\CalculationController;
use App\Api\V1\Http\Controllers\Driver\DriverController;
use App\Api\V1\Http\Controllers\ReportOrder\ReportOrderController;
use App\Api\V1\Http\Controllers\Order\CDeliveryOrderController;
use App\Api\V1\Http\Controllers\Order\CIntercityOrderController;
use App\Api\V1\Http\Controllers\Order\CMultiOrderController;
use App\Api\V1\Http\Controllers\Order\CRideOrderController;
use App\Api\V1\Http\Controllers\Order\OrderController;
use App\Api\V1\Http\Controllers\Route\RouteController;
use App\Api\V1\Http\Controllers\User\UserController;
use App\Api\V1\Http\Controllers\Address\AddressController;
use App\Api\V1\Http\Controllers\Vehicle\VehicleController;
use App\Api\V1\Http\Controllers\Wallet\WalletController;
use App\Api\V1\Http\Controllers\WeightRange\WeightRangeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//notification
Route::controller(App\Api\V1\Http\Controllers\Notification\NotificationController::class)
    ->prefix('/notifications')
    ->as('note.')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{id}', 'show');
        Route::patch('/read/{id}', 'markAsRead');
        Route::delete('/{id}', 'deleteNotification');
    });


//vehicles
Route::prefix('vehicles')->controller(VehicleController::class)
    ->group(function () {
        Route::get('/', 'view')->name('view');
        Route::get('/{id}', 'show')->name('show');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');

    });


//driver
Route::prefix('drivers')->controller(DriverController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::get('/configs', 'getDriverConfigs')->name('getDriverConfigs');
        Route::put('/update-configs', 'updateDriverConfigs')->name('updateDriverConfigs');
        Route::get('/info', 'getDriverInfo')->name('getDriverInfo');

        Route::post('/search-ride-car', 'searchRideCar')->name('searchRideCar');
        Route::post('/search-delivery', 'searchDelivery')->name('searchDelivery');
        Route::post('/search-multi', 'searchMulti')->name('searchMulti');
        Route::post('/search-intercity', 'searchIntercity')->name('searchIntercity');
    });

//auth
Route::prefix('auth')->controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login');
        Route::get('/', 'show');
        Route::post('/verification-otp', 'verificationOtp');
        Route::post('/resend-otp', 'resendOtp');
        Route::put('/update-password', 'forgotPassword');
        Route::put('/change-password', 'updatePassword');
        Route::put('/update-email', 'updateEmail');
        Route::put('/update-device-token', 'updateDeviceToken')->name('updateToken');
    });

//auth
Route::prefix('users')->controller(UserController::class)
    ->group(function () {
        Route::get('/configuration', 'configuration');
        Route::post('/register', 'register');
        Route::post('/update', 'update');
        Route::post('/all', 'getAllUsers');
        Route::get('/recent-location', 'getRecentLocation');
    });
//bank
Route::prefix('banks')->controller(BankController::class)
    ->group(function () {
        Route::get('/', 'index');
    });

// Addresses
Route::prefix('addresses')->controller(AddressController::class)
    ->group(function () {
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/update/{id}', 'update');
    });


//calculation
Route::prefix('calculate')->controller(CalculationController::class)
    ->group(function () {
        Route::post('/c-ride-car', 'calculateBookCarOrder');
        Route::post('/c-ride-car/by-driver', 'calculateRideCarByDriver');
        Route::post('/c-delivery', 'calculateCDeliveryOrder');
        Route::post('/c-multi', 'calculateCMultiOrder');
        Route::post('/c-intercity', 'calculateCIntercityOrder');
    });
//***** -- discount -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Discount\DiscountController::class)->prefix('/discounts')
    ->as('discount.')
    ->group(function () {
        Route::get('/', 'getByUserOrDriver')->name('getByUserOrDriver');
        Route::post('/', 'createDiscountCode')->name('createDiscountCode');

        //lấy mã còn hạn và hết hạn
        Route::get('/option', 'getOptionDiscountCode')->name('getOptionDiscountCode');
        Route::get('/by-driver', 'getByDriver');

        Route::post('/driver/store', 'driverStore')->name('driverStore');
        Route::put('/driver/update', 'driverUpdate')->name('driverUpdate');
        Route::delete('/driver/delete/{id}', 'driverDelete')->name('driverDelete');

        Route::get('/check-by-driver', 'checkDiscountByDriver')->name('checkDiscountByDriver');
        Route::get('/{id}', 'show')->name('show');
    });

//order
Route::prefix('orders')->controller(OrderController::class)
    ->group(function () {
        Route::get('/', 'getOrderByUser');
        Route::get('/active', 'getActiveOrders');
        Route::get('/no-driver', 'getOrdersWithoutDriver');
        Route::delete('/{id}', 'delete');
        Route::put('/assign-driver', 'assignDriverToOrder');
        Route::put('/select-customer', 'selectCustomerForOrder');
        Route::patch('/status', 'updateStatus');
        Route::post('/upload-confirmation-image', 'uploadOrderConfirmationImage');
        Route::post('/reportOrderIssues', 'reportOrderIssues');
        Route::post('/location', 'updateLocation');
        Route::post('/check-order', 'canPlaceOrder');
    });

Route::prefix('report-order')->controller(ReportOrderController::class)
    ->group(function () {
        Route::post('/', 'store');
    });


// C-Ride/Car
Route::prefix('orders/c-ride-car')->controller(CRideOrderController::class)
    ->group(function () {
        Route::post('/', 'createBookCarOrder');
        Route::put('/', 'update');
        Route::patch('/', 'driverSelectOrder');
        Route::get('/{id}', 'show');
    });

// C-Delivery
Route::prefix('orders/c-delivery')->controller(CDeliveryOrderController::class)
    ->group(function () {
        Route::post('/', 'createDeliveryOrder');
        Route::get('/{id}', 'show');
    });

//C-Multi
Route::prefix('orders/c-multi')->controller(CMultiOrderController::class)
    ->group(function () {
        Route::get('/shipments-ds', 'getShipments');
        Route::get('/{id}', 'show');

        Route::post('/', 'mergeShipmentsIntoOrder');
        Route::post('/shipment', 'createShipment');
        Route::post('/complete', 'completeShipment');
        Route::patch('/shipment/preparing', 'updateShipmentStatusToPreparing');
        Route::patch('/details', 'updateMultiPointOrderDetailStatus');
        Route::delete('/shipments', 'deleteShipments');
    });

// C-Delivery
Route::prefix('orders/c-intercity')->controller(CIntercityOrderController::class)
    ->group(function () {
        Route::post('/', 'createCIntercityOrder');
        Route::get('/{id}', 'show');
    });

// Route
Route::prefix('/routes')->controller(RouteController::class)
    ->group(function () {
        Route::get('/', 'search');
        Route::post('/', 'store');
    });

// Weight Range
Route::prefix('weight-range')->controller(WeightRangeController::class)
    ->group(function () {
        Route::get('/', 'index');
    });

// Category
Route::controller(App\Api\V1\Http\Controllers\Category\CategoryController::class)
    ->prefix('/categories')
    ->as('category.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

//Wallet
Route::prefix('wallets')->controller(WalletController::class)
    ->group(function () {
        Route::get('/check-balance', 'checkBalance');
        Route::post('/deposit', 'deposit');
        Route::post('/withdraw', 'withdraw');
        Route::get('/balance', 'getBalance')->name('getBalance');
    });


//post category
Route::controller(App\Api\V1\Http\Controllers\PostCategory\PostCategoryController::class)
    ->prefix('/posts-categories')
    ->as('post_category.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });

//posts
Route::controller(App\Api\V1\Http\Controllers\Post\PostController::class)
    ->prefix('/posts')
    ->as('post.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/related/{id}', 'related')->name('related');
        Route::post('/', 'filter')->name('filter');
    });

//review Driver
Route::controller(App\Api\V1\Http\Controllers\Review\ReviewController::class)
    ->prefix('/reviews')
    ->as('review.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });


//slider
Route::controller(App\Api\V1\Http\Controllers\Slider\SliderController::class)
    ->prefix('/slider')
    ->as('slider.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{key}', 'show')->name('show');
    });


Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => __('Không tìm thấy đường dẫn.')
    ], 404);
});

//***** -- Category System -- ******* //
Route::controller(App\Api\V1\Http\Controllers\CategorySystem\CategorySystemController::class)
    ->prefix('/category_system')
    ->as('category_system.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });


/*********    Transaction    *********** */
Route::controller(App\Api\V1\Http\Controllers\Transaction\TransactionController::class)
    ->prefix('/transactions')
    ->as('transaction.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'getInfo')->name('getInfo');
    });

//***** -- Setting -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Setting\SettingController::class)
    ->prefix('/settings')
    ->as('setting.')
    ->group(function () {
        Route::get('/general', 'general')->name('general');
        Route::get('/system', 'system')->name('system');
        Route::get('/c-ride', 'c_ride')->name('c_ride');
        Route::get('/c-car', 'c_car')->name('c_car');
        Route::get('/c-delivery', 'c_delivery')->name('c_delivery');
        Route::get('/c-intercity', 'c_intercity')->name('c_intercity');
        Route::get('/c-multi', 'c_multi')->name('c_multi');
    });
