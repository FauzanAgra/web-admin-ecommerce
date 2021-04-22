<section id="user-section">
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
                        <h4 class="card-title">Data Users</h4>
                        <button type="button" class="btn btn-primary mb-2 mr-3" data-toggle="modal" data-target="#ModalUser" id="AddUser">Tambah User</button>
                    </div>
                    <div class="table-responsive">
                        <table id="table-users" class="table table-striped" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>No Telp</th>
                                    <th>Alamat</th>
                                    <th>Role</th>
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
<div class="modal fade" id="ModalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-user">
                    <input type="text" id="id-user" hidden>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="name-full-user">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name-full-user" placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="name-user">Username</label>
                                <input type="text" class="form-control" id="name-user" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="password-user">Password</label>
                                <input type="password" class="form-control" id="password-user" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-12">
                            <div class="form-group">
                                <label for="address-user">Alamat</label>
                                <input type="text" class="form-control" id="address-user" placeholder="Alamat">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="phone-user">No Handphone</label>
                                <input type="number" class="form-control" id="phone-user" placeholder="No Handphone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">
                                <label for="role-user">Role</label>
                                <select class="form-control" id="role-user">
                                    <option selecteds>Role</option>
                                    <?php $number = 1; ?>
                                    <?php foreach ($role as $data) : ?>
                                        <option value="<?= $data['role_id']; ?>">
                                            <?= $data['role_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label for="image-user">Gambar</label>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <img src="<?= base_url('assets/img/users/default.png'); ?>" width="200px" class="img-thumbnail" id="reviewImg">
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 mt-sm-2">
                            <input type="file" name="img[]" id="image-user" class="file-upload-default">
                            <p>
                                <small>Ukuran Gambar wajib dicompress 4x4</small>
                            </p>
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