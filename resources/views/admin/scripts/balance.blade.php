<script>
    <!-- Script to fetch wallet balance -->
    function fetchWalletBalance() {
        const walletId = $('#wallet_id').val()
        const fetchBalanceUrl = "{{ route('admin.wallet.balance') }}";
        $('#balance').addClass('skeleton').text('');

        $.ajax({
            url: `${fetchBalanceUrl}?wallet_id=${walletId}`,
            type: 'GET',
            success: function (response) {
                if(response.status === 200){
                    const formattedBalance = numeral(response.data.balance).format('0,0');
                    $('#balance').removeClass('skeleton').text(formattedBalance + ' VND');

                }
            },
            error: function (xhr, status, error) {
                $('#balance').removeClass('skeleton').text('Lỗi khi tải số dư');
            }
        });
    }

    $(document).ready(function () {
        fetchWalletBalance();
    });

</script>
