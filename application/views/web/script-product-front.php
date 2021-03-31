<script>
    $(document).ready(function() {
        var url = '<?= base_url('Ecommerce') ?>';

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
                    $('#product-main').append(data.data);
                }
            },
            error: function(xhr, status, err) {

            }
        });
    });
</script>