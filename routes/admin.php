<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Admin\Http\Controllers\Home\HomeController::class, 'index']);

// login
Route::controller(App\Admin\Http\Controllers\Auth\LoginController::class)
    ->middleware('guest:admin')
    ->prefix('/login')
    ->as('login.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'login')->name('post');
    });

Route::group(['middleware' => 'admin.auth.admin:admin'], function () {

    //weight range
    Route::controller(App\Admin\Http\Controllers\WeightRange\WeightRangeController::class)
        ->prefix('/trong-luong')
        ->as('weightRange.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createWeightRange', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewWeightRange', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateWeightRange', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteWeightRange', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });

    //area
    Route::controller(App\Admin\Http\Controllers\Area\AreaController::class)
        ->prefix('/khu-vuc')
        ->as('area.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createArea', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewArea', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateArea', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteArea', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });

    //transaction
    Route::controller(App\Admin\Http\Controllers\Transaction\TransactionController::class)
        ->prefix('/giao-dich')
        ->as('transaction.')
        ->group(function () {

            Route::group(['middleware' => ['permission:viewTransaction', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateTransaction', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteTransaction', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });


    // Wallet
    Route::controller(App\Admin\Http\Controllers\Wallet\WalletController::class)
        ->prefix('/vi-wallet')
        ->as('wallet.')
        ->group(function () {

            Route::group(['middleware' => ['permission:createDeposit', 'auth:admin']], function () {
                Route::get('/balance', 'getBalance')->name('balance');
                Route::post('/deposit', 'deposit')->name('deposit');
                Route::post('/withdraw', 'withdraw')->name('withdraw');
            });
        });

    Route::prefix('/tai-xe')->as('driver.')->group(function () {
        //driver
        Route::controller(App\Admin\Http\Controllers\Driver\DriverController::class)
            ->group(function () {
                Route::group(['middleware' => ['permission:createDriver', 'auth:admin']], function () {
                    Route::get('/them', 'create')->name('create');
                    Route::post('/them', 'store')->name('store');
                });
                Route::group(['middleware' => ['permission:viewDriver', 'auth:admin']], function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/order-rate', 'orderRate')->name('orderRate');
                    Route::get('/discount/{id}', 'discount')->name('discount');
                    Route::get('/{id}/history', 'orders')->name('orders');
                    Route::delete('/{id}/history', 'delete_order')->name('delete_order');
                    Route::get('/sua/{id}', 'edit')->name('edit');
                    Route::get('/pending', 'pendingVerification')->name('pendingVerification');
                    Route::get('/reviews/{id}', 'reviews')->name('reviews');
                    Route::delete('/reviews/{id}', 'deleteReview')->name('deleteReview');
                    Route::post('/multiple', 'actionDriverMultipleRecode')->name('multiple');
                    Route::post('/pending/multiple', 'actionPendingDriverMultipleRecode')->name('pendingMultiple');
                });
                Route::group(['middleware' => ['permission:updateDriver', 'auth:admin']], function () {
                    Route::put('/sua', action: 'update')->name('update');
                });

                Route::group(['middleware' => ['permission:deleteDriver', 'auth:admin']], function () {
                    Route::delete('/approve/{id}', 'approve')->name('approve');
                    Route::delete('/reject/{id}', 'reject')->name('reject');
                    Route::delete('/xoa/{id}', 'delete')->name('delete');
                });
            });

        //route
        Route::prefix('/chuyen-di')->as('route.')->group(function () {
            Route::controller(App\Admin\Http\Controllers\Route\RouteController::class)->group(function () {
                Route::get('/{driverId}', 'index')->name('index');
                Route::get('/{driverId}/add/', 'create')->name('create');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/edit', 'update')->name('update');
                Route::post('/add', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::post('multiple', 'actionMultipleRecord')->name('multiple');
            });
        });
    });

    //Address
    Route::prefix('/dia-chi')->as('address.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Address\AddressController::class)->group(function () {
            Route::get('/them/{id}', 'create')->name('create');
            Route::post('/them', 'store')->name('store');

            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');

            Route::put('/sua', 'update')->name('update');

            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });

    //Notification
    Route::controller(App\Admin\Http\Controllers\Notification\NotificationController::class)
        ->prefix('/thong-bao')
        ->as('notification.')
        ->group(function () {
            Route::get('/not-read-admin', 'getNotificationsForAdmin')->name('getNotificationAdmin');
            Route::patch('/status', 'updateStatus')->name('status');
            Route::post('/update-device-token', 'updateDeviceToken')->name('updateDeviceToken');


            Route::group(['middleware' => ['permission:createNotification', 'auth:admin']], function () {
                Route::get('/add', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewNotification', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/nap-tien', 'deposit')->name('deposit');
                Route::get('/rut-tien', 'withdraw')->name('withdraw');
                Route::get('/thanh-toan', 'payment')->name('payment');
                Route::get('/bao-cao', 'report')->name('report');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
            });

            Route::group(['middleware' => ['permission:updateNotification', 'auth:admin']], function () {
                Route::put('/edit', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteNotification', 'auth:admin']], function () {
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });

    //store


    //Discount
    Route::controller(App\Admin\Http\Controllers\Discount\DiscountController::class)
        ->prefix('/ma-giam-gia')
        ->as('discount.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createDiscountCode', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewDiscountCode', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/expired', 'expired')->name('expired');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
                Route::get('/discount/apply/{discountId}', 'apply')->name('apply');
            });

            Route::group(['middleware' => ['permission:updateDiscountCode', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteDiscountCode', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });

    //Holiday
    Route::controller(App\Admin\Http\Controllers\Holiday\HolidayController::class)
        ->prefix('/ngay-le')
        ->as('holiday.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createHoliday', 'auth:admin']], function () {
                Route::get('/add', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewHoliday', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
            });

            Route::group(['middleware' => ['permission:updateHoliday', 'auth:admin']], function () {
                Route::put('/edit', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteHoliday', 'auth:admin']], function () {
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });



    //Vehicle
    Route::controller(App\Admin\Http\Controllers\Vehicle\VehicleController::class)
        ->prefix('/phuong-tien')
        ->as('vehicle.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createVehicle', 'auth:admin']], function () {
                Route::get('/add', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewVehicle', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
            });

            Route::group(['middleware' => ['permission:updateVehicle', 'auth:admin']], function () {
                Route::put('/edit', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteVehicle', 'auth:admin']], function () {
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });

    //VehicleLines
    Route::controller(App\Admin\Http\Controllers\VehicleLines\VehicleLinesController::class)
        ->prefix('/dong-xe')
        ->as('VehicleLine.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createVehicleLines', 'auth:admin']], function () {
                Route::get('/add', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewVehicleLines', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
            });

            Route::group(['middleware' => ['permission:updateVehicleLines', 'auth:admin']], function () {
                Route::put('/edit', 'update')->name('update');
            });

            // Route::group(['middleware' => ['permission:deleteVehicleLines', 'auth:admin']], function () {
            //     Route::delete('/delete/{id}', 'delete')->name('delete');
            // });

        });

    //***** -- Module -- ******* //
    Route::prefix('/module')->as('module.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Module\ModuleController::class)->group(function () {
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/summary', 'summary')->name('summary');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });
    //***** -- Module -- ******* //

    //***** -- Permission -- ******* //
    Route::prefix('/quyen')->as('permission.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Permission\PermissionController::class)->group(function () {
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });
    //***** -- Permission -- ******* //

    //***** -- Role -- ******* //
    Route::prefix('/vai-tro')->as('role.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Role\RoleController::class)->group(function () {

            Route::group(['middleware' => ['permission:createRole', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewRole', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateRole', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteRole', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });
    //***** -- Role -- ******* //


    //Post
    Route::prefix('/bai-viet')->as('post.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Post\PostController::class)->group(function () {

            Route::group(['middleware' => ['permission:createPost', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewPost', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');
            });

            Route::group(['middleware' => ['permission:updatePost', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deletePost', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    // category C-Delivery
    Route::prefix('/danh-muc-c-delivery')->as('category.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Category\CategoryController::class)->group(function () {
            Route::group(['middleware' => ['permission:createCategory', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewCategory', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateCategory', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteCategory', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });



    //Post category
    Route::prefix('/danh-muc-bai-viet')->as('post_category.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\PostCategory\PostCategoryController::class)->group(function () {
            Route::group(['middleware' => ['permission:createPostCategory', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewPostCategory', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updatePostCategory', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deletePostCategory', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //Settings
    Route::controller(App\Admin\Http\Controllers\Setting\SettingController::class)
        ->prefix('/cai-dat')
        ->as('setting.')
        ->group(function () {
            Route::group(['middleware' => ['permission:settingGeneral', 'auth:admin']], function () {
                Route::get('/general', 'general')->name('general');
                Route::get('/systems', 'system')->name('system');
                Route::get('/c_rides', 'c_ride')->name('c_ride');
                Route::get('/c_cars', 'c_car')->name('c_car');
                Route::get('/c_deliverys', 'c_delivery')->name('c_delivery');
                Route::get('/c_intercitys', 'c_intercity')->name('c_intercity');
                Route::get('/c_multi', 'c_multi')->name('c_multi');
            });

            Route::get('/user-shopping', 'userShopping')->name('user_shopping');
            Route::put('/update', 'update')->name('update');
        });

    //sliders
    Route::prefix('/sliders')->as('slider.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Slider\SliderItemController::class)
            ->as('item.')
            ->group(function () {
                Route::get('/{slider_id}/item/them', 'create')->name('create');
                Route::get('/{slider_id}/item', 'index')->name('index');
                Route::get('/item/sua/{id}', 'edit')->name('edit');
                Route::put('/item/sua', 'update')->name('update');
                Route::post('/item/them', 'store')->name('store');
                Route::delete('/{slider_id}/item/xoa/{id}', 'delete')->name('delete');
            });
        Route::controller(App\Admin\Http\Controllers\Slider\SliderController::class)->group(function () {
            Route::group(['middleware' => ['permission:createSlider', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewSlider', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateSlider', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteSlider', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });


    //C-Ride/Car Order
    Route::prefix('/don-hang-c-ride-car')->as('cRide.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Order\CRideCarController::class)->group(function () {
            //            Route::group(['middleware' => ['permission:createCRideCar', 'auth:admin']], function () {
            //                Route::get('/them', 'create')->name('create');
            //                Route::post('/them', 'store')->name('store');
            //            });

            Route::group(['middleware' => ['permission:viewCRideCar', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });


            Route::group(['middleware' => ['permission:updateCRideCar', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
            //
            //            Route::group(['middleware' => ['permission:deleteCRideCar', 'auth:admin']], function () {
            //                Route::delete('/xoa/{id}', 'delete')->name('delete');
            //            });


        });
    });

    //C-Delivery
    Route::prefix('/don-hang-c-delivery')->as('cDelivery.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Order\CDeliveryController::class)->group(function () {
            //            Route::group(['middleware' => ['permission:createCDelivery', 'auth:admin']], function () {
            //                Route::get('/them', 'create')->name('create');
            //                Route::post('/them', 'store')->name('store');
            //            });

            Route::group(['middleware' => ['permission:viewCDelivery', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });


            Route::group(['middleware' => ['permission:updateCDelivery', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
            //
            //            Route::group(['middleware' => ['permission:deleteCDelivery', 'auth:admin']], function () {
            //                Route::delete('/xoa/{id}', 'delete')->name('delete');
            //            });


        });
    });

    //C-Multi
    Route::prefix('/don-hang-c-multi')->as('cMulti.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Order\CMultiController::class)->group(function () {

            Route::group(['middleware' => ['permission:viewCMulti', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');

                Route::get('/shipment', 'shipment')->name('shipment');
                Route::get('/shipment/sua/{id}', 'editShipment')->name('shipment.edit');
                Route::put('/shipment/sua', 'updateShipment')->name('shipment.update');
            });


            Route::group(['middleware' => ['permission:updateCMulti', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
            //
            Route::group(['middleware' => ['permission:deleteCDelivery', 'auth:admin']], function () {
                // Route::delete('/xoa/{id}', 'delete')->name('delete');
                Route::delete('/xoa/shipment/{id}', 'deleteShipment')->name('deleteShipment');
            });


        });
    });

    //Multi Point Detail
    Route::prefix('/don-hang-multi-point-detail')->as('multiPointDetail.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Order\OrderMultiPointDetailController::class)->group(function () {
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
        });
    });

    //C-Intercity
    Route::prefix('/don-hang-c-intercity')->as('cIntercity.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Order\CIntercityController::class)->group(function () {

            Route::group(['middleware' => ['permission:viewCIntercity', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/routes', 'routes')->name('routes');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateCIntercity', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

        });
    });

    //Report Order
    Route::prefix('/bao-cao-don-hang')->as('report_order.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\ReportOrder\ReportOrderController::class)->group(function () {

            Route::group(['middleware' => ['permission:viewReportOrder', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:deleteReportOrder', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });


        });
    });

    //user
    Route::prefix('/khach-hang')->as('user.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\User\UserController::class)->group(function () {
            Route::group(['middleware' => ['permission:createUser', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewUser', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}/history', 'history')->name('history');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::post('/multiple', 'actionMultipleRecode')->name('multiple');

            });

            Route::group(['middleware' => ['permission:updateUser', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteUser', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
        // Route::get('/select-search', [AdminSearchController::class, 'selectSearch'])->name('selectsearch');

    });
    //admin
    Route::prefix('/quan-tri')->as('admin.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Admin\AdminController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //ckfinder
    Route::prefix('/quan-ly-file')->as('ckfinder.')->group(function () {
        Route::any('/ket-noi', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
            ->name('connector');
        Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
            ->name('browser');
    });
    Route::get('/dashboard', [App\Admin\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //auth
    Route::controller(App\Admin\Http\Controllers\Auth\ProfileController::class)
        ->prefix('/trang-ca-nhan')
        ->as('profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });

    Route::controller(App\Admin\Http\Controllers\Auth\ChangePasswordController::class)
        ->prefix('/mat-khau')
        ->as('password.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    Route::prefix('/tim-kiem')->as('search.')->group(function () {
        Route::prefix('/select')->as('select.')->group(function () {
            Route::get('/user', [App\Admin\Http\Controllers\User\UserSearchSelectController::class, 'selectSearch'])->name('user');
            Route::get('/area', [App\Admin\Http\Controllers\Area\AreaSearchSelectController::class, 'selectSearch'])->name('area');
            Route::get('/driver', [App\Admin\Http\Controllers\Driver\DriverSearchSelectController::class, 'selectSearch'])->name('driver');
            Route::get('/vehicle', [App\Admin\Http\Controllers\Vehicle\VehicleSearchSelectController::class, 'selectSearch'])->name('vehicle');
            Route::get('/customer', [App\Admin\Http\Controllers\User\CustomerSearchSelectController::class, 'selectSearch'])->name('customer');
            Route::get('/vehicle-lines', [App\Admin\Http\Controllers\VehicleLines\VehicleLinesSearchSelectController::class, 'selectSearch'])->name('vehicleLine');
        });
    });
    //***** -- Category System -- ******* //
    Route::prefix('/danh-muc-he-thong')->as('category_system.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\CategorySystem\CategorySystemController::class)->group(function () {

            Route::group(['middleware' => ['permission:createServices', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });

            Route::group(['middleware' => ['permission:viewServices', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateServices', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteServices', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });
    //***** -- Category System -- ******* //

    Route::post('/logout', [App\Admin\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});