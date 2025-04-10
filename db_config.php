<?php
// สำหรับโหลด .env ใน Local
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// ตรวจว่า environment ไหน
$appEnv = getenv('APP_ENV') ?: 'local';

if ($appEnv === 'local') {
    $servername = getenv("DB_HOST") ?: 'localhost';
    $dbname     = getenv("DB_NAME") ?: 'attendance';
    $username   = getenv("DB_USER") ?: 'root';
    $password   = getenv("DB_PASS") ?: '';
} else {
    // สำหรับ Docker
    $servername = getenv("DB_HOST") ?: 'db'; // ชื่อ service ใน docker-compose
    $dbname     = getenv("DB_NAME") ?: 'attendance';
    $username   = getenv("DB_USER") ?: 'admin';
    $password   = getenv("DB_PASS") ?: '1111';
}

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
