<x-input type="hidden" name="route_search_select_user" :value="route('admin.search.select.user')" />
<script>
    $(document).ready(function(e) {
        try {
            select2LoadData($('input[name="route_search_select_user"]').val());
            select2LoadData($('#area_id').data('url'), '#area_id');
            select2LoadData($('#driver_id').data('url'), '#driver_id');
            select2LoadData($('#vehicle_line_id').data('url'), '#vehicle_line_id');

            $('#vehicle_line_id').on('select2:select', function() {
                toggleServiceTypes();
            });

            function toggleServiceTypes() {
                const selectedText = $('#vehicle_line_id').find(':selected').text();
                $('.form-check').each(function() {
                    const checkbox = $(this).find('input[type="checkbox"]');
                    const serviceType = checkbox.val();

                    if (selectedText === 'Xe mini') {
                        if (serviceType === 'C_RIDE' || serviceType === 'C_CAR') {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    } else {
                        $(this).show();
                    }
                });
            }

            toggleServiceTypes();
        } catch (error) {
            if (error.message.includes('setPosition')) {
                window.location.reload();
            } else {
               handleAjaxError(error);
            }
        }
    });
</script>
