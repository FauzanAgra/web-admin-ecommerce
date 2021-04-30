<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            DM<span>Tekno</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link">
                    <i class="link-icon" data-feather="clipboard"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Web Apps</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#products" role="button" aria-expanded="false" aria-controls="product">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Product</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="products">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?= base_url('product') ?>" class="nav-link">Data</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('product/category') ?>" class="nav-link">Category</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#user" role="button" aria-expanded="false" aria-controls="user">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">User</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="user">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?= base_url('user') ?>" class="nav-link">Data</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('user/role') ?>" class="nav-link">Role User</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#trans" role="button" aria-expanded="false" aria-controls="trans">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Transaction</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="trans">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?= base_url('transaction') ?>" class="nav-link">Data</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>