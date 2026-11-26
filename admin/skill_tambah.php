<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../konfigurasi/koneksi.php';

$nama = '';
$tingkat = 50;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $namaInput = $_POST['nama_skill'] ?? null;
    $tingkatInput = $_POST['tingkat'] ?? null;
    $tingkat = is_string($tingkatInput) ? filter_var($tingkatInput, FILTER_VALIDATE_INT) : false;

    if (
        is_string($namaInput)
        && trim($namaInput) !== ''
        && $tingkat !== false
        && $tingkat >= 0
        && $tingkat <= 100
    ) {
        $nama = trim($namaInput);
        $stmt = mysqli_prepare($koneksi, "INSERT INTO skills (nama_skill, tingkat) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "si", $nama, $tingkat);
        mysqli_stmt_execute($stmt);
        header("Location: dashboard.php");
        exit();
    } else {
        $error = 'Nama dan tingkat keahlian harus diisi dengan benar.';
        $nama = is_string($namaInput) ? $namaInput : '';
        $tingkat = $tingkat !== false ? $tingkat : 50;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Skill</title>
</head>
<body>
  <h1>Tambah Keahlian</h1>
  <?php if ($error !== ''): ?>
    <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>
  <form method="post">
    <input type="text" name="nama_skill" placeholder="Nama skill"
           value="<?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>" required><br>
    <input type="number" name="tingkat" min="0" max="100"
           value="<?= (int) $tingkat ?>" required><br>
    <button type="submit" name="simpan">Simpan</button>
    <a href="dashboard.php">Batal</a>
  </form>
</body>
</html>