<style>
    .nav-pills {
        background: #f3f4f7;
    }

    .nav-pills .nav-link.active {
        color: #ffffff;
        background-color: #343a40;
    }

    a {
        color: #000000;
        text-decoration: none;
        background-color: transparent;
    }

    a:hover {
        color: #000000;
    }
</style>

<section id="user-dashboard" class="mt-3 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card shadow-sm p-3" style="border-radius: 0.5rem;">
                    <div class="media">
                        <img src="<?= base_url('assets/img/users/') . $profile['user_image']; ?>" class=" mr-2 ml-2 border rounded-circle" width="60px">
                        <div class="media-body">
                            <p class="mt-2 mb-0 font-weight-bold"><?= $profile['user_full_name']; ?></p>
                            <small class="text-muted mb-0">Verified Account</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="card shadow-sm p-3" style="border-radius: 0.25rem;">
                    <ul class="nav nav-pills navtab-bg nav-justified " id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="pills-activity-tab" data-toggle="pill" href="#pills-transaksi" role="tab" aria-controls="pills-activity" aria-selected="false">
                                Transaksi
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>