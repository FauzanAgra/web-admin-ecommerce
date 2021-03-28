<script>
    $(document).ready(function() {
        var url = '<?= base_url('login/registrasi'); ?>';

        $('.btnRegis').on('click', function(e) {
            e.preventDefault();
            var data = {
                'full-name-user': $('#full-name').val(),
                'name-user': $('#username').val(),
                'password-user': $('#password').val(),
                'phone-user': $('#phone').val(),
                'address-user': $('#address').val(),
                'action': 'regis'
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
                        $('.form-registrasi')[0].reset();
                        window.location.href = '<?= base_url() ?>';
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

    });
</script>