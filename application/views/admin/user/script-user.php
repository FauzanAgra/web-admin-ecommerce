<script>
    $(document).ready(function() {
        var url = '<?= base_url('user'); ?>';

        // Load Data User
        var TableUser = $("#table-users").DataTable({
            "processing": true,
            "serverSide": true,
            ajax: {
                url: url,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                data: function(d) {
                    d.action = 'load';
                },
                dataSrc: function(data) {
                    return data.data;
                }
            },
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": []
            }, {
                'width': 'width',
                'targets': []
            }, {
                'className': 'className',
                'targets': []
            }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                    'data': 'user_image',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<img src="<?= base_url('assets/img/users/') ?>' + data + '">';
                        return disp;
                    }
                },
                {
                    'data': 'user_full_name'
                },
                {
                    'data': 'user_name'
                },
                {
                    'data': 'user_phone',
                },
                {
                    'data': 'user_address'
                },
                {
                    'data': 'user_role',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-dark">Admin</span>';
                        } else {
                            return '<span class="badge badge-pill badge-primary">Member</span>';
                        }
                    }
                },
                {
                    'data': 'user_stat',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-success">Aktif</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">Non-Aktif</span>';
                        }
                    }
                },
                {
                    'data': 'user_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        if (parseInt(row.user_stat) === 1) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white deactivate mr-1" data-id=' + data + ' title="non-aktif"><i class="fas fa-times"></i></button>';
                        } else if (parseInt(row.user_stat) === 0) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white activate mr-1" data-id=' + data + ' title="aktif"><i class="fas fa-check"></i></button>';
                        }
                        disp += '<button type="button" class="btn btn-danger btn-icon btnDelete mr-1" data-id=' + data + '><i class="fas fa-trash-alt"></i></button>';
                        disp += '<button type="button" class="btn btn-success btn-icon btnEdit mr-1" data-id=' + data + '><i class="fas fa-pencil-alt"></i></button>';
                        return disp;
                    }
                }
            ]
        });

        //Show Modal
        $('#AddUser').on('click', function() {
            $('#ModalUser').modal('show');
            $('#form-user').trigger('reset');
            $('#userModalLabel').text('Tambah User');
            $('.btnReset').show();
            $('#reviewImg').attr('src', '<?= base_url('assets/img/users/default.png'); ?>');
            document.getElementById("password-user").disabled = false;
        });

        $('#image-user').change(function() {
            previewImage(this);
        });

        //Insert Data User
        $('.btnSubmit').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('id-user', $('#id-user').val());
            formData.append('name-full-user', $('#name-full-user').val());
            formData.append('name-user', $('#name-user').val());
            formData.append('address-user', $('#address-user').val());
            formData.append('phone-user', $('#phone-user').val());
            formData.append('role-user', $('#role-user').val());
            if ($('#userModalLabel').text() == 'Edit User') {
                if ($('#image-user')[0].files[0]) {
                    formData.append('image-user', $('#image-user')[0].files[0]);
                } else {
                    var image = $('#image-user')[0].src;
                    var result = image.split('/');
                    var dataImg = result[8];
                    formData.append('image-user', dataImg);
                }
                formData.append('action', 'insert');
            } else if ($('#userModalLabel').text() == 'Tambah User') {
                formData.append('password-user', $('#password-user').val());
                formData.append('image-user', $('#image-user')[0].files[0]);
                formData.append('action', 'insert');
            }
            // formData.append('action', 'insert');

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
                        $('#ModalUser').modal('hide');
                        $('#form-user').trigger('reset');
                        TableUser.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });


        $('.btnReset').on('click', function() {
            $('#form-product').trigger('reset');
            $('#reviewImg').attr('src', '<?= base_url('assets/img/users/default.png'); ?>');
        });

        //Edit Data User
        $(document).on('click', '.btnEdit', function() {
            $('#ModalUser').modal('show');
            $('#form-user').trigger('reset');
            $('#userModalLabel').text('Edit User');
            document.getElementById("password-user").disabled = true;
            $('.btnReset').hide();

            var data = {
                'id-user': $(this).data('id'),
                'action': 'edit'
            }

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
                        var url = '<?= base_url('assets/img/users/') ?>' + data.data.user_image;
                        if (data.data.user_image) {
                            $('#reviewImg').attr({
                                "src": url
                            });
                            $('.file-upload-default').attr('src', '<?= base_url('assets/img/users/') ?>' + data.data.user_image);
                        } else {
                            $('#reviewImg').attr('src', '<?= base_url('assets/img/users/default.png'); ?>');
                            $('.file-upload-default').attr('src', '');
                        }
                        var role = new Option(data.data.role_name, data.data.role_id, false, true);
                        $('#id-user').val(data.data.user_id);
                        $('#name-full-user').val(data.data.user_full_name);
                        $('#name-user').val(data.data.user_name);
                        $('#password-user').val(data.data.user_password);
                        $('#address-user').val(data.data.user_address);
                        $('#phone-user').val(data.data.user_phone);
                        $('#role-user').append(role).trigger('change');
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Delete Data User
        $(document).on('click', '.btnDelete', function() {
            var data = {
                'id-user': $(this).data('id'),
                'action': 'delete'
            }

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
                        TableUser.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Change Status Active
        $(document).on('click', '.activate', function() {
            var data = {
                'id-user': $(this).data('id'),
                'action': 'active'
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
                        TableUser.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Change Status Deactive
        $(document).on('click', '.deactivate', function() {
            var data = {
                'id-user': $(this).data('id'),
                'action': 'deactive'
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
                        TableUser.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#reviewImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>