<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');

$host = $host !== false ? $host : 'localhost';
$user = $user !== false ? $user : 'root';
$password = $password !== false ? $password : '';
$database = $database !== false ? $database : 'db_cv';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = mysqli_connect($host, $user, $password, $database);
    mysqli_set_charset($koneksi, 'utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Koneksi database gagal. Periksa konfigurasi dan log server.\n");
        exit(1);
    }

    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi dan log server.');
}