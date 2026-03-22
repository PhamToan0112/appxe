<div class="d-flex align-items-center justify-content-around">

    <x-button.cancel-confirm class="btn-icon" data-route="{{ route('admin.driver.reject', $id) }}">
        <i class="ti ti-ban"></i>
    </x-button.cancel-confirm>

    <x-button.approve-confirm class="btn-icon" data-route="{{ route('admin.driver.approve', $id) }}">
        <i class="ti ti-check"></i>
    </x-button.approve-confirm>


</div>
