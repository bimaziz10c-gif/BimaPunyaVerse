<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../konfigurasi/koneksi.php';

try {
    $hasil = mysqli_query($koneksi, "SELECT * FROM pesan_kontak ORDER BY id DESC");
} catch (mysqli_sql_exception $exception) {
    error_log('Contact messages query failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Pesan kontak tidak dapat dimuat.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pesan Masuk</title>
</head>
<body>
  <h1>Daftar Pesan Masuk</h1>
  <a href="dashboard.php">← Kembali ke Dashboard</a>

  <?php while ($baris = mysqli_fetch_assoc($hasil)): ?>
    <p>
      <strong><?= htmlspecialchars($baris['nama'], ENT_QUOTES, 'UTF-8') ?></strong>
      (<?= htmlspecialchars($baris['email'], ENT_QUOTES, 'UTF-8') ?>) —
      <?= htmlspecialchars($baris['tanggal'], ENT_QUOTES, 'UTF-8') ?><br>
      <?php if (!empty($baris['subjek'])): ?>
        <em>Subjek: <?= htmlspecialchars($baris['subjek'], ENT_QUOTES, 'UTF-8') ?></em><br>
      <?php endif; ?>
      <?= nl2br(htmlspecialchars($baris['pesan'])) ?>
    </p>
    <hr>
  <?php endwhile; ?>
</body>
</html>