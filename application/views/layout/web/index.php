<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">

    <title>DMTekno | <?= $title; ?></title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <?php if (isset($jumbotron)) {
        include 'jumbotron.php';
    } ?>

    <?php $this->load->view($content); ?>

    <?php if (isset($info)) {
        include 'info.php';
    } ?>

    <?php include 'footer.php' ?>


    <script src="<?= base_url(); ?>assets/bootstrap/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <!-- <script src="<?= base_url(); ?>assets/bootstrap/js/popper.min.js"></script> -->
    <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendors/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://kit.fontawesome.com/1a0e92cbbe.js" crossorigin="anonymous"></script>

    <?php $this->load->view($script); ?>
    <script>
        $('#logout').on('click', function() {
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
    </script>
</body>

</html>