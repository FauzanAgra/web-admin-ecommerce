<script>
    $(document).ready(function() {
        var url = '<?= base_url('transaction') ?>';

        // Load Data Transaction
        var TableTrans = $("#table-trans").DataTable({
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
                [0, 'desc']
            ],
            "columns": [{
                    'data': 'trans_number'
                },
                {
                    'data': 'user_full_name'
                },
                {
                    'data': 'trans_total',
                    render: function(data, meta, row) {
                        return 'Rp. ' + formatRupiah(data);
                    }
                },
                {
                    'data': 'trans_stat',
                    render: function(data, meta, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-primary">confirm</span>';
                        } else if (data == 2) {
                            return '<span class="badge badge-pill badge-warning">packaging</span>';
                        } else if (data == 3) {
                            return '<span class="badge badge-pill badge-info">delivery</span>';
                        } else if (data == 4) {
                            return '<span class="badge badge-pill badge-success">received</span>';
                        }
                    }
                },
                {
                    'data': 'trans_date'
                },
                {
                    'data': 'trans_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        if (parseInt(row.trans_stat) === 1) {
                            disp += '<button type="button" class="btn btn-primary btn-icon text-white confirm mr-1" data-id=' + data + ' title="confirm"><i class="fas fa-file"></i></button>';
                        } else if (parseInt(row.trans_stat) === 2) {
                            disp += '<button type="button" class="btn btn-primary btn-icon text-white delivery mr-1" data-id=' + data + ' title="packed"><i class="fas fa-dolly"></i></button>';
                        } else if (parseInt(row.trans_stat) === 3) {
                            disp += '<button type="button" class="btn btn-primary btn-icon cek-resi text-white  mr-1" data-id=' + data + ' title="deliver"><i class="fas fa-truck"></i></button>';
                        }
                        disp += '<button type="button" class="btn btn-danger btn-icon btnDetail mr-1" data-id=' + data + '><i class="fas fa-search-plus"></i></button>';
                        return disp;
                    }
                }
            ]
        });

        $(document).on('click', '.btnDetail', function(e) {
            e.preventDefault();

            $('#ModalTrans').modal('show');
            $('#form-trans').trigger('reset');
            $('#list-produk').html('');

            var data = {
                'id-trans': $(this).data('id'),
                'action': 'detail'
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
                        var stat = data.data.trans_stat;
                        $('#list-produk').html('');
                        $('#trans_number').val(data.data.trans_number);
                        $('#trans-date').val(data.data.trans_date);
                        if (stat == 1) {
                            $('#trans-stat').val('Confirm');
                        } else if (stat == 2) {
                            $('#trans-stat').val('Packaging');
                        } else if (stat == 3) {
                            $('#trans-stat').val('Delivery');
                        } else if (stat == 4) {
                            $('#trans-stat').val('Received');
                        }
                        $('#list-produk').append(data.show);
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
    });
</script>