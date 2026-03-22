<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Thông tin Đăng ký') }}</h4>
        </div>
        <div class="row card-body">
            {{-- driver  --}}
            <div class="col-md-12 col-12 mb-3">
                <label class="control-label">
                    <span class="ti ti-user"></span>
                    @lang('driver'):</label>
                <x-select class="select2-bs5-ajax" name="driver_id" id="driver_id" :data-url="route('admin.search.select.driver')">

                    <x-select-option :option="$vehicle->driver_id" :value="$vehicle->driver_id" :title="$vehicle->driver->user->fullname . ' - ' . $vehicle->driver->user->phone" />
                </x-select>
            </div>


            <div class="col-md-12 col-12 mb-3">
                <label class="control-label">
                    <span class="ti ti-car"></span>
                    {{ __('Loại dịch vụ') }}:
                </label>
                @foreach ($order_type as $value)
                    <x-input-checkbox 
                        :label="$value" 
                        :value="$value" 
                        :checked="in_array($value, old('service_type', $service_type ?? [])) ? [$value] : []" 
                        class="form-check-input" 
                        name="service_type[]" 
                    />
                @endforeach
            </div>


            {{-- vehicle_line_id  --}}
            <div class="col-md-12 col-12 mb-3">
                <label class="control-label">
                    <span class="ti ti-car"></span>
                    @lang('Dòng xe'):</label>
                <x-select class="select2-bs5-ajax" name="vehicle_line_id" id="vehicle_line_id" :data-url="route('admin.search.select.vehicleLine')"
                    :required="true">
                    <x-select-option :option="$vehicle->vehicle_line_id" :value="$vehicle->vehicle_line_id" :title="optional($vehicle->vehicleLine)->name" />
                </x-select>
            </div>

            {{-- Năm sản xuất --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-calendar"></span>
                        {{ __('Năm sản xuất') }}:</label>
                    <x-input name="production_year" :value="$vehicle->production_year" :placeholder="__('Năm sản xuất')" />
                </div>
            </div>
            {{-- Tên phương tiện --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        {{ __('Tên phương tiện') }}:</label>
                    <x-input name="name" :value="$vehicle->name ?? old('name')" :placeholder="__('Tên phương tiện')" />
                </div>
            </div>
            {{-- license_plate input --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-id"></span>
                        @lang('license_plate'):</label>
                    <x-input name="license_plate" :value="$vehicle->license_plate ?? old('license_plate')" :placeholder="__('license_plate')" />
                </div>
            </div>
            {{-- vehicle_company input --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        @lang('vehicle_company'):</label>
                    <x-input name="vehicle_company" :value="$vehicle->vehicle_company ?? old('vehicle_company')" :placeholder="__('vehicle_company')" />
                </div>
            </div>
            {{-- Màu sắc --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-palette"></span>
                        {{ __('Màu sắc') }}:</label>
                    <x-input name="color" :value="$vehicle->color ?? old('color')" :placeholder="__('Màu sắc')" />
                </div>
            </div>
            {{-- Loại xe --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        {{ __('Loại xe') }}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                            <x-select-option :option="$vehicle->type->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-wheelchair"></span>
                        {{ __('Số chỗ ngồi') }}:</label>
                    <x-input type="number" name="seat_number" :value="$vehicle->seat_number ?? old('seat_number')" :required="true"
                        placeholder="{{ __('Số chỗ ngồi') }}" />
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-palette"></span>
                        {{ __('Màu biển xe') }}:</label>
                    <x-select name="license_plate_color" :required="true">
                        @foreach ($license_plate_color as $key => $value)
                            <x-select-option :option="$vehicle->license_plate_color->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            {{-- amenities --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>
                            <span class="ti ti-settings"></span>
                            {{ __('amenities') }}:</strong></label>
                    <textarea name="amenities" class="ckeditor visually-hidden">
                    {{ $vehicle->amenities ?? old('amenities') }}
                </textarea>
                </div>
            </div>
            {{-- description --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>
                            <span class="ti ti-message"></span>
                            {{ __('description') }}:</strong></label>
                    <textarea name="description" class="ckeditor visually-hidden">
                          {{ $vehicle->description ?? old('description') }}
                </textarea>
                </div>
            </div>
            {{-- vehicle_registration_front --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_registration_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_registration_front" :value="$vehicle->vehicle_registration_front"
                            showImage="featureImageVehicleRegistrationFront" />
                    </div>
                </div>
            </div>
            {{-- vehicle_registration_back --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_registration_back')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_registration_back" :value="$vehicle->vehicle_registration_back"
                            showImage="featureImageVehicleRegistrationBack" />
                    </div>
                </div>
            </div>
            {{-- insurance_front_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('insurance_front_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="insurance_front_image" :value="old('insurance_front_image')" :value="$vehicle->insurance_front_image"
                            showImage="featureImageInsuranceFront" />
                    </div>
                </div>
            </div>
            {{-- insurance_back_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('insurance_back_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="insurance_back_image" :value="old('insurance_back_image')" :value="$vehicle->insurance_back_image"
                            showImage="featureImageInsuranceBack" />
                    </div>
                </div>
            </div>
            {{-- vehicle_front_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_front_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_front_image" :value="old('vehicle_front_image')" :value="$vehicle->vehicle_front_image"
                            showImage="featureImageVehicleFront" />
                    </div>
                </div>
            </div>
            {{-- vehicle_back_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_back_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_back_image" :value="old('vehicle_back_image')" :value="$vehicle->vehicle_back_image"
                            showImage="featureImageVehicleBack" />
                    </div>
                </div>
            </div>
            {{-- vehicle_side_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_side_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_side_image" :value="old('vehicle_side_image')" :value="$vehicle->vehicle_side_image"
                            showImage="featureImageVehicleSide" />
                    </div>
                </div>
            </div>
            {{-- vehicle_interior_image --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span>
                        @lang('vehicle_interior_image')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_interior_image" :value="old('vehicle_interior_image')" :value="$vehicle->vehicle_interior_image"
                            showImage="featureImageVehicleInterior" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
