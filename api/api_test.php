<?php
$servername = "db";  // ชื่อของ MySQL service ใน Docker
$username = "admin"; // เปลี่ยนจาก root เป็น admin
$password = "1111";
$dbname = "attendance";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("❌ การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
} else {
    echo "✅ เชื่อมต่อฐานข้อมูลสำเร็จ!";
}
?>
