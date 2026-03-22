<script>
    $(document).ready(function () {
        // handle withdraw
        $('#withdraw').on('click', function (event) {
            event.preventDefault();
            const walletId = $('#wallet_id').val()

            const withdrawAmount = $('#withdrawAmount-hidden').val();
            const $button = $(this);

            showLoading($button);
            $.ajax({
                url: '{{ route('admin.wallet.withdraw') }}',
                type: 'POST',
                data: {
                    _token: token,
                    amount: withdrawAmount,
                    wallet_id: walletId
                },
                success: function (response) {
                    $('#withdrawModal').modal('hide');
                    console.log(response)
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Rút tiền thành công!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#withdrawAmount').val('');
                                fetchWalletBalance();
                            }
                        });

                    }
                },
                error: function (xhr, status, error) {
                    msgWarning("Số dư không đủ để rút tiền")
                },
                complete: function() {
                    hideLoading($button, 'Xác nhận rút tiền');
                }
            });
        });

    });
</script>

