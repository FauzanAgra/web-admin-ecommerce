<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>DMTekno | <?= $title; ?></title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/core/core.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/fonts/feather-font/css/iconfont.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/demo_1/style.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
          <div class="col-md-7 col-xl-5 mx-auto">
            <div class="card shadow p-2">
              <div class="row">
                <div class="col-md-12 pl-md-0">
                  <div class="auth-form-wrapper px-4 py-5">
                    <a href="<?= base_url(); ?>" class="noble-ui-logo d-block mb-2 text-center">DM<span>Tekno</span></a>
                    <h5 class="text-muted font-weight-normal mb-4 text-center">
                      Welcome back! Log in to your account.
                    </h5>
                    <div id="message-notif">
                    </div>
                    <form class="forms-sample">
                      <div class="form-group">
                        <label for="user-login">Username</label>
                        <input type="text" class="form-control" id="user-login" placeholder="Username">
                      </div>
                      <div class="form-group">
                        <label for="password-login">Password</label>
                        <input type="password" class="form-control" id="password-login" autocomplete="current-password" placeholder="Password">
                      </div>
                      <div class="mt-3">
                        <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white" id="btnLogin">Login</button>
                      </div>
                      <a href="<?= base_url("login/registrasi"); ?>" class="d-block mt-3 text-muted">Not a user? Sign up</a>
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

  <?php $this->load->view($script); ?>
</body>

</html>