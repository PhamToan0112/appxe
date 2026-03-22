<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Mã Code -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-brand-codesandbox"></i>
                    <label class="control-label">@lang('code')</label>
                    <x-input 
                        name="code"
                        :value="$transaction->code" 
                        :required="true" 
                        :placeholder="__('code')"
                        disabled 
                    />
                </div>
            </div>
            <!-- Ngày Tạo -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-calendar"></i>
                    <label class="control-label">@lang('created_at')</label>
                    <x-input 
                        name="created_at" 
                        :value="$transaction->created_at" :required="true" :placeholder="__('created_at')" 
                        type="datetime-local"
                        disabled
                    />
                </div>
            </div>
            <!-- Số tiền -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-coins"></i> 
                    <label class="control-label">@lang('amount')</label>
                    <x-input name="amount" :value="($transaction->amount)" :placeholder="__('amount')" disabled/>
                </div>
            </div>
            
            <!-- Người thực hiện -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-user-cog"></i>
                    <label class="control-label">@lang('fullname')</label>
                    <x-input name="user_id" :value="$user->fullname" :placeholder="__('fullname')" disabled/>
                </div>
            </div>         

        </div>
    </div>
</div>
