<section id="main-user">
    <div class="container bg-white mt-5 mb-5">
        <div class="card p-3 shadow">
            <div class="row">
                <input type="text" id="detail-id" value="<?= $detail['product_id']; ?>" hidden>
                <input type="text" id="detail-name" value="<?= $detail['product_name']; ?>" hidden>
                <input type="text" id="detail-price" value="<?= $detail['product_price']; ?>" hidden>
                <input type="text" id="detail-image" value="<?= $detail['product_image']; ?>" hidden>
                <div class="col-lg-5 col-md-12 text-center mb-md-4">
                    <div class=" fotoproduk1">
                        <img src="<?= base_url('assets/img/products/') . $detail['product_image'] ?>" style="max-width: 400px;">
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 mt-1">
                    <h4><?= $detail['product_name']; ?></h4>
                    <div class="card shadow-none bg-light">
                        <div class="row">
                            <div class="col p-3 ml-3">
                                <h4 class="font-weight-bold text-danger">
                                    Rp. <?= number_format($detail['product_price'], 0, ',', '.'); ?>
                                </h4>
                                <small>Garansi uang kembali jika produk tidak ori</small>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 bg-light mt-2 shadow-none">
                        <div class="row p-2">
                            <div class="col-lg-12">
                                <p class="font-weight-bold">Deskripsi</p>
                            </div>
                            <div class="col-lg-12">
                                <p class="font-weight-normal">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis alias neque minus, omnis fugit incidunt delectus officia necessitatibus placeat? Nobis minima quos dicta reiciendis dolor, distinctio nesciunt sint quaerat temporibus!
                                </p>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-lg-3 col-md-3">
                                <p class="font-weight-bold pt-1">Kuantitas</p>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <input type="number" class="form-control" id="qty-product" max="9">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <button class="btn btn-danger p-2 btnSubmit">
                                <i class="fas fa-shopping-bag mr-1"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>