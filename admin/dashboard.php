<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../konfigurasi/koneksi.php';

try {
    $hasil = mysqli_query($koneksi, "SELECT * FROM skills ORDER BY id ASC");
} catch (mysqli_sql_exception $exception) {
    error_log('Admin skills query failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Data keahlian tidak dapat dimuat.');
}
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
</head>
<body>
  <h1>Dashboard Admin</h1>
  <p>
    Halo, <?= $username ?> |
    <a href="pesan.php">Pesan Kontak</a> |
    <a href="logout.php">Logout</a>
  </p>

  <h2>Data Keahlian</h2>
  <a href="skill_tambah.php">+ Tambah Skill</a>
  <br><br>

  <table border="1" cellpadding="6">
    <tr>
      <th>No</th>
      <th>Nama Skill</th>
      <th>Tingkat</th>
      <th>Aksi</th>
    </tr>
    <?php $no = 1; ?>
    <?php while ($r = mysqli_fetch_assoc($hasil)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['nama_skill'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= (int) $r['tingkat'] ?>%</td>
        <td>
          <a href="skill_edit.php?id=<?= (int) $r['id'] ?>">Edit</a>
          <form method="post" action="skill_hapus.php" style="display:inline"
                onsubmit="return confirm('Hapus skill ini?')">
            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
            <button type="submit">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>