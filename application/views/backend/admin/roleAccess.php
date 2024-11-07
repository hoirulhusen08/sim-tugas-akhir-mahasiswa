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
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/role'); ?>">Peran</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                </div>

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
        </section>

        <section class="content">
            <div class="container-fluid">
                <h5 class="text-muted" id="notPrint"><a style="text-decoration: none;" href="<?= base_url('admin/role'); ?>"><i class="bi bi-arrow-left-circle-fill"></i> <small>Kembali</a> | Sebagai : <?= $role['role']; ?></small></h5>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Menu</th>
                                                <th id="notPrint">Akses</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($menus as $menu) : ?>
                                                <tr>
                                                    <td><?= $i++ . "."; ?></td>
                                                    <td><?= $menu['menu']; ?></td>
                                                    <td id="notPrint">
                                                        <div class="form-check">
                                                            <input class="form-check-input form-check-role-input" type="checkbox" <?= check_access($role['id'], $menu['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                                        </div>
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

    <!-- Footer -->
    <?php $this->load->view('backend/template/footer'); ?>

</div>

<!-- JS -->
<?php $this->load->view('backend/template/js'); ?>

<!-- Change Access Role User with AJAX -->
<script>
    $('.form-check-role-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeAccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleAccess/'); ?>" + roleId;
            }
        });
    });
</script>

</body>

</html>