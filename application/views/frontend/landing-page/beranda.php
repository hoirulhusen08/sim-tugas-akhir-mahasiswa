<!-- Meta -->
<?php $this->load->view('frontend/template/meta'); ?>

<!-- Navbar -->
<?php $this->load->view('frontend/template/navbar'); ?>

<!-- Banner -->
<section id="banner">
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <h3 class="text-banner">Sistem Informasi Manajemen <br> Tugas Akhir Mahasiswa</h3>
                        <p class="subtext-banner">Fakultas Teknik dan Ilmu Komputer <br> Muhammadiyah Kotabumi</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row justify-content-center">
                        <img class="img-banner" src="<?= base_url('assets/image/banner/wisuda.png'); ?>" alt="img-banner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us -->
<section id="aboutUs">
    <div class="container">
        <h3 class="high-title text-center mb-3">Tentang Kami</h3>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-center">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis alias, tempora pariatur accusamus laborum molestias, commodi est natus nemo aliquam id? Vitae, quis sit? Iusto temporibus dolorum similique incidunt atque maxime dicta eum distinctio vel iste quos nam hic a at ratione nobis consectetur, adipisci sed, aspernatur possimus esse. Atque fuga quis impedit totam in dignissimos quasi magnam, mollitia officiis similique ratione sapiente quisquam illum consectetur saepe.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h3 class="high-title text-center">Kontak Kami</h3>
                <p class="text-center mb-3">Untuk bertanya terkait kendala apapun, dapat menghubungi pada <strong>Pusat Bantuan</strong> dibawah :</p>
                <div class="row justify-content-center">
                    <div class="iconSosmed">
                        <a class="instagram" href="#"><i class="bi bi-instagram"></i></a>
                        <a class="whatsapp" href="#"><i class="bi bi-whatsapp"></i></a>
                        <a class="email" href="#"><i class="bi bi-envelope-fill"></i></a>
                        <a class="web" href="#"><i class="bi bi-globe-central-south-asia"></i></a>
                    </div>
                </div>
                <hr>
                <p class="text-center">Jl. Hasan Kepala Ratu No.1052, Sindang Sari, Kec. Kotabumi, Kabupaten Lampung Utara, Lampung 34517</p>
                <hr>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7951.560178551508!2d104.86589644103799!3d-4.80778108954737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e38a8cb47225a21%3A0xd2e026f22c44746f!2sUniversitas%20Muhammadiyah%20Kotabumi!5e0!3m2!1sid!2sid!4v1728898909690!5m2!1sid!2sid" class="maps-contact" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>



<!-- Perticle JS -->
<script src="<?= base_url('assets/plugins/particle/particles.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/particle/app.js'); ?>"></script>

<!-- Modal Popup -->
<?php $this->load->view('frontend/template/modal-popup'); ?>

<!-- Footer -->
<?php $this->load->view('frontend/template/footer'); ?>

<!-- JS -->
<?php $this->load->view('frontend/template/js'); ?>