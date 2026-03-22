@php use App\Enums\Notification\MessageType; @endphp

<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <div class="card-title fw-bold">
                @if ($notification->driver_id)
                    Tài xế
                    <x-link :href="route('admin.driver.edit', $notification->driver_id)" :title="$notification->driver->user->fullname" class="text-decoration-underline" />
                @elseif($notification->user_id)
                    Khách hàng
                    <x-link :href="route('admin.user.edit', $notification->user_id)" :title="$notification->user->fullname" class="text-decoration-underline" />
                @endif
            </div>
        </div>
        <div class="row card-body">
            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-bell-ringing"></i>
                    <label class="control-label">@lang('title')</label>
                    <x-input :value="$notification->title" name="title" :required="true" :placeholder="__('title')" />
                </div>
            </div>
            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-chart-bubble"></i>
                    <label class="control-label">@lang('message')</label>
                    <x-input :value="$notification->message" name="message" :required="true" :placeholder="__('message')" />
                </div>
            </div>

            @if ($notification->type === MessageType::WITHDRAW)
                <!-- amount -->
                <div class="col-12">
                    <div class="mb-3">
                        <label class="control-label">@lang('amount')</label>
                        <x-input-price :value="$notification->amount" name="amount" id="amount" :required="true"
                            :placeholder="__('amount')" />
                    </div>
                </div>

                <!-- bank -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="control-label">@lang('bank')</label>
                    <x-select name="bank_id" :required="true">
                        <x-select-option value="" :title="__('choose')" :selected="!optional($notification->bank)->id" />
                        @foreach ($banks as $bank)
                            <x-select-option :value="$bank->id" :title="__($bank->name)" :selected="$bank->id == optional($notification->bank)->id" />
                        @endforeach
                    </x-select>
                </div>

                <!-- bank_account_number -->
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="control-label">@lang('bank_account_number')</label>
                        <x-input :value="$notification->bank_account_number" name="bank_account_number" :required="true" :placeholder="__('bank_account_number')" />
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
