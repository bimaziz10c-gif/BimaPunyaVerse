<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../konfigurasi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idInput = $_POST['id'] ?? null;
    $id = is_string($idInput) ? filter_var($idInput, FILTER_VALIDATE_INT) : false;

    if ($id !== false && $id > 0) {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM skills WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: dashboard.php");
exit();