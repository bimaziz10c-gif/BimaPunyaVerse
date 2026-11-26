<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit('Not found.');
}

$username = getenv('ADMIN_USERNAME');
$password = getenv('ADMIN_PASSWORD');

if ($username === false || $password === false || trim($username) === '' || strlen($password) < 12) {
    fwrite(STDERR, "Set ADMIN_USERNAME dan ADMIN_PASSWORD (minimal 12 karakter) sebelum menjalankan skrip.\n");
    exit(1);
}
$username = trim($username);

require_once __DIR__ . '/../konfigurasi/koneksi.php';

$hash = password_hash($password, PASSWORD_DEFAULT);
try {
    $stmt = mysqli_prepare($koneksi, 'INSERT INTO admin (username, password) VALUES (?, ?)');
    mysqli_stmt_bind_param($stmt, 'ss', $username, $hash);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $exception) {
    error_log('Admin provisioning failed: ' . $exception->getMessage());
    fwrite(STDERR, "Akun admin gagal dibuat. Periksa log server dan pastikan username belum digunakan.\n");
    exit(1);
}

fwrite(STDOUT, "Akun admin berhasil dibuat.\n");