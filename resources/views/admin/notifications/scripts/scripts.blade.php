<script>
    $(document).ready(function() {
        select2LoadData($('#user_id').data('url'), '#user_id');
        select2LoadData($('#driver_id').data('url'), '#driver_id');
        let selectedValue = null;
        $('.notification-type').change(function() {
            selectedValue = $(this).val();
            $('#notification-driver-select').hide();
            $('#notification-customer-select').hide();
            $('#notification-option-select').hide();

            if (selectedValue == {{ \App\Enums\Notification\NotificationType::Driver }}) {
                $('#notification-option-select').show();
                if($('.notification-option-select-value').val() != {{ \App\Enums\Notification\NotificationOption::All }}){
                    $('#notification-driver-select').show();
                }

            }  else if (selectedValue == {{ \App\Enums\Notification\NotificationType::Customer }}) {
                $('#notification-option-select').show();
                if($('.notification-option-select-value').val() != {{ \App\Enums\Notification\NotificationOption::All }}){
                    $('#notification-customer-select').show();
                }
            }
        });
        $('.notification-option-select-value').change(function() {
            const selectedOption = $(this).val();
            $('#notification-driver-select').hide();
            $('#notification-customer-select').hide();

            if (selectedOption == {{ \App\Enums\Notification\NotificationOption::One }}) {
                if(selectedValue == {{ \App\Enums\Notification\NotificationType::Driver }}){
                    $('#notification-driver-select').show();
                }
                else if(selectedValue == {{ \App\Enums\Notification\NotificationType::Customer }}){
                    $('#notification-customer-select').show();
                }
            }
        });
    });
</script>
