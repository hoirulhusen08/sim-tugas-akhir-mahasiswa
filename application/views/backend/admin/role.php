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
                        <h1>Halaman <?= $title; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/role'); ?>"><?= $title; ?></a></li>
                            <li class="breadcrumb-item active">Index</li>
                        </ol>
                    </div>
                </div>

                <!-- Form Error / FlashData -->
                <?= form_error(
                    'role',
                    '<div class="alert my-alert-danger alert-dismissible fade show text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>',
                    '</div>'
                ); ?>

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
                                <a href="#" class="btn my-btn-custom" data-toggle="modal" data-target="#addNewRole"><i class="fas fa-solid fa-plus"></i> Tambah Peran Baru</a>

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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Peran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($roles as $role) : ?>
                                            <tr>
                                                <td><?= $i++ . "."; ?></td>
                                                <td><?= $role['role']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/roleAccess/') . $role['id']; ?>" class="btn btn-sm btn-info mb-1"><i class="bi bi-pencil-square"></i> Hak Akses</a>

                                                    <a href="#" class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#editRole<?= $role['id']; ?>"><i class="bi bi-pencil-square"></i> Ubah</a>

                                                    <?php if ($role['role'] === 'Administrator' || $role['role'] === 'Admin') : ?>
                                                        <a href="#" id="notDeleteButtonAdmin" style="cursor: not-allowed;" class="btn btn-sm btn-danger" onclick="return false;"><i class="bi bi-trash3-fill"></i> Hapus</a>
                                                    <?php else : ?>
                                                        <a href="<?= base_url('admin/deleteRole/' . $role['id']); ?>" class="btn btn-sm btn-danger mb-1 btn-deleted"><i class="bi bi-trash3-fill"></i> Hapus</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Peran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <!-- MODAL ADD NEW MENU -->
    <div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="addNewRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-header-popup text-white">
                    <h5 class="modal-title" id="addNewRoleLabel">Tambah Peran Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/role'); ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="role" class="form-control <?= (form_error('role') ? 'is-invalid' : '') ?>" id="role" placeholder="Nama peran..." value="<?= set_value('role'); ?>">
                            <?= form_error('role', '<small class="text-danger pl-1">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-btn-popup"><i class="bi bi-send"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT MENU -->
    <?php $no = 0; ?>
    <?php foreach ($roles as $role) : $no++; ?>
        <div class="modal fade" id="editRole<?= $role['id']; ?>" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-header-popup text-white">
                        <h5 class="modal-title" id="editRoleLabel">Perbarui Peran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('admin/editRole'); ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?= $role['id']; ?>">
                                <input type="text" name="role" class="form-control" id="role" placeholder="Nama peran..." value="<?= $role['role']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn bg-btn-popup"><i class="bi bi-send"></i> Perbarui</button>
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
            text: "Data peran akan dihapus",
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

</body>

</html>