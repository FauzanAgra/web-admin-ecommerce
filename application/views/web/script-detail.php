<script>
    $(document).ready(function() {
        var url = '<?= base_url('checkout') ?>';

        $('.btnSubmit').on('click', function(e) {
            e.preventDefault();
            var next = false;
            if (parseInt($('#qty-product').val()) < 9) {
                var data = {
                    'product-id': $('#detail-id').val(),
                    'product-name': $('#detail-name').val(),
                    'product-price': $('#detail-price').val(),
                    'product-image': $('#detail-image').val(),
                    'product-qty': $('#qty-product').val(),
                    'action': 'insert'
                }
                next = true;
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Maksimal pembelian 9 pcs',
                    showConfirmButton: false,
                    timer: 1000
                });
                $('#qty-product').val(' ');
                next = false;
            }

            if (next) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    beforeSend: function() {

                    },
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.mesg,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            $('#qty-product').val(' ');
                        }
                    },
                    error: function(xhr, status, err) {

                    }
                });
            }
        });
    });
</script>