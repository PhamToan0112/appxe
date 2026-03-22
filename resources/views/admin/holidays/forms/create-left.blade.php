<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h2>Thêm ngày lễ </h2>
        </div>
        <div class="card-body row">
            <!-- name  -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-calendar-event"></i>
                    <label class="control-label">@lang('Tên ngày lễ')</label>
                    <x-input name="name" :value="old('name')" :required="true" :placeholder="__('name')" />
                </div>
            </div>
            <!-- date -->
            <div class="col-6">
                <div class="mb-3">
                    <i class="ti ti-calendar-time"></i>
                    <label class="control-label">@lang('Ngày lễ')</label>
                    <x-input input type="date" name="date" :value="old('date')" :required="true"
                        :placeholder="__('date')" />
                </div>
            </div>
        </div>
    </div>
</div>
