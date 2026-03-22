<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h3>Ngày lễ</h3>
        </div>
        <div class="row card-body">
            <div class="col-6">
                <i class="ti ti-calendar-event"></i>
                <label class="control-label">@lang('Tên ngày lễ')</label>
                <x-input name="name" :value="$holiday->name" :required="true" :placeholder="__('name')" />
            </div>

            <div class="col-6">
                <i class="ti ti-calendar-time"></i>
                <label class="control-label">@lang('Ngày lễ')</label>
                <x-input input type="date" name="date" :value="$holiday->date" :required="true"
                :placeholder="__('date')" />
            </div>
        </div>
    </div>
</div>
