<?php
$servername = "localhost";
$username = "root"; // หรือใช้ username ของ MySQL
$password = ""; // หรือใช้ password ของ MySQL
$dbname = "attendance_system"; // ชื่อฐานข้อมูลที่ใช้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
