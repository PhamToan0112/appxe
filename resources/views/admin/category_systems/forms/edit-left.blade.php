<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">{{ __('Thông tin Dịch Vụ') }}</h2>

        </div>
        <div class="row card-body">
            <!-- name -->
            <div class="col-12">
                <div class="mb-3">
                    <i class="ti ti-file-pencil"></i>
                    <label class="control-label">{{ __('Tên Dịch Vụ') }}:</label>
                    <x-input type="text" name="name" :value="$category_system->name" :required="true"
                        placeholder="{{ __('Tên Dịch Vụ') }}" />
                </div>
            </div>

        </div>
    </div>
</div>