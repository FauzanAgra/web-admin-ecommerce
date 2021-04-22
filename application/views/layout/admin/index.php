<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title; ?> | DMTekno</title>

  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/core/core.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/fonts/feather-font/css/iconfont.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/demo_1/style.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/favicon.png" />
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">

  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body>
  <div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <?php include 'sidebar.php'; ?>
    <!-- partial -->

    <div class="page-wrapper">

      <!-- partial:partials/_navbar.html -->
      <?php include 'navbar.php'; ?>
      <!-- partial -->

      <div class="page-content">
        <?php $this->load->view($content); ?>
      </div>

      <!-- partial:partials/_footer.html -->
      <?php include 'footer.php'; ?>
      <!-- partial -->

    </div>
  </div>

  <script src="<?= base_url(); ?>/assets/vendors/core/core.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/chartjs/Chart.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/jquery.flot/jquery.flot.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/progressbar.js/progressbar.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/feather-icons/feather.min.js"></script>
  <script src="<?= base_url(); ?>/assets/js/template.js"></script>
  <script src="<?= base_url(); ?>/assets/js/dashboard.js"></script>
  <script src="<?= base_url(); ?>/assets/js/datepicker.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="<?= base_url(); ?>/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="<?= base_url(); ?>/assets/js/data-table.js"></script>
  <script src="https://kit.fontawesome.com/1a0e92cbbe.js" crossorigin="anonymous"></script>

  <?php $this->load->view($script); ?>

  <script>
    $(document).ready(function() {

      $('#btnLogout').on('click', function() {
        var data = {
          'action': 'logout'
        };

        $.ajax({
          url: '<?= base_url('login/logout'); ?>',
          data: data,
          type: 'post',
          dataType: 'json',
          cache: 'false',
          beforeSend: function() {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Logout Berhasil',
              showConfirmButton: false,
              timer: 1000
            });
          },
          success: function(data) {
            if (parseInt(data.stat) === 1) {
              window.location.href = '<?= base_url(); ?>';
            }
          },
          error: function(xhr, status, err) {

          }
        });

      });
    });
  </script>
</body>

</html>