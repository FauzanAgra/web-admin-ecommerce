<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">

    <title>DMTekno | <?= $title; ?></title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <section id="navbar">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container">
                <a class="navbar-brand text-white" href="#">DIGITAL MEDIA TEKNOLOGI</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a href="<?= base_url('ecommerce'); ?>" class="nav-link text-white" href="#">HOME <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href=" <?= base_url('ecommerce/product_main'); ?> ">PRODUK</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('checkout'); ?>" class="nav-link text-white">CHECKOUT</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('login/logout'); ?>" class="nav-link text-white" id="logout">LOGOUT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <section id="jumbotron">
        <div class="jumbotron text-center">
            <div class="container">
                <h1 class="display-4">EXPLORE YOURSELF WITH <br> <span class="font-weight-bold"> DIGITAL MEDIA TEKNOLOGI</span></h1>
                <p class="lead">
                    Tempat Belanja Barang Elektronik Original dan Terpercaya.
                </p>
                <p class="lead">
                    <a class="btn btn-light btn-lg" href="#" role="button">Kunjungi</a>
                </p>
            </div>
        </div>
    </section>

    <section id="content">

    </section>

    <section id="info">
        <div class="bg-light p-5">
            <div class="container">
                <div class="row mx-auto">
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-backward fa-2x"></i>
                            </div>
                            <div class="col">
                                <h3>Transparan</h3>
                                <p>Pembayaran Anda baru diteruskan ke penjual setelah barang Anda terima</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-2"><i class="fas fa-shield-alt fa-2x"></i></div>
                            <div class="col">
                                <h3>100% Aman</h3>
                                <p>Bandingkan review untuk berbagai online shop terpercaya se-Indonesia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col-2"><i class="fas fa-truck fa-2x"></i></div>
                            <div class="col">
                                <h3>Gratis Ongkir</h3>
                                <p>Barang sampai di tempat Anda tanpa biaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="footer">
        <footer class="text-white p-5 bg-dark">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="col-md-5 mt-3">
                            <h4 class="font-weight-bold">DM TEKNO</h4>
                            <p>Tentang DM Tekno</p>
                            <p>Karir</p>
                            <p>Blog</p>
                            <h4 class="font-weight-bold mt-4">JUAL</h4>
                            <p>Pusat Edukasi Seller</p>
                            <p>Mitra Toppers</p>
                            <p>Daftar Official Store</p>
                        </div>
                        <div class="col-md-5 mt-3">
                            <h4 class="font-weight-bold">BELI</h4>
                            <p>Tagihan dan Top Up</p>
                            <p>Tukar Tambah</p>
                            <p>DM Tekno COD</p>
                            <h4 class="font-weight-bold mt-4">BANTUAN & PANDUAN</h4>
                            <p>DM Tekno Care</p>
                            <p>Syarat dan Ketentuan</p>
                            <p>Kebijakan Privasi</p>
                            <h4 class="font-weight-bold">PENGIRIMAN</h4>
                            <button class="btn btn-light">
                                <img src="<?= base_url() ?>assets/img/frontend/jne.png" width="50" class="mr-1" alt="">
                            </button>
                            <button class="btn btn-light">
                                <img src="<?= base_url() ?>assets/img/frontend/jnt.png" width="50" class="mr-1" alt="">
                            </button>
                            <button class="btn btn-light">
                                <img src="<?= base_url() ?>assets/img/frontend/gosend.png" width="50" class="mr-1" alt="">
                            </button>
                        </div>
                        <div class="col-md-2 mt-3">
                            <h4 class="font-weight-bold">IKUTI KAMI</h4>
                            <div class="row">
                                <p class="text-white"> <i class="fab fa-facebook-square ml-2 mr-2 fa-lg mt-2 " title="facebook"></i> Facebook</p>

                                <p class="text-white"><i class="fab fa-instagram ml-2 mr-2 fa-lg mt-2" title="instagram"></i> Instagram</p>

                                <p class="text-white"><i class="fab fa-twitter-square ml-2 mr-2 fa-lg mt-2" title="twitter"></i> Twitter</p>

                                <p class="text-white"><i class="fab fa-pinterest-square ml-2 mr-2 fa-lg mt-2" title="pinterest"></i> Pinterest</p>
                            </div>
                            <h4 class="font-weight-bold">PEMBAYARAN</h4>
                            <div class="row justify-content-center">
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/bca.png" width="50" class="mr-1" alt="">
                                </button>
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/bni.png" width="50" class="mr-1" alt="">
                                </button>
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/bri.png" width="50" class="mr-1" alt="">
                                </button>
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/mandiri.png" width="50" class="mr-1" alt="">
                                </button>
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/cimb.png" width="50" class="mr-1" alt="">
                                </button>
                                <button class="btn m-1 btn-light">
                                    <img src="<?= base_url() ?>assets/img/frontend/alfamart.png" width="50" class="mr-1" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->
    </section>


    <script src="<?= base_url(); ?>assets/bootstrap/js/jquery-3.3.1.slim.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/1a0e92cbbe.js" crossorigin="anonymous"></script>
</body>

</html>