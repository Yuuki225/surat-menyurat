<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil pesan dari database
$stmt = $pdo->prepare("SELECT messages.*, users.username as sender_username FROM messages JOIN users ON messages.sender_id = users.id WHERE receiver_id = ?");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="inbox-wrapper">
    <div class="inbox-header">
        <h2>Inbox Anda</h2>
        <a href="send_message.php" class="btn btn-primary">Kirim Pesan Baru</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover inbox-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pengirim</th>
                    <th scope="col">Subjek</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($messages) > 0): ?>
                    <?php foreach ($messages as $index => $message): ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= htmlspecialchars($message['sender_username']) ?></td>
                            <td><?= htmlspecialchars($message['subject']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($message['sent_at'])) ?></td>
                            <td class="text-center">
                              <a href="view_message.php?id=<?= $message['id'] ?>" class="btn btn-sm btn-outline-primary">
                                 <i class="fas fa-eye"></i> Lihat
                             </a>
                            <a href="delete_message.php?id=<?= $message['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pesan di inbox Anda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php';?>
