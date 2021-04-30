<script>
    $(document).ready(function() {
        var url = '<?= base_url('product') ?>';

        // Load Data Product
        var TableProduct = $("#table-products").DataTable({
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
                    'data': 'product_image',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<img src="<?= base_url('assets/img/products/') ?>' + data + '">';
                        return disp;
                    }
                },
                {
                    'data': 'product_name'
                },
                {
                    'data': 'product_price',
                    render: function(data, meta, row) {
                        return 'Rp. ' + formatRupiah(data);
                    }
                },
                {
                    'data': 'category_name'
                },
                {
                    'data': 'product_stat',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-success">AKTIF</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">NON-AKTIF</span>';
                        }
                    }
                },
                {
                    'data': 'product_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        if (parseInt(row.product_stat) === 1) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white deactivate mr-1" data-id=' + data + ' title="non-aktif"><i class="fas fa-times"></i></button>';
                        } else if (parseInt(row.product_stat) === 0) {
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
        $('#AddProduct').on('click', function() {
            $('#ModalProduct').modal('show');
            $('#form-product').trigger('reset');
            $('#productModalLabel').text('Tambah Produk');
            $('.btnReset').show();
            $('#reviewImg').attr('src', '<?= base_url('assets/img/products/default-product.png'); ?>');
        });

        $('#image-product').change(function() {
            previewImage(this);
        });

        //Insert Data Product
        $('.btnSubmit').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('id-product', $('#id-product').val());
            formData.append('name-product', $('#name-product').val());
            formData.append('price-product', $('#price-product').val());
            formData.append('category-product', $('#category-product').val());
            formData.append('stat-product', $('#stat-product').val());
            if ($('#productModalLabel').text() == 'Edit Produk') {
                if ($('#image-product')[0].files[0]) {
                    formData.append('image-product', $('#image-product')[0].files[0]);
                } else {
                    var image = $('#image-product')[0].src;
                    var result = image.split('/');
                    var dataImg = result[8];
                    formData.append('image-product', dataImg);
                }
            } else if ($('#productModalLabel').text() == 'Tambah Produk') {
                formData.append('image-product', $('#image-product')[0].files[0]);
            }
            formData.append('action', 'insert');

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
                        $('#ModalProduct').modal('hide');
                        $('#form-product').trigger('reset');
                        TableProduct.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        $('.btnReset').on('click', function() {
            $('#form-product').trigger('reset');
            $('#reviewImg').attr('src', '<?= base_url('assets/img/products/default-product.png'); ?>');
        });

        //Edit Data Product
        $(document).on('click', '.btnEdit', function() {
            $('#ModalProduct').modal('show');
            $('#form-product').trigger('reset');
            $('#productModalLabel').text('Edit Produk');
            $('.btnReset').hide();

            var data = {
                'id-product': $(this).attr('data-id'),
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
                        var url = '<?= base_url('assets/img/products/') ?>' + data.data.product_image;
                        if (data.data.product_image) {
                            $('#reviewImg').attr({
                                "src": url
                            });
                            $('.file-upload-default').attr('src', '<?= base_url('assets/img/products/') ?>' + data.data.product_image);
                        } else {
                            $('#reviewImg').attr('src', '<?= base_url('assets/img/products/default-product.png'); ?>');
                            $('.file-upload-default').attr('src', '');
                        }
                        var category = new Option(data.data.category_name, data.data.product_category, false, true);
                        if (data.data.product_stat == 1) {
                            var stat = new Option("Aktif", data.data.product_stat, false, true);
                        } else {
                            var stat = new Option("non-Aktif", data.data.product_stat, false, true);
                        }
                        $('#id-product').val(data.data.product_id);
                        $('#name-product').val(data.data.product_name);
                        $('#price-product').val(data.data.product_price);
                        $('#category-product').append(category).trigger('change');
                        $('#stat-product').append(stat).trigger('change');
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Hapus Data Product
        $(document).on('click', '.btnDelete', function() {
            var data = {
                'id-product': $(this).data('id'),
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
                        TableProduct.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        //Change Status Active
        $(document).on('click', '.activate', function() {
            var data = {
                'id-product': $(this).data('id'),
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
                        TableProduct.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        // Change Status Deactive
        $(document).on('click', '.deactivate', function() {
            var data = {
                'id-product': $(this).data('id'),
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
                        TableProduct.ajax.reload();
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });


        function formatRupiah(input) {
            var reverse = input.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            return ribuan;
        }

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