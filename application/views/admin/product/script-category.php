<script>
    $(document).ready(function() {
        var url = '<?= base_url('product/category') ?>';

        // Load Data Category
        var TableCategory = $("#table-categories").DataTable({
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
                    'data': 'category_name'
                },
                {
                    'data': 'category_stat',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-success">AKTIF</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">NON-AKTIF</span>';
                        }
                    }
                },
                {
                    'data': 'category_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        if (parseInt(row.category_stat) === 1) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white deactivate mr-1" data-id=' + data + ' title="non-aktif"><i class="fas fa-times"></i></button>';
                        } else if (parseInt(row.category_stat) === 0) {
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
                'id-category': $('#id-category').val(),
                'name-category': $('#name-category').val(),
                'stat-category': $('#stat-category').val(),
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
                        $('.forms-category').trigger('reset');
                        TableCategory.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Edit Data Category
        $(document).on('click', '.btnEdit', function() {
            $('#form-category').trigger('reset');

            var data = {
                'id-category': $(this).attr('data-id'),
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
                        if (data.data.category_stat == 1) {
                            var stat = new Option("Aktif", data.data.category_stat, false, true);
                        } else {
                            var stat = new Option("non-Aktif", data.data.category_stat, false, true);
                        }
                        $('#id-category').val(data.data.category_id);
                        $('#name-category').val(data.data.category_name);
                        $('#stat-category').append(stat).trigger('change');
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Hapus Data Category
        $(document).on('click', '.btnDelete', function() {
            var data = {
                'id-category': $(this).data('id'),
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
                        TableCategory.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Change Status Deactive
        $(document).on('click', '.deactivate', function() {
            var data = {
                'id-category': $(this).data('id'),
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
                        TableCategory.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Change Status Active
        $(document).on('click', '.activate', function() {
            var data = {
                'id-category': $(this).data('id'),
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
                        TableCategory.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });
    });
</script>