<!-- Meta -->
<?php $this->load->view('backend/template/meta'); ?>

<div class="wrapper">

    <!-- Navbar -->
    <?php $this->load->view('backend/template/navbar'); ?>

    <!-- Sidebar -->
    <?php $this->load->view('backend/template/sidebar'); ?>

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?= $title; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/manageAllUser'); ?>"><?= $title; ?></a></li>
                            <li class="breadcrumb-item active">Index</li>
                        </ol>
                    </div>
                </div>

                <!-- Form Error / FlashData -->
                <?php if (validation_errors()) : ?>
                    <div class="alert my-alert-danger alert-dismissible fade show text-center" role="alert">
                        <strong>Upss...</strong> ada kesalahan saat input data!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('validation_errors')) : ?>
                    <div class="alert my-alert-danger alert-dismissible fade show text-center" role="alert">
                        <?= $this->session->flashdata('validation_errors'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

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
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="#" class="btn my-btn-custom" data-toggle="modal" data-target="#addNewUser"><i class="fas fa-solid fa-plus"></i> Daftarkan Pengguna Baru</a>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Gambar</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Peran</th>
                                                <th>Didaftarkan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($users as $user) : ?>
                                                <tr>
                                                    <td><?= $i++ . "."; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('assets/image/profile/') . $user['image']; ?>" data-lightbox="roadtrip" data-title="Photo <?= $user['name']; ?>">
                                                            <img width="50" src="<?= base_url('assets/image/profile/') . $user['image']; ?>">
                                                        </a>
                                                    </td>
                                                    <td><?= $user['name']; ?></td>
                                                    <td>
                                                        <?php if (!empty($user['email'])) : ?>
                                                            <a href="mailto:<?= $user['email']; ?>"><?= $user['email']; ?></a>
                                                        <?php else : ?>
                                                            <small><i class="bi bi-exclamation-triangle-fill"></i> Pengguna belum membuat akun!</small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['role'] == $_ENV['APP_ROLE_NAME_1'] || $user['role'] == "Admin") : ?>
                                                            <span class="badge badge-success"><?= $user['role']; ?></span>
                                                        <?php elseif ($user['role'] == $_ENV['APP_ROLE_NAME_2']) : ?>
                                                            <span class="badge badge-primary"><?= $user['role']; ?></span>
                                                        <?php elseif ($user['role'] == $_ENV['APP_ROLE_NAME_3']) : ?>
                                                            <span class="badge badge-danger"><?= $user['role']; ?></span>
                                                        <?php else : ?>
                                                            <span class="badge badge-secondary"><?= $user['role']; ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= date('d F Y', $user['date_created']); ?></td>
                                                    <td>
                                                        <?php if ($user['is_active'] == 1) : ?>
                                                            <span class="badge badge-success"><i class="bi bi-check-circle-fill"></i> On</span>
                                                        <?php elseif ($user['is_active'] == 0) : ?>
                                                            <span class="badge badge-danger"><i class="bi bi-x-circle-fill"></i> Off</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-success mb-1" title="Lihat detail pengguna"><i class="bi bi-eye"></i> Detail</a>

                                                        <a href="#" class="btn btn-sm btn-primary mb-1" title="Ubah data pengguna" data-toggle="modal" data-target="#editGeneralUser<?= $user['id']; ?>"><i class="bi bi-pencil-square"></i> Ubah</a>

                                                        <?php if ($user['role'] == $_ENV['APP_ROLE_NAME_1'] || $user['role'] == 'Admin') : ?>
                                                            <a href="#" id="notDeleteButtonAdmin" title="Hapus data pengguna" style="cursor: not-allowed;" class="btn btn-sm btn-danger mb-1" onclick="return false;"><i class="bi bi-trash3-fill"></i> Hapus</a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('admin/deleteGeneralUser/' . $user['id']); ?>" title="Hapus data pengguna" class="btn btn-sm btn-danger btn-deleted mb-1"><i class="bi bi-trash3-fill"></i> Hapus</a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <!-- MODAL ADD NEW USER -->
    <div class="modal fade" id="addNewUser" aria-labelledby="addNewUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-header-popup text-white">
                    <h5 class="modal-title" id="addNewUserLabel">Daftarkan Pengguna Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/manageAllUser'); ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?= base_url('assets/image/profile/default.jpg'); ?>" id="image-preview" class="img-thumbnail mb-2">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Pilih gambar...</label>
                                            <small><i class="bi bi-info-circle"></i> Ukuran gambar maks. 2MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="role" id="role" class="form-control <?= (form_error('role') ? 'is-invalid' : '') ?>">
                                <option value="">-- Pilih Peran --</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['id']; ?>" <?= set_select('role', $role['id']); ?>>
                                        <?= $role['role']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('role', '<small class="text-danger pl-1">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control <?= (form_error('name') ? 'is-invalid' : '') ?>" id="name" placeholder="Nama lengkap pengguna..." value="<?= set_value('name'); ?>">
                            <?= form_error('name', '<small class="text-danger pl-1">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="nbm_npm" class="form-control <?= (form_error('nbm_npm') ? 'is-invalid' : '') ?>" id="nbm_npm" placeholder="NBM / NPM pengguna..." value="<?= set_value('nbm_npm'); ?>">
                            <?= form_error('nbm_npm', '<small class="text-danger pl-1">', '</small>'); ?>
                        </div>
                        <div class="form-group" id="pembimbing-akademik-container" style="display: none;">
                            <select name="nama_pa" id="nama_pa" class="form-control select2">
                                <option value="">-- Pilih Pembimbing Akademik --</option>
                                <?php foreach ($allDosen as $dosen) : ?>
                                    <option value="<?= $dosen['id']; ?>" <?= set_select('nama', $dosen['id']); ?>>
                                        <?= $dosen['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-btn-popup"><i class="bi bi-send"></i> Daftarkan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT MENU -->
    <?php $no = 0; ?>
    <?php foreach ($users as $user) : $no++; ?>
        <div class="modal fade" id="editGeneralUser<?= $user['id']; ?>" tabindex="-1" aria-labelledby="editGeneralUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-header-popup text-white">
                        <h5 class="modal-title" id="editGeneralUserLabel">Perbarui Data Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('admin/editGeneralUser'); ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="<?= base_url('assets/image/profile/') . $user['image']; ?>" id="image-preview2" class="img-thumbnail mb-2">
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="image">
                                                <label class="custom-file-label" for="image">Ganti gambar...</label>
                                                <small><i class="bi bi-info-circle"></i> Ukuran gambar maks. 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <?php
                                    // Mendapatkan nilai is_active dari database
                                    $is_active = $user['is_active']; // Sesuaikan dengan nama kolom dalam tabel submenu

                                    // Menampilkan checkbox dengan nilai default dari database
                                    $is_checked = ($is_active == 1) ? TRUE : FALSE;
                                    ?>
                                    <input type="hidden" name="is_active" value="0"> <!-- Nilai default saat checkbox tidak dicentang -->
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?= set_checkbox('is_active', '1', $is_checked) ?>>
                                    <label for="is_active" class="form-check-label">Aktifkan Pengguna ?</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama lengkap pengguna..." value="<?= $user['name']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email aktif pengguna..." value="<?= $user['email']; ?>" <?= ($user['id'] == 1) ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <select name="role_id" id="role_id" class="form-control" <?= ($user['id'] == 1) ? 'disabled' : ''; ?>>
                                    <option value="">-- Pilih Peran --</option>
                                    <?php foreach ($roles as $role) : ?>
                                        <option value="<?= $role['id']; ?>" <?= set_select('role_id', $role['id'], $user['role_id'] == $role['id']); ?>>
                                            <?= $role['role']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <hr>
                            <div class="card p-2" style="background-color: #efefef;">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" id="generatePasswordDefaultUbahUser<?= $no; ?>" placeholder="Password baru...">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_pass_edit_user" class="form-control" id="generatePasswordDefaultUbahUser2<?= $no; ?>" placeholder="Konfirmasi password baru...">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="togglePasswordCheckbox<?= $no; ?>" onchange="togglePasswordVisibilityEditUser('togglePasswordCheckbox<?= $no; ?>', 'generatePasswordDefaultUbahUser<?= $no; ?>', 'generatePasswordDefaultUbahUser2<?= $no; ?>')">
                                    <label for="togglePasswordCheckbox<?= $no; ?>">Tampilkan Password</label>
                                </div>
                                <hr class="mb-2" style="margin-top: -10px;">
                                <small class="row justify-content-end mr-2"><a href="javascript:void(0)" onclick="return generateDefaultPasswordEditUser(<?= $no; ?>)">Buat Password Bawaan?</a>&nbsp; dari (12345678).</small>
                                <small class="row justify-content-end mr-2"><a href="javascript:void(0)" onclick="return resetPasswordEditUser('generatePasswordDefaultUbahUser<?= $no; ?>', 'generatePasswordDefaultUbahUser2<?= $no; ?>')">Kosongkan Password Bawaan!</a></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn bg-btn-popup"><i class="bi bi-send"></i> Perbarui Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Footer -->
    <?php $this->load->view('backend/template/footer'); ?>

</div>


<!-- JS -->
<?php $this->load->view('backend/template/js'); ?>

<!-- Script Deleted Data -->
<script>
    $('.btn-deleted').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            icon: "warning",
            title: "Apakah anda yakin?",
            text: "Data pengguna akan dihapus",
            showCancelButton: true,
            confirmButtonColor: "#28A745",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus Data",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
</script>

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
                $('#image-preview2').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

<!-- Mengisi Placeholder pada tambah penggung menjadi dinamis -->
<script>
    document.getElementById('role').addEventListener('change', function() {
        let roleId = this.value;
        let nbmNpmInput = document.getElementById('nbm_npm');
        let userName = document.getElementById('name');
        let pembimbingAkademikContainer = document.getElementById('pembimbing-akademik-container');
        
        if (roleId == '2') { // Jika peran adalah Mahasiswa dengan id = 2
            nbmNpmInput.placeholder = 'NPM Mahasiswa...';
            userName.placeholder = 'Nama lengkap Mahasiswa...';
            pembimbingAkademikContainer.style.display = 'block';
        } else {
            nbmNpmInput.placeholder = 'NBM dosen...';
            userName.placeholder = 'Nama lengkap Dosen...';
            pembimbingAkademikContainer.style.display = 'none';
        }
    });
</script>

<!-- Generate Password Default -->
<script>
    // ============================== ADD USER ==============================
    // Add Password
    function generateDefaultPasswordAddUser() {
        // Select elements with unique id based on index
        let passwordInput = document.getElementById("generatePasswordDefaultAddUser");
        let password2Input = document.getElementById("generatePasswordDefaultAddUser2");

        // Set the default password value to "12345678"
        let defaultPassword = "<?= $_ENV['GENERATE_PASSWORD_DEFAULT']; ?>";
        passwordInput.value = defaultPassword;
        password2Input.value = defaultPassword;
    }

    // Reset Password
    function resetPasswordAddUser() {
        let passwordInput = document.getElementById("generatePasswordDefaultAddUser");
        let password2Input = document.getElementById("generatePasswordDefaultAddUser2");

        // Set the password value to empty string
        passwordInput.value = "";
        password2Input.value = "";
    }

    // ============================== EDIT USER ==============================
    // Add Password
    function generateDefaultPasswordEditUser(index) {
        // Select elements with unique id based on index
        let passwordInput = document.getElementById("generatePasswordDefaultUbahUser" + index);
        let password2Input = document.getElementById("generatePasswordDefaultUbahUser2" + index);

        // Set the default password value to "12345678"
        let defaultPassword = "<?= $_ENV['GENERATE_PASSWORD_DEFAULT']; ?>";
        passwordInput.value = defaultPassword;
        password2Input.value = defaultPassword;
    }

    // Reset Password
    function resetPasswordEditUser(index) {
        let passwordInput = document.getElementById("generatePasswordDefaultUbahUser" + index);
        let password2Input = document.getElementById("generatePasswordDefaultUbahUser2" + index);

        // Set the password value to empty string
        passwordInput.value = "";
        password2Input.value = "";
    }
</script>

<!-- Show the Password tobe text -->
<script>
    // ============================ SHOW PASSWORD IN ADD USER =================================
    function togglePasswordVisibility(checkboxId, inputId1, inputId2) {
        let checkbox = document.getElementById(checkboxId);
        let passwordInput1 = document.getElementById(inputId1);
        let passwordInput2 = document.getElementById(inputId2);

        // Toggle password visibility based on checkbox state
        if (checkbox.checked) {
            passwordInput1.type = "text";
            passwordInput2.type = "text";
        } else {
            passwordInput1.type = "password";
            passwordInput2.type = "password";
        }
    }

    // ============================ SHOW PASSWORD IN EDIT USER =================================
    function togglePasswordVisibilityEditUser(checkboxId, inputId1, inputId2) {
        let checkbox = document.getElementById(checkboxId);
        let passwordInput1 = document.getElementById(inputId1);
        let passwordInput2 = document.getElementById(inputId2);

        // Toggle password visibility based on checkbox state
        if (checkbox.checked) {
            passwordInput1.type = "text";
            passwordInput2.type = "text";
        } else {
            passwordInput1.type = "password";
            passwordInput2.type = "password";
        }
    }

    // Function to reset password inputs to empty
    function resetPasswordEditUser(inputId1, inputId2) {
        let passwordInput1 = document.getElementById(inputId1);
        let passwordInput2 = document.getElementById(inputId2);

        // Reset password inputs to empty
        passwordInput1.value = "";
        passwordInput2.value = "";
    }
</script>

</body>

</html>