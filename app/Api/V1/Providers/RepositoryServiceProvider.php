<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        'App\Api\V1\Repositories\ReportOrder\ReportOrderRepositoryInterface' => 'App\Api\V1\Repositories\ReportOrder\ReportOrderRepository',
        'App\Api\V1\Repositories\Address\AddressRepositoryInterface' => 'App\Api\V1\Repositories\Address\AddressRepository',
        'App\Api\V1\Repositories\Category\CategoryRepositoryInterface' => 'App\Api\V1\Repositories\Category\CategoryRepository',
        'App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface' => 'App\Api\V1\Repositories\CategorySystem\CategorySystemRepository',
        'App\Api\V1\Repositories\User\UserRepositoryInterface' => 'App\Api\V1\Repositories\User\UserRepository',
        'App\Api\V1\Repositories\Driver\DriverRepositoryInterface' => 'App\Api\V1\Repositories\Driver\DriverRepository',
        'App\Api\V1\Repositories\Order\OrderRepositoryInterface' => 'App\Api\V1\Repositories\Order\OrderRepository',
        'App\Api\V1\Repositories\Order\OrderDetailRepositoryInterface' => 'App\Api\V1\Repositories\Order\OrderDetailRepository',
        'App\Api\V1\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepositoryInterface' => 'App\Api\V1\Repositories\OrderMultiPointDetail\OrderMultiPointDetailRepository',
        'App\Api\V1\Repositories\Slider\SliderRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderRepository',
        'App\Api\V1\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderItemRepository',
        'App\Api\V1\Repositories\Post\PostRepositoryInterface' => 'App\Api\V1\Repositories\Post\PostRepository',
        'App\Api\V1\Repositories\PostCategory\PostCategoryRepositoryInterface' => 'App\Api\V1\Repositories\PostCategory\PostCategoryRepository',
        'App\Api\V1\Repositories\Review\ReviewRepositoryInterface' => 'App\Api\V1\Repositories\Review\ReviewRepository',
        'App\Api\V1\Repositories\Discount\DiscountRepositoryInterface' => 'App\Api\V1\Repositories\Discount\DiscountRepository',
        'App\Api\V1\Repositories\Area\AreaRepositoryInterface' => 'App\Api\V1\Repositories\Area\AreaRepository',
        'App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface' => 'App\Api\V1\Repositories\Vehicle\VehicleRepository',
        'App\Api\V1\Repositories\Notification\NotificationRepositoryInterface' => 'App\Api\V1\Repositories\Notification\NotificationRepository',
        'App\Api\V1\Repositories\Wallet\WalletRepositoryInterface' => 'App\Api\V1\Repositories\Wallet\WalletRepository',
        'App\Api\V1\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Api\V1\Repositories\Transaction\TransactionRepository',
        'App\Api\V1\Repositories\WeightRange\WeightRangeRepositoryInterface' => 'App\Api\V1\Repositories\WeightRange\WeightRangeRepository',
        'App\Api\V1\Repositories\Setting\SettingRepositoryInterface' => 'App\Api\V1\Repositories\Setting\SettingRepository',
        'App\Api\V1\Repositories\Shipment\ShipmentRepositoryInterface' => 'App\Api\V1\Repositories\Shipment\ShipmentRepository',
        'App\Api\V1\Repositories\Route\RouteRepositoryInterface' => 'App\Api\V1\Repositories\Route\RouteRepository',

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
