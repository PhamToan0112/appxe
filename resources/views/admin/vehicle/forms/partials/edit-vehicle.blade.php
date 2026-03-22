<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Phương tiện') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- license_plate --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('license_plate'):</label>
                    <x-input name="license_plate"
                             :value="$vehicle->license_plate"
                             :placeholder="__('license_plate')"/>
                </div>
            </div>
            {{-- vehicle_company --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('vehicle_company'):</label>
                    <x-input name="vehicle_company"
                             :value="$vehicle->vehicle_company"
                             :placeholder="__('vehicle_company')"/>
                </div>
            </div>
            {{-- Tên phương tiện --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tên phương tiện') }}:</label>
                    <x-input name="name"
                             :value="$vehicle->name"
                             :required="true"
                             placeholder="{{ __('Tên phương tiện') }}"/>
                </div>
            </div>
            {{-- Màu sắc --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Màu sắc')}}:</label>
                    <x-input name="color"
                             :required="true"
                             :value="$vehicle->color"
                             placeholder="{{__('Màu sắc')}}"/>
                </div>
            </div>
            {{-- Loại xe --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Loại xe')}}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                            <x-select-option :value="$key" :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            {{-- Số chổ ngồi --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Số chổ ngồi') }}:</label>
                    <x-input type="number" name="seat_number"
                             :value="$vehicle->seat_number"
                             :required="true"
                             placeholder="{{ __('Số chổ ngồi') }}"/>
                </div>
            </div>
            {{-- Giá thuê --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('price_rent') }}:</label>
                    <x-input-price name="price"
                                   id="price"
                                   :value="$vehicle->price"
                                   :required="true"
                                   :placeholder="__('price_rent')"/>
                </div>
            </div>
            {{-- amenities --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('amenities') }}:</strong></label>
                    <textarea name="amenities"
                              class="ckeditor visually-hidden">
                        {{$vehicle->amenities }}
                    </textarea>
                </div>
            </div>
            {{-- description --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('description') }}:</strong></label>
                    <textarea name="description"
                              class="ckeditor visually-hidden">
                        {{$vehicle->description }}

                    </textarea>
                </div>
            </div>
            {{-- vehicle_registration_front --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_registration_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="vehicle_registration_front"
                            :value="$vehicle->vehicle_registration_front"
                            showImage="featureImageVehicleRegistrationFront"/>
                    </div>
                </div>
            </div>
            {{-- vehicle_registration_back --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_registration_back')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="vehicle_registration_back"
                            :value="$vehicle->vehicle_registration_back"
                            showImage="featureImageVehicleRegistrationBack"/>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('driver_license_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="driver_license_front"
                            :value="$vehicle->vehicle_owner->driver_license_front"
                            showImage="featureImageDriverLicenseFront"
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('driver_license_back')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="driver_license_back"
                            :value="$vehicle->vehicle_owner->driver_license_back"
                            showImage="featureImageDriverLicenseBack"
                        />
                    </div>
                </div>
            </div> --}}
            {{-- insurance_front_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('insurance_front_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="insurance_front_image" :value="old('insurance_front_image')"
                        :value="$vehicle->insurance_front_image"
                        showImage="featureImageInsuranceFront"/>
                    </div>
                </div>
            </div>
            {{-- insurance_back_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('insurance_back_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="insurance_back_image" :value="old('insurance_back_image')"
                        :value="$vehicle->insurance_back_image"
                        showImage="featureImageInsuranceBack"/>
                    </div>
                </div>
            </div>
            {{-- vehicle_front_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_front_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_front_image" :value="old('vehicle_front_image')"
                        :value="$vehicle->vehicle_front_image"
                        showImage="featureImageVehicleFront"/>
                    </div>
                </div>
            </div>
            {{-- vehicle_back_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_back_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_back_image" :value="old('vehicle_back_image')"
                        :value="$vehicle->vehicle_back_image"
                        showImage="featureImageVehicleBack"/>
                    </div>
                </div>
            </div>
            {{-- vehicle_side_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_side_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_side_image" :value="old('vehicle_side_image')"
                        :value="$vehicle->vehicle_side_image"
                        showImage="featureImageVehicleSide"/>
                    </div>
                </div>
            </div>
            {{-- vehicle_interior_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('vehicle_interior_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_interior_image" :value="old('vehicle_interior_image')"
                        :value="$vehicle->vehicle_interior_image"
                        showImage="featureImageVehicleInterior"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
