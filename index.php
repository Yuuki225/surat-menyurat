<?php
include 'includes/header.php'; 
?>

<div class="hero-section">
    <div class="overlay"></div>
    <div class="hero-content text-center">
        <h1 class="display-3">Selamat Datang di E-Inter</h1>
        <p class="lead">Sederhana, Aman, dan Efisien untuk Mengirim Pesan.</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a class="btn btn-primary btn-lg" href="inbox.php" role="button">Lihat Inbox</a>
            <a class="btn btn-outline-light btn-lg" href="send_message.php" role="button">Kirim Pesan Baru</a>
        <?php else: ?>
            <a class="btn btn-primary btn-lg" href="login.php" role="button">Login</a>
            <a class="btn btn-outline-light btn-lg" href="register.php" role="button">Daftar</a>
        <?php endif; ?>
    </div>
</div>

<section class="features-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-envelope feature-icon"></i>
                    <h3>Kirim Pesan Cepat</h3>
                    <p>Komunikasi langsung dengan pengguna lain dengan antarmuka yang mudah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-inbox feature-icon"></i>
                    <h3>Inbox yang Aman</h3>
                    <p>Simpan semua pesan Anda dengan aman dalam sistem yang terproteksi.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-users feature-icon"></i>
                    <h3>Antarmuka Mudah</h3>
                    <p>Desain antarmuka yang simpel untuk navigasi yang cepat dan efisien.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php'; 
?>
