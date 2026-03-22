<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        'App\Admin\Repositories\Holiday\HolidayRepositoryInterface' => 'App\Admin\Repositories\Holiday\HolidayRepository',
        'App\Admin\Repositories\Review\ReviewRepositoryInterface' => 'App\Admin\Repositories\Review\ReviewRepository',
        'App\Admin\Repositories\ReportOrder\ReportOrderRepositoryInterface' => 'App\Admin\Repositories\ReportOrder\ReportOrderRepository',
        'App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface' => 'App\Admin\Repositories\CategorySystem\CategorySystemRepository',
        'App\Admin\Repositories\Module\ModuleRepositoryInterface' => 'App\Admin\Repositories\Module\ModuleRepository',
        'App\Admin\Repositories\Permission\PermissionRepositoryInterface' => 'App\Admin\Repositories\Permission\PermissionRepository',
        'App\Admin\Repositories\Role\RoleRepositoryInterface' => 'App\Admin\Repositories\Role\RoleRepository',
        'App\Admin\Repositories\Admin\AdminRepositoryInterface' => 'App\Admin\Repositories\Admin\AdminRepository',
        'App\Admin\Repositories\User\UserRepositoryInterface' => 'App\Admin\Repositories\User\UserRepository',
        'App\Admin\Repositories\Order\OrderRepositoryInterface' => 'App\Admin\Repositories\Order\OrderRepository',
        'App\Admin\Repositories\Order\OrderDetailRepositoryInterface' => 'App\Admin\Repositories\Order\OrderDetailRepository',
        'App\Admin\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepositoryInterface' => 'App\Admin\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepository',
        'App\Admin\Repositories\Slider\SliderRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderRepository',
        'App\Admin\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderItemRepository',
        'App\Admin\Repositories\Setting\SettingRepositoryInterface' => 'App\Admin\Repositories\Setting\SettingRepository',
        'App\Admin\Repositories\Post\PostRepositoryInterface' => 'App\Admin\Repositories\Post\PostRepository',
        'App\Admin\Repositories\PostCategory\PostCategoryRepositoryInterface' => 'App\Admin\Repositories\PostCategory\PostCategoryRepository',
        'App\Admin\Repositories\Category\CategoryRepositoryInterface' => 'App\Admin\Repositories\Category\CategoryRepository',
        'App\Admin\Repositories\Area\AreaRepositoryInterface' => 'App\Admin\Repositories\Area\AreaRepository',
        'App\Admin\Repositories\Driver\DriverRepositoryInterface' => 'App\Admin\Repositories\Driver\DriverRepository',
        'App\Admin\Repositories\Notification\NotificationRepositoryInterface' => 'App\Admin\Repositories\Notification\NotificationRepository',
        'App\Admin\Repositories\Vehicle\VehicleRepositoryInterface' => 'App\Admin\Repositories\Vehicle\VehicleRepository',
        'App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface' => 'App\Admin\Repositories\VehicleLines\VehicleLinesRepository',
        'App\Admin\Repositories\Discount\DiscountRepositoryInterface' => 'App\Admin\Repositories\Discount\DiscountRepository',
        'App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface' => 'App\Admin\Repositories\Discount\DiscountApplicationRepository',
        'App\Admin\Repositories\Otp\OtpRepositoryInterface' => 'App\Admin\Repositories\Otp\OtpRepository',
        'App\Admin\Repositories\Route\RouteRepositoryInterface' => 'App\Admin\Repositories\Route\RouteRepository',
        'App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface' => 'App\Admin\Repositories\RouteVariant\RouteVariantRepository',
        'App\Admin\Repositories\WeightRange\WeightRangeRepositoryInterface' => 'App\Admin\Repositories\WeightRange\WeightRangeRepository',
        'App\Admin\Repositories\DriverRateWeight\DriverRateWeightRepositoryInterface' => 'App\Admin\Repositories\DriverRateWeight\DriverRateWeightRepository',
        'App\Admin\Repositories\Wallet\WalletRepositoryInterface' => 'App\Admin\Repositories\Wallet\WalletRepository',
        'App\Admin\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Admin\Repositories\Transaction\TransactionRepository',
        'App\Admin\Repositories\Bank\BankRepositoryInterface' => 'App\Admin\Repositories\Bank\BankRepository',
        'App\Admin\Repositories\RecentLocation\RecentLocationRepositoryInterface' => 'App\Admin\Repositories\RecentLocation\RecentLocationRepository',
        'App\Admin\Repositories\Address\AddressRepositoryInterface' => 'App\Admin\Repositories\Address\AddressRepository',
        'App\Admin\Repositories\Shipment\ShipmentRepositoryInterface' => 'App\Admin\Repositories\Shipment\ShipmentRepository',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->repositories as $interface => $implement) {
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
