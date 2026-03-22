<script>
    $(document).ready(function() {
        select2LoadData($('#user_id').data('url'), '#user_id');
        select2LoadData($('#driver_id').data('url'), '#driver_id');

        $('#discount_type').on('change', function() {
            if ($(this).val() == 1) {
                $('#discount_money').removeClass('d-none');
                $('#discount_percent').addClass('d-none');
                $('#percent_value').val('');
            } else {
                $('#discount_money').addClass('d-none');
                $('#discount_percent').removeClass('d-none');
                $('#discount_value').val('');
            }
        });


        $('#user_option').on('change', function() {
            if ($(this).val() == 1) {
                $('#select_user').addClass('d-none');
            } else if ($(this).val() == 2) {
                $('#select_user').removeClass('d-none');
            } else if ($(this).val() == 0) {
                $('#select_user').addClass('d-none');
            }
        });

        $('#driver_option').on('change', function() {
            if ($(this).val() == 1) {
                $('#select_driver').addClass('d-none');
            } else if ($(this).val() == 2) {
                $('#select_driver').removeClass('d-none');
            } else if ($(this).val() == 0) {
                $('#select_driver').addClass('d-none');
            }
        });
    });
</script>
