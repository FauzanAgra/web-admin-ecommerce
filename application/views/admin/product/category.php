<section id="category-section">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0"><?= $title; ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <h4 class="card-title">Data Kategori</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="table-categories" class="table table-striped" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Nama Kategori</th>
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
        <div class="col-12 col-xl-5 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Kategori</h6>
                    <form class="forms-category">
                        <input type="text" id="id-category" hidden>
                        <div class="form-group">
                            <label for="name-category">Kategori</label>
                            <input type="text" class="form-control" id="name-category" autocomplete="off" placeholder="Kategori">
                        </div>
                        <div class="form-group">
                            <label for="stat-category">Status</label>
                            <select class="form-control" id="stat-category">
                                <option selected>Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">non-Aktif</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary mr-2 btnSubmit">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>