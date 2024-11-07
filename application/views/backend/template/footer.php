<footer class="main-footer" id="notPrint">
    <strong>Copyright &copy; <?= date('Y'); ?> <a href="#">SI - Tugas Akhir Mahasiswa</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?= $_ENV['APP_VERSION']; ?>
    </div>
</footer>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-header-popup text-white">
                <h5 class="modal-title" id="exampleModalLabel">Yakin akan keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn bg-btn-popup" href="<?= base_url('auth/logout'); ?>"><i class="bi bi-box-arrow-left"></i> Keluar</a>
            </div>
        </div>
    </div>
</div>