<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save" />
                <x-link :href="route('admin.driver.route.index', $driver->id)" class="btn btn-outline w-50">
                    @lang('Quay lại')
                </x-link>
            </div>
            <x-button.modal-delete
                data-route="{{ route('admin.driver.route.delete', ['id' => $instance->id, 'driver_id' => $driver->id]) }}"
                :title="__('delete')" />
        </div>
    </div>

</div>
