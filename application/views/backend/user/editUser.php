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
                    <div class="col-lg-7">

                        <!-- Form Edit -->
                        <?= form_open_multipart('user/editUser'); ?>
                        <h5><a style="text-decoration: none;" href="<?= base_url('user'); ?>"><i class="bi bi-arrow-left-circle-fill"></i> <small>Kembali</small></a></h5>
                        <div class="card p-3 pt-4">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email" value="<?= $user['email']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="name" name="name" class="form-control" id="name" value="<?= $user['name']; ?>">
                                    <?= form_error('name', '<small class="text-danger pl-1">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 mb-2"><strong>Gambar</strong></div>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img id="image-preview" src="<?= base_url('assets/image/profile/') . $user['image']; ?>" class="img-thumbnail mb-3">
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="image">
                                                <label class="custom-file-label" for="image">Pilih gambar...</label>
                                                <small><i class="bi bi-info-circle"></i> Catatan : Ukuran gambar maks. 2MB & dengan format (GIF, JPG, PNG)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Ubah Profil</button>
                                </div>
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