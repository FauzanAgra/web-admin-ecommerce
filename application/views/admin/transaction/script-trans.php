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
                [3, 'asc'],
                [4, 'desc'],
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
                            return '<span class="badge badge-pill badge-warning">Proses Upload</span>';
                        } else if (data == 2) {
                            return '<span class="badge badge-pill badge-warning">Konfirmasi</span>';
                        } else if (data == 3) {
                            return '<span class="badge badge-pill badge-warning">Proses</span>';
                        } else if (data == 4) {
                            return '<span class="badge badge-pill badge-warning">Pengiriman</span>';
                        } else if (data == 5) {
                            return '<span class="badge badge-pill badge-success">Diterima</span>';
                        } else if (data == 6) {
                            return '<span class="badge badge-pill badge-danger">Dibatalkan</span>';
                        }
                    }
                },
                {
                    'data': 'date_time'
                },
                {
                    'data': 'trans_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        var stat = parseInt(row.trans_stat);

                        if (parseInt(row.trans_stat) === 2) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white btnKonfirmasi mr-1" data-id=' + data + ' title="Konfirmasi "><i class="fas fa-file"></i></button>';
                        } else if (parseInt(row.trans_stat) === 3) {
                            disp += '<button type="button" class="btn btn-warning btn-icon text-white btnModalResi mr-1" data-id=' + data + ' title="Pengiriman"><i class="fas fa-dolly"></i></button>';
                        } else if (parseInt(row.trans_stat) === 4) {
                            disp += '<button type="button" class="btn btn-warning btn-icon cek-resi text-white  mr-1" data-id=' + data + ' title="deliver"><i class="fas fa-truck"></i></button>';
                        }
                        disp += '<button type="button" class="btn btn-primary btn-icon btnDetail mr-1" data-id=' + data + ' title="Detail"><i class="fas fa-search-plus"></i></button>';
                        if (stat === 1 || stat === 2 || stat === 3) {
                            disp += '<button type="button" class="btn btn-danger btn-icon text-white btnCancel mr-1" data-id=' + data + ' title="Batalkan"><i class="fas fa-times"></i></button>';
                        }
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
                        $('#trans-date').val(data.data.date_time + ' WIB');
                        if (stat == 1) {
                            $('#trans-stat').val('Proses Upload');
                        } else if (stat == 2) {
                            $('#trans-stat').val('Menunggu Konfirmasi');
                        } else if (stat == 3) {
                            $('#trans-stat').val('Proses');
                        } else if (stat == 4) {
                            $('#trans-stat').val('Pengiriman');
                        } else if (stat == 5) {
                            $('#trans-stat').val('Diterima');
                        } else if (stat == 6) {
                            $('#trans-stat').val('Ditolak');
                        }
                        $('#list-produk').append(data.show);
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

        $(document).on('click', '.btnCancel', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah yakin ingin membatalkan transaksi?',
                icon: 'warning',
                confirmButtonColor: '#727cf5',
                confirmButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = {
                        'trans-id': $(this).data('id'),
                        'action': 'cancel-trans'
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
                                TableTrans.ajax.reload();
                            }
                        },
                        error: function(xhr, status, err) {

                        }
                    });
                }
            })
        });

        $(document).on('click', '.btnKonfirmasi', function(e) {
            $('#modalKonfirmasi').modal('show');
            $('.viewBukti').attr("src", " ");
            var id = $(this).data('id');
            var next = false;
            if (id) {
                var data = {
                    'trans-id': $(this).data('id'),
                    'action': 'getImage'
                }
                next = true;
            }

            if (next) {
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
                            $('.viewBukti').attr("src", "<?= base_url('assets/img/invoice/') ?>" + data.data.trans_invoice);
                            $('#trans-id').val(data.data.trans_id);
                        }
                    },
                    error: function(xhr, status, err) {

                    }
                });
            }
        });

        $(document).on('click', '#btnProses', function(e) {
            e.preventDefault();

            var id = $('#trans-id').val();
            var next = false;

            if (id) {
                var data = {
                    'trans-id': id,
                    'action': 'proses-trans'
                }
                next = true;
            }

            if (next) {
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
                            TableTrans.ajax.reload();
                        }
                    },
                    error: function(xhr, status, err) {

                    }
                });
            }


        });

        $(document).on('click', '.btnModalResi', function(e) {
            e.preventDefault();
            $('#ModalInputResi').modal('show');
            $('#trans-resi-id').val($(this).data('id'));
        });

        $(document).on('click', '#btnResi', function(e) {
            e.preventDefault();
            var next = false;
            var resi = $('#trans-resi').val();
            if (resi) {
                var data = {
                    'trans-id': $('#trans-resi-id').val(),
                    'trans-stat': 4,
                    'trans-resi': resi,
                    'action': 'input-resi'
                }
                next = true;
            }

            if (next) {
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
                            $('#ModalInputResi').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.mesg,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            TableTrans.ajax.reload();
                        }
                    },
                    error: function(xhr, status, err) {

                    }
                });
            }
        });



        function formatRupiah(input) {
            var reverse = input.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            return ribuan;
        }
    });
</script>