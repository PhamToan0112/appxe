
<script>
    $(document).ready(function () {
        // handle Deposit
        $('#deposit').on('click', function (event) {
            event.preventDefault();
            const walletId = $('#wallet_id').val()
            const $button = $(this);
            showLoading($button);

            const depositAmount = $('#depositAmount-hidden').val();
            $.ajax({
                url: '{{ route('admin.wallet.deposit') }}',
                type: 'POST',
                data: {
                    _token: token,
                    amount: depositAmount,
                    wallet_id: walletId
                },
                success: function (response) {
                    $('#depositModal').modal('hide');
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Nạp tiền thành công!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#depositAmount').val('');
                                fetchWalletBalance();
                            }
                        });

                    }
                },
                error: function (xhr, status, error) {
                    handleAjaxError(error)
                },
                complete: function() {
                    hideLoading($button);
                }
            });
        });

    });
</script>

