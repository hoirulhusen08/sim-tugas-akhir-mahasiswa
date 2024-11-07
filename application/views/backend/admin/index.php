<!-- Meta -->
<?php $this->load->view('backend/template/meta'); ?>

<div class="wrapper">

    <!-- Loading page before display content -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?= base_url('assets/image/logo.png'); ?>" alt="Icon" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <?php $this->load->view('backend/template/navbar'); ?>

    <!-- Sidebar -->
    <?php $this->load->view('backend/template/sidebar'); ?>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Halaman <?= $title; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>"><?= $title; ?></a></li>
                            <li class="breadcrumb-item active">Index</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $users_count; ?></h3>
                                <p>Pengajuan Judul</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <a href="<?= base_url('admin/manageAllUser'); ?>" class="small-box-footer">Detail <i class="fa fa-envelope"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>4<sup style="font-size: 20px"></sup></h3>
                                <p>Total Mahasiswa</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer">Detail <i class="fa fa-users"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>7</h3>
                                <p>Total Dosen</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer">Detail <i class="fa fa-users"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>5</h3>
                                <p>Total Kelulusan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-trophy"></i>
                            </div>
                            <a href="#" class="small-box-footer">Detail <i class="fa fa-trophy"></i></a>
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