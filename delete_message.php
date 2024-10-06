<?php
session_start();
include 'includes/db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Pastikan parameter `id` ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID pesan tidak valid.";
    exit();
}

$message_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Hanya hapus pesan yang diterima oleh user yang sedang login
$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ? AND receiver_id = ?");
$result = $stmt->execute([$message_id, $user_id]);

if ($result) {
    // Berhasil menghapus, kembali ke halaman inbox
    header('Location: inbox.php');
    exit();
} else {
    echo "Gagal menghapus pesan.";
}
var_dump($result)
?>
