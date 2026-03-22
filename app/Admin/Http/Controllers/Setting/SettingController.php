<?php

namespace App\Admin\Http\Controllers\Setting;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        SettingRepositoryInterface $repository
    )
    {
        parent::__construct();
        $this->repository = $repository;
    }
    public function getView(): array
    { 
        return [
            'general' => 'admin.settings.general',
            'system' => 'admin.settings.system',
            'c_ride' => 'admin.settings.c_ride',
            'c_car' => 'admin.settings.c_car',
            'c_delivery' => 'admin.settings.c_delivery',
            'c_intercity' => 'admin.settings.c_intercity',
            'c_multi' => 'admin.settings.c_multi',
        ];
    }
    public function general(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::General]);

        return view($this->view['general'], 
        [
            'settings' => $settings,
            'breadcrumbs' => $this->crums->add(__('generateSetting')),
        ]);
    }



    public function system(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::System]);
        return view($this->view['system'], [
            'settings' => $settings,
            'breadcrumbs' => $this->crums->add(__('generateSetting')),
        ]);
    }

    public function c_ride(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::C_Ride]);

        $bikeC_Ride_Rush_Hour = [
            'bike_C_Ride_morning_start' => $this->repository->getPlainValue('bike_C_Ride_morning_start'),
            'bike_C_Ride_morning_end' => $this->repository->getPlainValue('bike_C_Ride_morning_end'),
            'bike_C_Ride_afternoon_start' => $this->repository->getPlainValue('bike_C_Ride_afternoon_start'),
            'bike_C_Ride_afternoon_end' => $this->repository->getPlainValue('bike_C_Ride_afternoon_end'),
        ];

        $bikeC_Ride_Settings = [
            'bike_C_Ride_commission' => $this->repository->getPlainValue('bike_C_Ride_commission'),
            'bike_C_Ride_base_distance' => $this->repository->getPlainValue('bike_C_Ride_base_distance'),
            'bike_C_Ride_base_fare' => $this->repository->getPlainValue('bike_C_Ride_base_fare'),
            'bike_C_Ride_distance_to_discount' => $this->repository->getPlainValue('bike_C_Ride_distance_to_discount'),
            'bike_C_Ride_rate_per_km' => $this->repository->getPlainValue('bike_C_Ride_rate_per_km'),
            'bike_C_Ride_rate_per_km_discount' => $this->repository->getPlainValue('bike_C_Ride_rate_per_km_discount'),
        ];

        $excludedKeys = array_keys(array_merge($bikeC_Ride_Settings, $bikeC_Ride_Rush_Hour));
        $filteredSettings = $settings->reject(function ($setting) use ($excludedKeys) {
            return in_array($setting['setting_key'], $excludedKeys);
        });

        return view($this->view['c_ride'], [
            'settings' => $filteredSettings,
            'bikeC_Ride_Settings' => $bikeC_Ride_Settings,
            'bikeC_Ride_Rush_Hour'=> $bikeC_Ride_Rush_Hour,
            'breadcrumbs' => $this->crums->add(__('Cài đặc giá C_Ride')),
        ]);
    }

    public function c_car(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::C_Car]);

        $bikeC_Car_Rush_Hour = [
            'bike_C_Car_morning_start' => $this->repository->getPlainValue('bike_C_Car_morning_start'),
            'bike_C_Car_morning_end' => $this->repository->getPlainValue('bike_C_Car_morning_end'),
            'bike_C_Car_afternoon_start' => $this->repository->getPlainValue('bike_C_Car_afternoon_start'),
            'bike_C_Car_afternoon_end' => $this->repository->getPlainValue('bike_C_Car_afternoon_end'),
        ];

        $bikeC_Car_Settings = [
            'bike_C_Car_commission' => $this->repository->getPlainValue('bike_C_Car_commission'),
            'bike_C_Car_base_distance' => $this->repository->getPlainValue('bike_C_Car_base_distance'),
            'bike_C_Car_base_fare' => $this->repository->getPlainValue('bike_C_Car_base_fare'),
            'bike_C_Car_distance_to_discount' => $this->repository->getPlainValue('bike_C_Car_distance_to_discount'),
            'bike_C_Car_rate_per_km' => $this->repository->getPlainValue('bike_C_Car_rate_per_km'),
            'bike_C_Car_rate_per_km_discount' => $this->repository->getPlainValue('bike_C_Car_rate_per_km_discount'),
        ];

        $excludedKeys = array_keys(array_merge($bikeC_Car_Settings,$bikeC_Car_Rush_Hour));
        $filteredSettings = $settings->reject(function ($setting) use ($excludedKeys) {
            return in_array($setting['setting_key'], $excludedKeys);
        });
        
        return view($this->view['c_car'], [
            'settings' => $filteredSettings,
            'bikeC_Car_Settings' => $bikeC_Car_Settings,
            'bikeC_Car_Rush_Hour' => $bikeC_Car_Rush_Hour,
            'breadcrumbs' => $this->crums->add(__('Cài đặc giá C_Car')),
        ]);
    }

    public function c_delivery(): Factory|View|Application
{
    $settings = $this->repository->getByGroup([SettingGroup::C_Delivery]);

    $bikeC_Delivery_Rush_Hour = [
        'bike_C_Delivery_morning_start' => $this->repository->getPlainValue('bike_C_Delivery_morning_start'),
        'bike_C_Delivery_morning_end' => $this->repository->getPlainValue('bike_C_Delivery_morning_end'),
        'bike_C_Delivery_afternoon_start' => $this->repository->getPlainValue('bike_C_Delivery_afternoon_start'),
        'bike_C_Delivery_afternoon_end' => $this->repository->getPlainValue('bike_C_Delivery_afternoon_end'),
    ];

    $bikeC_Delivery_Settings = [
        'bike_C_Delivery_commission' => $this->repository->getPlainValue('bike_C_Delivery_commission'),
        'bike_C_Delivery_base_distance' => $this->repository->getPlainValue('bike_C_Delivery_base_distance'),
        'bike_C_Delivery_base_fare' => $this->repository->getPlainValue('bike_C_Delivery_base_fare'),
        'bike_C_Delivery_distance_to_discount' => $this->repository->getPlainValue('bike_C_Delivery_distance_to_discount'),
        'bike_C_Delivery_rate_per_km' => $this->repository->getPlainValue('bike_C_Delivery_rate_per_km'),
        'bike_C_Delivery_rate_per_km_discount' => $this->repository->getPlainValue('bike_C_Delivery_rate_per_km_discount'),
    ];

    $excludedKeys = array_keys(array_merge($bikeC_Delivery_Settings,$bikeC_Delivery_Rush_Hour));

    $filteredSettings = $settings->reject(function ($setting) use ($excludedKeys) {
        return in_array($setting['setting_key'], $excludedKeys);
    });

    return view($this->view['c_delivery'], [
        'settings' => $filteredSettings,
        'bikeC_Delivery_Settings' => $bikeC_Delivery_Settings,
        'bikeC_Delivery_Rush_Hour' => $bikeC_Delivery_Rush_Hour,
        'breadcrumbs' => $this->crums->add(__('Cài đặt giá C_Delivery')),
    ]);
}


    public function c_intercity(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::C_Intercity]);

        $bikeC_Intercity_Rush_Hour = [
            'bike_C_Intercity_morning_start' => $this->repository->getPlainValue('bike_C_Intercity_morning_start'),
            'bike_C_Intercity_morning_end' => $this->repository->getPlainValue('bike_C_Intercity_morning_end'),
            'bike_C_Intercity_afternoon_start' => $this->repository->getPlainValue('bike_C_Intercity_afternoon_start'),
            'bike_C_Intercity_afternoon_end' => $this->repository->getPlainValue('bike_C_Intercity_afternoon_end'),
        ];

        $excludedKeys = array_keys($bikeC_Intercity_Rush_Hour);

        $filteredSettings = $settings->reject(function ($setting) use ($excludedKeys) {
            return in_array($setting['setting_key'], $excludedKeys);
        });


        return view($this->view['c_intercity'], [
            'settings' => $filteredSettings,
            'bikeC_Intercity_Rush_Hour' => $bikeC_Intercity_Rush_Hour,
            'breadcrumbs' => $this->crums->add(__('Cài đặc giá C_Intercity')),
        ]);
    }

    public function c_multi(): Factory|View|Application
    {
        $settings = $this->repository->getByGroup([SettingGroup::C_Multi]);

        $bikeC_Multi_Rush_Hour = [
            'bike_C_Multi_morning_start' => $this->repository->getPlainValue('bike_C_Multi_morning_start'),
            'bike_C_Multi_morning_end' => $this->repository->getPlainValue('bike_C_Multi_morning_end'),
            'bike_C_Multi_afternoon_start' => $this->repository->getPlainValue('bike_C_Multi_afternoon_start'),
            'bike_C_Multi_afternoon_end' => $this->repository->getPlainValue('bike_C_Multi_afternoon_end'),
        ];

        $excludedKeys = array_keys($bikeC_Multi_Rush_Hour);

        $filteredSettings = $settings->reject(function ($setting) use ($excludedKeys) {
            return in_array($setting['setting_key'], $excludedKeys);
        });



        return view($this->view['c_multi'], [
            'settings' => $filteredSettings,
            'bikeC_Multi_Rush_Hour' => $bikeC_Multi_Rush_Hour,
            'breadcrumbs' => $this->crums->add(__('Cài đặc giá C_Multi')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except('_token', '_method');
        $this->repository->updateMultipleRecord($data);
        return back()->with('success', __('notifySuccess'));
    }
}
