<script>
    $(document).ready(function() {
        var url = '<?= base_url('user/role') ?>';

        // Load Data Role
        var TableRole = $("#table-roles").DataTable({
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
                    'data': 'role_name'
                },
                {
                    'data': 'role_stat',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-success">AKTIF</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">NON-AKTIF</span>';
                        }
                    }
                },
                {
                    'data': 'role_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        if (parseInt(row.role_stat) === 1) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white deactivate mr-1" data-id=' + data + ' title="non-aktif"><i class="fas fa-times"></i></button>';
                        } else if (parseInt(row.role_stat) === 0) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white activate mr-1" data-id=' + data + ' title="aktif"><i class="fas fa-check"></i></button>';
                        }
                        disp += '<button type="button" class="btn btn-danger btn-icon btnDelete mr-1" data-id=' + data + '><i class="fas fa-trash-alt"></i></button>';
                        disp += '<button type="button" class="btn btn-success btn-icon btnEdit mr-1" data-id=' + data + '><i class="fas fa-pencil-alt"></i></button>';
                        return disp;
                    }
                }
            ]
        });

        //Insert Data Product
        $('.btnSubmit').on('click', function(e) {
            e.preventDefault();

            var data = {
                'id-role': $('#id-role').val(),
                'name-role': $('#name-role').val(),
                'stat-role': $('#stat-role').val(),
                'action': 'insert'
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
                        $('.form-role').trigger('reset');
                        TableRole.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Edit Data Category
        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            $('.form-role').trigger('reset');

            var data = {
                'id-role': $(this).data('id'),
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
                        if (data.data.role_stat == 1) {
                            var stat = new Option("Aktif", data.data.role_stat, false, true);
                        } else {
                            var stat = new Option("non-Aktif", data.data.role_stat, false, true);
                        }
                        $('#id-role').val(data.data.role_id);
                        $('#name-role').val(data.data.role_name);
                        $('#stat-role').append(stat).trigger('change');
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Hapus Data Category
        $(document).on('click', '.btnDelete', function(e) {
            e.preventDefault();
            var data = {
                'id-role': $(this).data('id'),
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
                        TableRole.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Change Status Deactive
        $(document).on('click', '.deactivate', function(e) {
            e.preventDefault();
            var data = {
                'id-role': $(this).data('id'),
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
                        TableRole.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Change Status Active
        $(document).on('click', '.activate', function(e) {
            e.preventDefault();
            var data = {
                'id-role': $(this).data('id'),
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
                        TableRole.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });
    });
</script>