<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">

            <!-- min_weight -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('min_weight')</label>
                    <x-input-number name="min_weight"
                                    :value="$instance->min_weight"
                                    :required="true"
                                    :placeholder="__('min_weight')"/>
                </div>
            </div>

            <!-- max_weight -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('max_weight')</label>
                    <x-input-number name="max_weight"
                                    :value="$instance->max_weight"
                                    :required="true"
                                    :placeholder="__('max_weight')"/>
                </div>
            </div>
        </div>
    </div>
</div>
