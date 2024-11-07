<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Jump to Homepage -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/'); ?>">
                <i class="fas fa-globe"></i> Website
            </a>
        </li>
        <!-- Fullscreen -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" title="Fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- Profile User -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="<?= base_url('assets/image/profile/') . $user['image']; ?>" class="img-circle" width="25" alt="Image">
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right mt-2">
                <a href="<?= base_url('user'); ?>" class="dropdown-item dropdown-footer text-left"><i class="bi bi-person-circle"></i> Profil Saya</a>
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0)" class="dropdown-item dropdown-footer text-left" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-left"></i> Keluar</a>
            </div>
        </li>
    </ul>
</nav>