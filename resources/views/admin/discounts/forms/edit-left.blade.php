@php use App\Enums\Discount\DiscountType; @endphp
<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <h2 style="text-align: center; color: red;">Sửa phiếu giảm giá</h2>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @lang('name') & Trạng thái tồn kho
                </div>
                <div class="card-body row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-ticket"></span>
                                @lang('name')</label>
                            <x-input name="code" :value="$discount->code" :required="true" :placeholder="__('name')" />
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-calendar"></span>
                                @lang('date_start')</label>
                            <x-input input type="datetime-local" name="date_start" :value="$discount->date_start" :required="true"
                                :placeholder="__('date_start')" />
                        </div>
                    </div>
                    <!-- date_end -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-calendar"></span>
                                @lang('date_end')</label>
                            <x-input name="date_end" input type="datetime-local" :value="$discount->date_end" :required="true"
                                :placeholder="__('date_end')" />
                        </div>
                    </div>

                    <!-- max_usage -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-123"></span>
                                @lang('max_usage')</label>
                            <x-input name="max_usage" :value="$discount->max_usage" :required="true" :placeholder="__('max_usage')" />
                        </div>
                    </div>
                    <!-- min_order_amount -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-report-money"></span>
                                @lang('min_order_amount')</label>
                            <x-input-price name="min_order_amount" id="min_order_amount" :value="$discount->min_order_amount"
                                :required="true" :placeholder="__('min_order_amount')" />
                        </div>
                    </div>

                    <!-- type -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <span class="ti ti-tag"></span>
                                @lang('type'):</label>
                            <x-select name="type" :required="true" id="discount_type">
                                @foreach ($types as $key => $value)
                                    <x-select-option :option="$discount->type->value" :value="$key" :title="$value" />
                                @endforeach
                            </x-select>
                        </div>
                    </div>

                    <!-- discount_value -->
                    <div class="col-12 col-md-6">
                        <div class="mb-3">

                            @if ($discount->type == DiscountType::Money)
                                <div id="discount_money">
                                    <label class="control-label">
                                        <span class="ti ti-report-money"></span>
                                        @lang('Giá trị giảm') (VND)</label>
                                    <x-input-price name="discount_value" id="discount_value" :value="$discount->discount_value"
                                        :placeholder="__('discount_ value')" />
                                </div>

                                <div id="discount_percent" class="d-none">
                                    <label class="control-label">
                                        <span class="ti ti-report-money"></span>
                                        @lang('Giá trị giảm') (%)</label>
                                    <x-input-number name="percent_value" id="percent_value" :value="$discount->percent_value"
                                        :placeholder="__('discount_value')" />
                                </div>
                            @elseif ($discount->type == DiscountType::Percent)
                                <div id="discount_money" class="d-none">
                                    <label class="control-label">
                                        <span class="ti ti-report-money"></span>
                                        @lang('Giá trị giảm') (VND)</label>
                                    <x-input-price name="discount_value" id="discount_value" :value="$discount->discount_value"
                                        :placeholder="__('discount_value')" />
                                </div>

                                <div id="discount_percent">
                                    <label class="control-label">
                                        <span class="ti ti-report-money"></span>
                                        @lang('Giá trị giảm') (%)</label>
                                    <x-input-number name="percent_value" id="percent_value" :value="$discount->percent_value"
                                        :placeholder="__('discount_value')" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- description -->
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label class="control-label">
                                <span class="ti ti-message"></span>
                                @lang('description'):</label>
                            <textarea name="description" class="form-control">{{ $discount->description }}</textarea>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label">Đối tượng thành viên</label>
                                <x-select name="user_option" id="user_option">
                                    @if (!empty($options) && is_array($options))
                                        @foreach ($options as $key => $value)
                                            <x-select-option :value="$key" :title="$value" />
                                        @endforeach
                                    @else
                                        <x-select-option :value="''" :title="'Không có tùy chọn'" />
                                    @endif
                                </x-select>
                            </div>
                        </div>



                        <!-- user -->
                        <div class="col-md-12 @if ($discount->user_option == \App\Enums\Discount\DiscountOption::One) d-block @else d-none @endif"
                            id="select_user">
                            <div class="mb-3">
                                <label class="control-label">@lang('user')</label>
                                <x-select class="select2-bs5-ajax" name="user_ids[]" id="user_id" :data-url="route('admin.search.select.customer')"
                                    multiple>
                                    @if ($discount->user_option == \App\Enums\Discount\DiscountOption::One)
                                        @foreach ($discount->users as $user)
                                            <x-select-option :option="$user->id" :value="$user->id" :title="$user->fullname . ' - ' . $user->phone" />
                                        @endforeach
                                    @endif
                                </x-select>
                                <x-link :href="route('admin.user.create')" class="mb-2">
                                    <span class="ms-1">@lang('add') mới</span>
                                </x-link>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label">Đối tượng tài xế</label>
                                <x-select name="driver_option" id="driver_option">
                                    @foreach ($options as $key => $value)
                                        <x-select-option
                                            :value="$key"
                                            :title="$value"
                                            :option="isset($discount->driver_option) ? $discount->driver_option->value : null"
                                        />
                                    @endforeach
                                </x-select>
                            </div>
                        </div>


                        <!-- driver -->
                        <div class="col-md-12 @if ($discount->driver_option == \App\Enums\Discount\DiscountOption::One) d-block @else d-none @endif "
                            id="select_driver">
                            <div class="mb-3">
                                <label class="control-label">@lang('driver')</label>
                                <x-select name="driver_ids[]" class="select2-bs5-ajax" :data-url="route('admin.search.select.driver')" id="driver_id"
                                    multiple="true">
                                    @if ($discount->driver_option == \App\Enums\Discount\DiscountOption::One)
                                        @foreach ($discount->drivers as $driver)
                                            <x-select-option :option="$driver->id" :value="$driver->id" :title="$driver->user->fullname . ' - ' . $driver->user->phone" />
                                        @endforeach
                                    @endif
                                </x-select>
                                <x-link :href="route('admin.driver.create')" class="mb-2">
                                    <span class="ms-1">@lang('add') mới</span>
                                </x-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
