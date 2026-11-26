<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../konfigurasi/koneksi.php';

$idInput = $_GET['id'] ?? null;
$id = is_string($idInput) ? filter_var($idInput, FILTER_VALIDATE_INT) : false;

if ($id === false || $id <= 0) {
    http_response_code(404);
    exit('Keahlian tidak ditemukan.');
}

$stmt = mysqli_prepare($koneksi, 'SELECT nama_skill, tingkat FROM skills WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$skill = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$skill) {
    http_response_code(404);
    exit('Keahlian tidak ditemukan.');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $stmt = mysqli_prepare($koneksi, 'UPDATE skills SET nama_skill = ?, tingkat = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'sii', $nama, $tingkat, $id);
        mysqli_stmt_execute($stmt);
        header('Location: dashboard.php');
        exit();
    }

    $error = 'Nama dan tingkat keahlian harus diisi dengan benar.';
    if (is_string($namaInput)) {
        $skill['nama_skill'] = $namaInput;
    }
    if ($tingkat !== false) {
        $skill['tingkat'] = $tingkat;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Keahlian</title>
</head>
<body>
  <h1>Edit Keahlian</h1>

  <?php if ($error !== ''): ?>
    <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <form method="post">
    <label>
      Nama keahlian
      <input type="text" name="nama_skill"
             value="<?= htmlspecialchars($skill['nama_skill'], ENT_QUOTES, 'UTF-8') ?>" required>
    </label><br>
    <label>
      Tingkat
      <input type="number" name="tingkat" min="0" max="100"
             value="<?= (int) $skill['tingkat'] ?>" required>
    </label><br>
    <button type="submit">Simpan</button>
    <a href="dashboard.php">Batal</a>
  </form>
</body>
</html>
