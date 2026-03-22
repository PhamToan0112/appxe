<?php

namespace App\Admin\Http\Controllers\Dashboard;

use App\Admin\Http\Controllers\Controller;
use App\Enums\DeleteStatus;
use App\Enums\Order\OrderType;
use App\Models\Admin;
use App\Models\Area;
use App\Models\CategorySystem;
use App\Models\Discount;
use App\Models\Driver;
use App\Models\Holiday;
use App\Models\Module;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Slider;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleLines;

class DashboardController extends Controller
{
    //

    public function getView()
    {
        return [
            'index' => 'admin.dashboard.index'
        ];
    }
    public function index()
    {
        $rowCountTransaction = Transaction::where('is_deleted', DeleteStatus::NotDeleted)->count();
        $rowCountOrderCRideCar = Order::where('order_type', OrderType::C_RIDE)->count() + Order::where('order_type', OrderType::C_CAR)->count();
        $rowCountOrderCDelivery = Order::where('order_type', OrderType::C_Delivery)->count();
        $rowCountOrderCIntercity = Order::where('order_type', OrderType::C_Intercity)->count();
        $rowCountOrderCMulti = Order::where('order_type', OrderType::C_Multi)->count();
        $rowCountUser = User::whereNotIn('id', Driver::pluck('user_id'))->count();
        $rowCountDriver = Driver::count();
        $rowCountAdmin = Admin::count();
        $rowCountCategorySystem = CategorySystem::count();
        $rowCountArea = Area::count();
        $rowCountNotification = Notification::count();
        $rowCountPost = Post::count();
        $rowCountHoliday = Holiday::count();
        $rowCountDiscount = Discount::count();
        $rowCountReportOrder = Order::whereHas('issues', function ($query) {
            $query->whereNotNull('order_id');
        })->count();
        $rowCountVehicle = Vehicle::count();
        $rowCountVehicleLine = VehicleLines::count();
        $rowCountSlider = Slider::count();
        $rowCountRole = Role::count();

        return view($this->getView()['index'], [
            'rowCountTransaction' => $rowCountTransaction,
            'rowCountOrderCRideCar' => $rowCountOrderCRideCar,
            'rowCountOrderCDelivery' => $rowCountOrderCDelivery,
            'rowCountOrderCIntercity' => $rowCountOrderCIntercity,
            'rowCountOrderCMulti' => $rowCountOrderCMulti,
            'rowCountUser' => $rowCountUser,
            'rowCountDriver' => $rowCountDriver,
            'rowCountAdmin' => $rowCountAdmin,
            'rowCountCategorySystem' => $rowCountCategorySystem,
            'rowCountArea' => $rowCountArea,
            'rowCountNotification' => $rowCountNotification,
            'rowCountPost' => $rowCountPost,
            'rowCountHoliday' => $rowCountHoliday,
            'rowCountDiscount' => $rowCountDiscount,
            'rowCountReportOrder' => $rowCountReportOrder,
            'rowCountVehicle' => $rowCountVehicle,
            'rowCountVehicleLine' => $rowCountVehicleLine,
            'rowCountSlider' => $rowCountSlider,
            'rowCountRole' => $rowCountRole,
        ]);
    }

}