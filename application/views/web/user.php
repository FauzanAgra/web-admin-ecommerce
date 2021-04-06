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
            <div class="col-lg-3 col-md-12 mb-sm-3">
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
                <div class="card shadow-sm p-3" style="border-radius: 0.5rem;">
                    <ul class="nav nav-pills navtab-bg nav-justified " id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="pills-activity-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-activity" aria-selected="false">
                                Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="pills-activity-tab" data-toggle="pill" href="#pills-transaksi" role="tab" aria-controls="pills-activity" aria-selected="false">
                                Transaksi
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-activity-tab">
                            <div class="row">
                                <div class="col-lg-5 col-md-12">
                                    <div class="card p-3 shadow-sm" style="border-radius: 0.5rem;">
                                        <img src="<?= base_url('assets/img/users/') . $profile['user_image']; ?>" id="image-profile" style="border-radius: 0.5rem; max-width: 650px;">
                                        <div class="input-group mb-3 mt-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image-user">
                                                <label class="custom-file-label" for="image-user">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Biodata Diri</h5>
                                        </div>
                                    </div>
                                    <input type="text" hidden id="id-user" value="<?= $profile['user_id']; ?>">
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="full-name-user" class="form-label">Nama</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="full-name-user" value="<?= $profile['user_full_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="name-user" class="form-label">Username</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" readonly class="form-control" id="name-user" value="<?= $profile['user_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="phone-user" class="form-label">Nomor HP</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="number" class="form-control" id="phone-user" value="<?= $profile['user_phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="address-user" class="form-label">Alamat</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="address-user" value="<?= $profile['user_address']; ?>">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary float-right btnProfile">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pills-password" role="tabpanel" aria-labelledby="pills-activity-tab">
                            <h5 class="mt-3">Ubah Password</h5>
                            <form action="" id="form-password">
                                <div class="row">
                                    <div class="col-lg-10 col-md-12">
                                        <div class="form-group row">
                                            <div class="col-lg-4 col-md-12">
                                                <label for="current-password" class="pt-2">Password Sekarang</label>
                                            </div>
                                            <div class="col-lg-7 col-md-12">
                                                <input type="password" class="form-control" id="current-password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 col-md-12">
                                                <label for="new-password" class="pt-2">Password Baru</label>
                                            </div>
                                            <div class="col-lg-7 col-md-12">
                                                <input type="password" class="form-control" id="new-password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 col-md-12">
                                                <label for="new-password-repeat" class="pt-2">Ulang Password Baru</label>
                                            </div>
                                            <div class="col-lg-7 col-md-12">
                                                <input type="password" class="form-control" id="new-password-repeat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-3">
                                        <button class="btn btn-primary btnChange">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="pills-transaksi" role="tabpanel" aria-labelledby="pills-activity-tab">
                            <h5>Daftar Transaksi</h5>
                            <div class="list-trans">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-sm p-2" style="border-radius: 1rem;">
                                            <div class="row">
                                                <div class="col-12 d-flex flex-row">
                                                    <small class="font-weight-bold border-right pr-3">
                                                        #DMT20210309000000001
                                                    </small>
                                                    <span class="badge badge-success ml-3">Success</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="media">
                                                                <img src="<?= base_url('assets/img/products/gamemax-aero-mini-case-1615537926.jpg'); ?>" class="mr-3" width="50px">
                                                                <div class="media-body">
                                                                    <h5 class="mt-0">Media heading</h5>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>