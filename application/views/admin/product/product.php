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
                        <h4 class="card-title">Data Products</h4>
                        <button type="button" class="btn btn-primary mb-2 mr-3" data-toggle="modal" data-target="#exampleModal" id="AddProduct">Tambah Product</button>
                    </div>
                    <div class="table-responsive">
                        <table id="table-products" class="table table-striped" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
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

<!-- Modal Add / Edit -->
<div class="modal fade" id="ModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Tambah Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-product">
                    <input type="text" id="id-product" hidden>
                    <div class="form-group">
                        <label for="name-product">Nama Produk</label>
                        <input type="text" class="form-control" id="name-product" placeholder="Nama Produk">
                    </div>
                    <div class="form-group">
                        <label for="price-product">Harga</label>
                        <input type="number" class="form-control" id="price-product" placeholder="Harga Produk">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="category-product">Kategori</label>
                                <select class="form-control" id="category-product">
                                    <option selecteds>Kategori</option>
                                    <?php $number = 1; ?>
                                    <?php foreach ($category as $data) : ?>
                                        <option value="<?= $data['category_id']; ?>">
                                            <?= $data['category_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="stat-product">Status</label>
                                <select class="form-control" id="stat-product">
                                    <option selected>Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label for="image-product">Gambar</label>
                    <div class="row">
                        <div class="col-4">
                            <img src="<?= base_url('assets/img/products/default-product.png'); ?>" width="200px" class="img-thumbnail" id="reviewImg">
                        </div>
                        <div class="col-7">
                            <input type="file" name="img[]" id="image-product" class="file-upload-default">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btnReset">Reset</button>
                <button type="button" class="btn btn-primary btnSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>