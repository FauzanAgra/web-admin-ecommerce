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
                    $('.list-trans').append(' ');
                    $('.list-trans').append(data.data);
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

        function loadHtml(data) {
            var output = '';
            output += '<div class="row mb-2">\n\
                                    <div class="col-12">\n\
                                        <div class="card shadow-sm p-3" style="border-radius: 1rem;">\n\
                                            <div class="row mb-4">\n\
                                                <div class="col-12 d-flex flex-row">';
            $output += '<small class="font-weight-bold border-right pr-3">' + data.trans_number + '</small>';
            if (parseInt(data.trans_stat) == 1) {
                $output += '<span class="badge badge-primary ml-3">Pembayaran</span>';
            } else if (parseInt(data.trans_stat) == 2) {
                $output += '<span class="badge badge-warning ml-3">Pengemasan</span>';
            } else if (parseInt(data.trans_stat) == 3) {
                $output += '<span class="badge badge-info ml-3">Pengiriman</span>';
            } else if (parseInt(data.trans_stat) == 4) {
                $output += '<span class="badge badge-success ml-3">Diterima</span>';
            }
            $output += '</div></div><div class="row mb-2"><div class="col-12"><div class="row"><div class="col-lg-9 col-sm-8 col-md-8 border-right m-0"><div class="media">';
            $output += '<img src="<?= base_url('assets/img/products/'); ?>' + data.product_image + '" class="mr-3 img-thumbnail" style="max-width: 80px;">';
        }

    });
</script>