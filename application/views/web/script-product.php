<script>
    $(document).ready(function() {
        var url = '<?= base_url('ecommerce/product') ?>';

        var data = {
            'action': 'load'
        };

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
                    $('#list-product').append(data.data);
                }
            },
            error: function(xhr, status, err) {

            }
        });

        $(document).on('click', '.btnAddCart', function(e) {
            e.preventDefault();

            var data = {
                'product-id': $(this).data('productid'),
                'product-name': $(this).data('productname'),
                'product-price': $(this).data('productprice'),
                'product-qty': 1,
                'product-image': $(this).data('productimage'),
                'action': 'insert-checkout'
            };

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
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        $(document).on('click', '.btnDetail', function(e) {
            e.preventDefault();
            $data = $(this).data('productid');

            var $form = $(document.createElement('form'))
                .css({
                    display: 'none'
                })
                .attr("method", "POST")
                .attr("action", "<?= base_url('ecommerce/product_detail') ?>");

            $data = $(document.createElement('input'))
                .attr('name', 'productid')
                .val($data);

            $form.append($data);
            $("body").append($form);
            $form.submit();
        });
    });
</script>