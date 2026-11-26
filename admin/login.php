<?php
session_start();
require_once __DIR__ . '/../konfigurasi/koneksi.php';

// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION['login'], $_SESSION['username']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['masuk'])) {
    $usernameInput = $_POST['username'] ?? null;
    $passwordInput = $_POST['password'] ?? null;

    if (is_string($usernameInput) && is_string($passwordInput)) {
        $username = trim($usernameInput);

        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($user && password_verify($passwordInput, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        }
    }

    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
</head>
<body>
  <h1>Login Admin</h1>

  <?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="masuk">Masuk</button>
  </form>
</body>
</html>