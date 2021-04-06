<script>
    $(document).ready(function() {
        var url = '<?= base_url('dashboard_user') ?>';

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //Load Transaksi User
        var data = {
            'id-user': $('#id-user').val(),
            'action': 'load-trans'
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

                }
            },
            error: function(xhr, status, err) {

            }
        });

        $('.btnProfile').on('click', function() {
            var formData = new FormData();
            formData.append('id-user', $('#id-user').val());
            formData.append('name-full-user', $('#full-name-user').val());
            formData.append('name-user', $('#name-user').val());
            formData.append('phone-user', $('#phone-user').val());
            formData.append('address-user', $('#address-user').val());
            if ($('#image-user')[0].files[0]) {
                formData.append('image-user', $('#image-user')[0].files[0]);
            } else {
                var image = $('#image-profile')[0].src;
                var result = image.split('/');
                var dataImg = result[8];
                formData.append('image-user', dataImg);
            }
            formData.append('action', 'update-user');

            $.ajax({
                url: url,
                data: formData,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                contentType: false,
                processData: false,
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
                        window.location.href = '<?= base_url('dashboard_user') ?>';
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        $('.btnChange').on('click', function(e) {
            e.preventDefault();

            var data = {
                'id-user': $('#id-user').val(),
                'current-password': $('#current-password').val(),
                'new-password': $('#new-password').val(),
                'new-password-repeat': $('#new-password-repeat').val(),
                'action': 'change-password'
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
                        $('#form-password').trigger('reset');
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
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

    });
</script>