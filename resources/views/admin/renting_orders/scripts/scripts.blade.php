<script>
    let diffDays = 1;
    let vehiclePrice;
    let totalPrice;
    let vehicleId;
    $(document).on('click', '#confirm-order', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: "Bạn có chắc chắn muốn duyệt đơn này?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn!",
            cancelButtonText: "Quay lại!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    $(document).on('click', '#cancel-order', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: "Bạn có chắc chắn muốn từ chối đơn này?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn!",
            cancelButtonText: "Quay lại!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
    $(document).ready(function(e){
        select2LoadData($('#user_id').data('url'), '#user_id');
        select2LoadData($('#vehicle_id').data('url'), '#vehicle_id');
        vehicleId = $('#vehicle_id').val();
            if (vehicleId) {
                $.ajax({
                    url: '{{ route('admin.vehicle.show') }}' + '/' + vehicleId, // Thay thế bằng URL API của bạn
                    type: 'GET',
                    success: function(response) {
                        vehiclePrice = response.data.price;
                        totalPrice = vehiclePrice * diffDays;
                        $('#total').val(totalPrice);
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi lấy thông tin phương tiện:', error);
                    }
                });
            }
    });

    $('#vehicle_id').on('change', function() {
            var vehicleId = $(this).val();
            if (vehicleId) {
                $.ajax({
                    url: '{{ route('admin.vehicle.show') }}' + '/' + vehicleId, // Thay thế bằng URL API của bạn
                    type: 'GET',
                    success: function(response) {
                        vehiclePrice = response.data.price;
                        totalPrice = vehiclePrice * diffDays;
                        $('#total').val(totalPrice);
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi lấy thông tin phương tiện:', error);
                    }
                });
            }
    });

    function dateDiff() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var today = new Date().toISOString().split('T')[0]; // Lấy ngày hiện tại
            console.log('123');

            if(!vehiclePrice){
                Swal.fire({
                    title: "Vui lòng chọn phương tiện trước",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                })
                $('#start_date').val('');
                return;
            }
            if(startDate && endDate){
                if (startDate < today) {
                    Swal.fire({
                        title: "Ngày bắt đầu không được nhỏ hơn ngày hiện tại.",
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    })
                    $('#start_date').val('');
                    return;
                }
                if (startDate > endDate) {
                    Swal.fire({
                        title: "Ngày bắt đầu không được lớn hơn ngày kết thúc.",
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    })
                    $('#start_date').val('');
                    return;
                }
            }

            var start = new Date(startDate);
            var end = new Date(endDate);
            var diffTime = Math.abs(end - start);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Nếu hai ngày bằng nhau, diffDays là 1
            if (startDate === endDate) {
                diffDays = 1;
            }

            totalPrice = vehiclePrice * diffDays;
            $('#total').val(totalPrice);
        }

        $('#start_date, #end_date').on('blur', dateDiff);

</script>
