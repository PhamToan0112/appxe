<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Api\V1\Services\ReportOrder\ReportOrderServiceInterface' => 'App\Api\V1\Services\ReportOrder\ReportOrderService',
        'App\Api\V1\Services\Address\AddressServiceInterface' => 'App\Api\V1\Services\Address\AddressService',
        'App\Api\V1\Services\CategorySystem\CategorySystemServiceInterface' => 'App\Api\V1\Services\CategorySystem\CategorySystemService',
        'App\Api\V1\Services\User\UserServiceInterface' => 'App\Api\V1\Services\User\UserService',
        'App\Api\V1\Services\Auth\StoreServiceInterface' => 'App\Api\V1\Services\Auth\StoreService',
        'App\Api\V1\Services\Driver\DriverServiceInterface' => 'App\Api\V1\Services\Driver\DriverService',
        'App\Api\V1\Services\Order\OrderServiceInterface' => 'App\Api\V1\Services\Order\OrderService',
        'App\Api\V1\Services\Order\CMulti\OrderCMultiServiceInterface' => 'App\Api\V1\Services\Order\CMulti\OrderCMultiService',
        'App\Api\V1\Services\Order\CRideCar\OrderCRideCarServiceInterface' => 'App\Api\V1\Services\Order\CRideCar\OrderCRideCarService',
        'App\Api\V1\Services\Order\CDelivery\OrderCDeliveryServiceInterface' => 'App\Api\V1\Services\Order\CDelivery\OrderCDeliveryService',
        'App\Api\V1\Services\Order\CIntercity\OrderCInterCityServiceInterface' => 'App\Api\V1\Services\Order\CIntercity\OrderCIntercityService',
        'App\Api\V1\Services\Review\ReviewServiceInterface' => 'App\Api\V1\Services\Review\ReviewService',
        'App\Api\V1\Services\Vehicle\VehicleServiceInterface' => 'App\Api\V1\Services\Vehicle\VehicleService',
        'App\Api\V1\Services\Notification\NotificationServiceInterface' => 'App\Api\V1\Services\Notification\NotificationService',
        'App\Api\V1\Services\Discount\DiscountServiceInterface' => 'App\Api\V1\Services\Discount\DiscountService',
        'App\Api\V1\Services\Wallet\WalletServiceInterface' => 'App\Api\V1\Services\Wallet\WalletService',
        'App\Api\V1\Services\Transaction\TransactionServiceInterface' => 'App\Api\V1\Services\Transaction\TransactionService',
        'App\Api\V1\Services\Shipment\ShipmentServiceInterface' => 'App\Api\V1\Services\Shipment\ShipmentService',
        'App\Api\V1\Services\Route\RouteServiceInterface' => 'App\Api\V1\Services\Route\RouteService',
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
