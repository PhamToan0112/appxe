<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Admin\Services\Holiday\HolidayServiceInterface' => 'App\Admin\Services\Holiday\HolidayService',
        'App\Admin\Services\Review\ReviewServiceInterface' => 'App\Admin\Services\Review\ReviewService',
        'App\Admin\Services\ReportOrder\ReportOrderServiceInterface' => 'App\Admin\Services\ReportOrder\ReportOrderService',
        'App\Admin\Services\Transaction\TransactionServiceInterface' => 'App\Admin\Services\Transaction\TransactionService',
        'App\Admin\Services\CategorySystem\CategorySystemServiceInterface' => 'App\Admin\Services\CategorySystem\CategorySystemService',
        'App\Admin\Services\Module\ModuleServiceInterface' => 'App\Admin\Services\Module\ModuleService',
        'App\Admin\Services\Permission\PermissionServiceInterface' => 'App\Admin\Services\Permission\PermissionService',
        'App\Admin\Services\Role\RoleServiceInterface' => 'App\Admin\Services\Role\RoleService',
        'App\Admin\Services\Admin\AdminServiceInterface' => 'App\Admin\Services\Admin\AdminService',
        'App\Admin\Services\User\UserServiceInterface' => 'App\Admin\Services\User\UserService',
        'App\Admin\Services\Order\OrderServiceInterface' => 'App\Admin\Services\Order\OrderService',
        'App\Admin\Services\Slider\SliderServiceInterface' => 'App\Admin\Services\Slider\SliderService',
        'App\Admin\Services\Slider\SliderItemServiceInterface' => 'App\Admin\Services\Slider\SliderItemService',
        'App\Admin\Services\Post\PostServiceInterface' => 'App\Admin\Services\Post\PostService',
        'App\Admin\Services\PostCategory\PostCategoryServiceInterface' => 'App\Admin\Services\PostCategory\PostCategoryService',
        'App\Admin\Services\Category\CategoryServiceInterface' => 'App\Admin\Services\Category\CategoryService',
        'App\Admin\Services\Area\AreaServiceInterface' => 'App\Admin\Services\Area\AreaService',
        'App\Admin\Services\Driver\DriverServiceInterface' => 'App\Admin\Services\Driver\DriverService',
        'App\Admin\Services\Notification\NotificationServiceInterface' => 'App\Admin\Services\Notification\NotificationService',
        'App\Admin\Services\Vehicle\VehicleServiceInterface' => 'App\Admin\Services\Vehicle\VehicleService',
        'App\Admin\Services\VehicleLines\VehicleLinesServiceInterface' => 'App\Admin\Services\VehicleLines\VehicleLinesService',
        'App\Admin\Services\Discount\DiscountApplicationServiceInterface' => 'App\Admin\Services\Discount\DiscountApplicationService',
        'App\Admin\Services\Discount\DiscountServiceInterface' => 'App\Admin\Services\Discount\DiscountService',
        'App\Admin\Services\Route\RouteServiceInterface' => 'App\Admin\Services\Route\RouteService',
        'App\Admin\Services\WeightRange\WeightRangeServiceInterface' => 'App\Admin\Services\WeightRange\WeightRangeService',
        'App\Admin\Services\Wallet\WalletServiceInterface' => 'App\Admin\Services\Wallet\WalletService',
        'App\Admin\Services\Calculation\CalculationServiceInterface' => 'App\Admin\Services\Calculation\CalculationServiceService',
        'App\Admin\Services\Address\AddressServiceInterface' => 'App\Admin\Services\Address\AddressService',
        'App\Admin\Services\Shipment\ShipmentServiceInterface' => 'App\Admin\Services\Shipment\ShipmentService',
        'App\Admin\Services\OrderMultiPointDetail\OrderMultiPointDetailServiceInterface' => 'App\Admin\Services\OrderMultiPointDetail\OrderMultiPointDetailService',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->services as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}