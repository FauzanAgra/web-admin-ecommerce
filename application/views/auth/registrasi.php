<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DMTekno | <?= $title; ?></title>

    <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/core/core.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card shadow">
                            <div class="row">
                                <div class="col-md-12 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="<?= base_url(); ?>" class="noble-ui-logo d-block mb-2 text-center">DM<span>Tekno</span></a>
                                        <h5 class="text-muted font-weight-normal mb-4 text-center">Create a free account.</h5>
                                        <form class="form-registrasi">
                                            <div class="form-group">
                                                <label for="full-name">Full Name</label>
                                                <input type="text" class="form-control" id="full-name" placeholder="Full Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" autocomplete="Username" placeholder="Username">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" autocomplete="current-password" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Number</label>
                                                <input type="number" class="form-control" id="phone" autocomplete="current-password" placeholder="Phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" placeholder="address">
                                            </div>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-primary text-white mr-2 mb-2 mb-md-0 btnRegis">Sing up</button>
                                            </div>
                                            <a href="<?= base_url('login') ?>" class="d-block mt-3 text-muted">Already a user? Sign in</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url(); ?>/assets/vendors/core/core.js"></script>
    <script src="<?= base_url(); ?>/assets/vendors/feather-icons/feather.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/template.js"></script>
    <script src="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.js"></script>
    <?php $this->load->view($script); ?>
</body>

</html>