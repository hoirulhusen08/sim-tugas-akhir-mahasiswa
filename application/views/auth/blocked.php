<!-- Meta -->
<?php $this->load->view('frontend/template/meta'); ?>

<style>
    body {
        background: linear-gradient(to right, #f00, #00f);
        /* Merah ke biru */
    }

    #particles-js {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        /* background-image: url("https://source.unsplash.com/random/800x600?sig=AFd73274e43623a20f5353121009309a"); */
        /* background-size: cover;
        background-position: center; */
    }

    .container {
        position: absolute;
    }

    .error-403 {
        position: relative;
        z-index: 1;
        width: 400px;
        height: 300px;
        margin: 0 auto;
        text-align: center;
    }

    .error-403 h1 {
        font-size: 100px;
        font-weight: bold;
        color: #fff;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        animation: glitch 2s infinite;
    }

    @keyframes glitch {
        0% {
            transform: translate(0, 0);
        }

        50% {
            transform: translate(10px, 10px);
        }

        100% {
            transform: translate(0, 0);
        }
    }

    .error-403 p {
        color: #fff;
    }

    .error-403 p.title {
        font-size: 30px;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>

<!-- Blocked Page -->
<div id="particles-js">
    <div class="container">
        <div class="error-403">
            <h1>403</h1>
            <p class="title">Akses Terlarang!</p>
            <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="<?= base_url('/'); ?>" class="btn btn-success w-100"><i class="bi bi-arrow-left-circle"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>

<!-- Perticle JS -->
<script src="<?= base_url('assets/plugins/particle/particles.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/particle/app.js'); ?>"></script>

<!-- JS -->
<?php $this->load->view('frontend/template/js'); ?>