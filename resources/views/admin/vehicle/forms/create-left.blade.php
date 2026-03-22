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
                </x-select>
            </div>

            {{-- service_type --}}

            <div class="col-md-12 col-12 mb-3">
                <label class="control-label">
                    <span class="ti ti-car"></span>
                    {{ __('Loại dịch vụ') }}:
                </label>
                @foreach ($order_type as $value)
                    <x-input-checkbox 
                        :label="$value" 
                        :value="$value" 
                        :checked="old('service_type', $service_type ?? [])" 
                        class="form-check-input" 
                        name="service_type[]" 
                        id="service_type_{{ $value }}"
                    />
                @endforeach
            </div>

            {{-- name vehicle  --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        @lang('name_vehicle'):</label>
                    <x-input name="name" :required="true" :value="old('name')" :placeholder="__('name_vehicle')" />
                </div>
            </div>

            {{-- production_year  --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-calendar"></span>
                        @lang('Năm sản xuất'):</label>
                    <x-input type="number" name="production_year" :value="old('production_year')" :placeholder="__('Năm sản xuất')" />
                </div>
            </div>
            {{-- vehicle_line_id --}}
            <div class="col-md-12 col-12 mb-3">
                <label class="control-label">
                    <span class="ti ti-car"></span>
                    @lang('Dòng xe'):</label>
                <x-select class="select2-bs5-ajax" name="vehicle_line_id" id="vehicle_line_id" :data-url="route('admin.search.select.vehicleLine')"
                    :required="true">
                    @foreach ($vehicle_line as $line)
                        <x-select-option :option="$line->name" :value="$line->id" :title="$line->name" />
                    @endforeach
                </x-select>
            </div>
            
            {{-- license_plate  --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-id"></span>
                        @lang('license_plate'):</label>
                    <x-input name="license_plate" :value="old('license_plate')" :placeholder="__('license_plate')" />
                </div>
            </div>
            {{-- vehicle_company --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        @lang('vehicle_company'):</label>
                    <x-input name="vehicle_company" :value="old('vehicle_company')" :placeholder="__('vehicle_company')" />
                </div>
            </div>
            <!-- color -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-palette"></span>
                        {{ __('Màu sắc') }}:</label>
                    <x-input name="color" :value="old('color')" :required="true" placeholder="{{ __('Màu sắc') }}" />
                </div>
            </div>
            <!-- type -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-car"></span>
                        {{ __('Loại xe') }}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                            <x-select-option :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- seat_number -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-wheelchair"></span>
                        {{ __('Số chổ ngồi') }}:</label>
                    <x-input type="number" name="seat_number" :value="old('seat_number')" :required="true"
                        placeholder="{{ __('Số chổ ngồi') }}" />
                </div>

            </div>

            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">
                        <span class="ti ti-palette"></span>
                        {{ __('Màu biển xe') }}:</label>
                    <x-select name="license_plate_color" :required="true">
                        @foreach ($license_plate_color as $key => $value)
                            <x-select-option :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>


            {{-- amenities --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>
                            <span class="ti ti-settings"></span>
                            {{ __('amenities') }}:</strong>
                    </label>
                    <textarea name="amenities" class="ckeditor visually-hidden">
                    {{ old('amenities') }}
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
                      {{ old('description') }}
                </textarea>
                </div>
            </div>
            {{-- vehicle_registration_front --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="ti ti-id"></span> @lang('vehicle_registration_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="vehicle_registration_front" :value="old('vehicle_registration_front')"
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
                        <x-input-image-ckfinder name="vehicle_registration_back" :value="old('vehicle_registration_back')"
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
                        <x-input-image-ckfinder name="insurance_front_image" :value="old('insurance_front_image')"
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
                        <x-input-image-ckfinder name="insurance_back_image" :value="old('insurance_back_image')"
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
                        <x-input-image-ckfinder name="vehicle_front_image" :value="old('vehicle_front_image')"
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
                        <x-input-image-ckfinder name="vehicle_back_image" :value="old('vehicle_back_image')"
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
                        <x-input-image-ckfinder name="vehicle_side_image" :value="old('vehicle_side_image')"
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
                        <x-input-image-ckfinder name="vehicle_interior_image" :value="old('vehicle_interior_image')"
                            showImage="featureImageVehicleInterior" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
