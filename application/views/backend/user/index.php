<!-- Meta -->
<?php $this->load->view('backend/template/meta'); ?>

<div class="wrapper">

    <!-- Navbar -->
    <?php $this->load->view('backend/template/navbar'); ?>

    <!-- Sidebar -->
    <?php $this->load->view('backend/template/sidebar'); ?>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $title; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('user'); ?>"><?= $title; ?></a></li>
                            <li class="breadcrumb-item active">Index</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg">
                        <!-- Form Error / FlashData -->
                        <?php if ($this->session->flashdata('swal_icon')) : ?>
                            <script>
                                Swal.fire({
                                    icon: '<?= $this->session->flashdata('swal_icon'); ?>',
                                    title: '<?= $this->session->flashdata('swal_title'); ?>',
                                    text: '<?= $this->session->flashdata('swal_text'); ?>',
                                    confirmButtonColor: "#28A745",
                                })
                            </script>
                        <?php endif; ?>
                        <!-- End Form Error / FlashData -->
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">

                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/image/profile/') . $user['image']; ?>" alt="Image">
                                </div>
                                <h3 class="profile-username text-center"><?= $user['name']; ?></h3>
                                <p class="text-muted text-center"><?= $users['role']; ?></p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right"><?= $user['email']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Terdaftar</b> <a class="float-right"><?= date('d F Y', $user['date_created']); ?></a>
                                    </li>
                                </ul>
                                <a href="<?= base_url('user/editUser'); ?>" class="btn btn-sm btn-primary btn-block"><b>Ubah Profil</b></a>
                                <a href="<?= base_url('user/changePassword'); ?>" class="btn btn-sm btn-danger btn-block"><b>Ubah Password</b></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- Footer -->
    <?php $this->load->view('backend/template/footer'); ?>

</div>


<!-- JS -->
<?php $this->load->view('backend/template/js'); ?>
</body>

</html>