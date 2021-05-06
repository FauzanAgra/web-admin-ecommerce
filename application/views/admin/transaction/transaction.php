<section id="product-section">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0"><?= $title; ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <h4 class="card-title">Data Transaksi</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="table-trans" class="table table-striped" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Member</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal Detail -->
<div class="modal fade" id="ModalTrans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-trans">
                    <input type="text" id="id-trans" hidden>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="trans_number">Kode Transaksi</label>
                                <input type="text" class="form-control" id="trans_number" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="datetime" class="form-control" id="trans-date" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="date">Status</label>
                                <input type="text" class="form-control" id="trans-stat" disabled>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row" id="list-produk">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmasion -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Konfirmasi Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-confirm-upload">
                    <input type="text" id="trans-id" hidden>
                    <div class="row">
                        <div class="col-12">
                            <img src="" alt="Kosong" class="img-thumbnail viewBukti">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btnProses">Proses</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Resi -->

<div class="modal fade" id="ModalInputResi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resiModalLabel">Input Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-resi">
                    <input type="text" id="trans-resi-id" hidden>
                    <div class="form-group">
                        <label for="resi">Resi</label>
                        <input type="text" class="form-control" name="resi" id="trans-resi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnResi">Submit</button>
            </div>
        </div>
    </div>
</div>