<section id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="<?= base_url(); ?>">DMTekno</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a href="<?= base_url(); ?>" class="nav-link text-white">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href=" <?= base_url('ecommerce/product'); ?> ">PRODUK</a>
                    </li>
                    <?php if ($profile) : ?>
                        <li class="nav-item">
                            <a href="<?= base_url('checkout'); ?>" class="nav-link text-white">CHECKOUT</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard_user'); ?>" class="nav-link text-white" id="profile" data-id="<?= $profile['user_id'] ?>"><?= strtoupper($profile['user_full_name']) ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('login/logout'); ?>" class="nav-link text-white" id="logout">LOGOUT</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="<?= base_url('login'); ?>" class="nav-link text-white">LOGIN</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</section>