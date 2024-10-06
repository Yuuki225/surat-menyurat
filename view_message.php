<?php
session_start();
include 'includes/db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil ID pesan dari URL
$message_id = $_GET['id'] ?? null;

if (!$message_id) {
    echo "Pesan tidak ditemukan.";
    exit();
}

// Ambil pesan dari database berdasarkan ID
$stmt = $pdo->prepare("SELECT messages.*, users.username as sender_username FROM messages JOIN users ON messages.sender_id = users.id WHERE messages.id = ?");
$stmt->execute([$message_id]);
$message = $stmt->fetch();

if (!$message) {
    echo "Pesan tidak ditemukan.";
    exit();
}

// Proses balas pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply_subject = "Re: " . $message['subject']; // Subjek pesan balasan
    $reply_message = $_POST['reply_message'];
    $receiver_id = $message['sender_id']; // Pengirim asli menjadi penerima balasan
    $sender_id = $_SESSION['user_id'];

    // Masukkan pesan balasan ke dalam database
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $reply_subject, $reply_message]);

    echo "Balasan telah dikirim!";
}

include 'includes/header.php'; 
?>

<div class="message-wrapper">
    <div class="message-header">
        <h2>Subjek: <?= htmlspecialchars($message['subject']) ?></h2>
        <p><strong>Dari:</strong> <?= htmlspecialchars($message['sender_username']) ?></p>
        <p><strong>Dikirim pada:</strong> <?= date('d M Y, H:i', strtotime($message['sent_at'])) ?></p>
    </div>

    <div class="message-body">
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
    </div>

    <div class="reply-wrapper">
        <h3>Balas Pesan</h3>
        <form method="POST">
            <div class="form-group">
                <textarea name="reply_message" class="form-control" rows="5" placeholder="Tulis balasan Anda..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
