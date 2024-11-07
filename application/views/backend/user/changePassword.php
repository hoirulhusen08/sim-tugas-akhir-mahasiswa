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
                            <li class="breadcrumb-item"><a href="<?= base_url('user'); ?>">Profil Saya</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
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
                    <div class="col-lg-6">

                        <form method="post" action="<?= base_url('user/changePassword') ?>">
                            <h5><a style="text-decoration: none;" href="<?= base_url('user'); ?>"><i class="bi bi-arrow-left-circle-fill"></i> <small>Kembali</small></a></h5>
                            <div class="card p-3 pt-4">
                                <div class="form-group">
                                    <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Password saat ini...">
                                    <?= form_error('current_password', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password1" class="form-control" id="new_password1" placeholder="Password baru...">
                                    <?= form_error('new_password1', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password2" class="form-control" id="new_password2" placeholder="Ulangi password baru...">
                                    <?= form_error('new_password2', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Ubah Password</button>
                                </div>
                            </div>
                        </form>

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

<!-- File Upload General -->
<script>
    // Preview gambar dan nama file saat browse
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);

        // Menampilkan pratinjau gambar
        if (this.files && this.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

</body>

</html>