<!-- Meta -->
<?php $this->load->view('frontend/template/meta'); ?>

<style>
    body {
        background-color: #0b5acf;
    }
</style>

<!-- Register Page -->
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><i class="bi bi-unlock-fill"></i> Buat Akun Sekarang!</h1>
                        </div>
                        
                        <!-- Pesan berhasil cek NBM/NPM -->
                        <?php if ($this->session->flashdata('success_message')): ?>
                            <p class="text-success text-center"><?= $this->session->flashdata('success_message') ?></p>
                        <?php endif; ?>
                        <!-- Pesan gagal cek NBM/NPM -->
                        <?php if ($this->session->flashdata('error_message')): ?>
                            <p class="text-danger text-center"><?= $this->session->flashdata('error_message') ?></p>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('auth/checkNbmNpm'); ?>">
                            <div class="card bg-light p-3">
                                <div class="form-group">
                                    <label for="nbm_npm"><span style="color:red;">*</span> Cek NBM/NPM dahulu!</label>
                                    <div class="input-group">
                                        <input type="text" name="nbm_npm" id="nbm_npm" class="form-control" placeholder="Masukan NBM / NPM" value="<?= ($this->session->flashdata('input_nbm_npm')) ? $this->session->flashdata('input_nbm_npm') : ''; ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn bg-btn-register"><i class="bi bi-arrow-clockwise"></i> Check</button>
                                        </div>
                                    </div>
                                    <?= form_error('nbm_npm', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </form>

                        <hr class="mb-4 mt-4" />

                        <form class="user" method="post" action="<?= base_url('auth/register'); ?>">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control form-control-user" id="email" placeholder="Email yang aktif..." value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password..." value="<?= set_value('password'); ?>">
                                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password2" class="form-control form-control-user" id="password2" placeholder="Ulangi password..." value="<?= set_value('password2'); ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn bg-btn-register btn-user btn-block">
                                Register
                            </button>
                            <div class="row text-center mt-3">
                                <label><small><input type="checkbox" checked disabled> Dengan mengklik <strong>Daftar</strong>, Anda menyetujui <a href="#" data-toggle="modal" data-target="#termsModal">Ketentuan</a> dan <a href="#" data-toggle="modal" data-target="#privacyPolicyModal">Kebijakan Privasi</a> kami. Semua data anda kami jaga kerahasiaanya.</small></label>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth/forgotPassword'); ?>">Lupa Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth'); ?>">Sudah punya akun? Login!</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('/'); ?>"><i class="bi bi-arrow-return-left"></i> Kembali ke beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup -->
<?php $this->load->view('frontend/template/modal-popup'); ?>

<!-- JS -->
<?php $this->load->view('frontend/template/js'); ?>