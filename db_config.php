<?php
$servername = getenv('MYSQL_HOST') ?: "db"; // ตั้งชื่อเซิร์ฟเวอร์ฐานข้อมูลให้ตรงกับบริการ db ใน docker-compose
$username = "user";
$password = "password";
$dbname = "attendance_system";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
