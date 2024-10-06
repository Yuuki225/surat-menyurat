<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_username = $_POST['receiver_username'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $sender_id = $_SESSION['user_id'];

    // Cari user penerima berdasarkan username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$receiver_username]);
    $receiver = $stmt->fetch();

    if ($receiver) {
        $receiver_id = $receiver['id'];
        // Simpan pesan ke dalam database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$sender_id, $receiver_id, $subject, $message]);
        $success = "Pesan berhasil dikirim!";
    } else {
        $error = "Pengguna dengan username tersebut tidak ditemukan.";
    }
}

include 'includes/header.php';
?>

<div class="send-message-wrapper">
    <h2>Kirim Pesan</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="receiver_username">Kepada (Username)</label>
            <input type="text" name="receiver_username" class="form-control" placeholder="Masukkan username penerima" required>
        </div>
        <div class="form-group">
            <label for="subject">Subjek</label>
            <input type="text" name="subject" class="form-control" placeholder="Masukkan subjek pesan" required>
        </div>
        <div class="form-group">
            <label for="message">Pesan</label>
            <textarea name="message" class="form-control" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
    </form>
</div>

<?php include 'includes/footer.php'; // Menyertakan footer ?>
