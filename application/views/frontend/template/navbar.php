<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/'); ?>">
            <img src="<?= base_url('assets/image/logo.png'); ?>" width="30" height="30" class="d-inline-block align-top" alt="">
            FTIK Tugas Akhir
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#toTop">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#aboutUs">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Kontak Kami</a>
                </li>
                <?php if ($this->session->userdata('email')) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn text-white btn-login" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" width="20" src="<?= base_url('assets/image/profile/') . $user['image']; ?>">
                            <!-- Menampilkan hanya kata pertama dari nama -->
                            <?= isset($user['name']) ? (strpos($user['name'], ' ') === false ? $user['name'] : substr($user['name'], strpos($user['name'], ' ') + 1)) : ''; ?>
                        </a>

                        <div class="dropdown-menu elemen-dropdown-logged mt-2">
                            <?php if ($this->session->userdata('role_id') == 1) : ?>
                                <a class="dropdown-item" href="<?= base_url('admin'); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?= base_url('user'); ?>"><i class="bi bi-person-circle"></i> Profil Saya</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-left"></i> Keluar</a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link btn text-white btn-login" data-toggle="modal" data-target="#loginModal" href="<?= base_url('auth'); ?>"><i class="bi bi-lock-fill"></i> Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>