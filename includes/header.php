<?php
// ตรวจสอบว่า session ได้เริ่มต้นหรือไม่
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบเช็คอิน/เช็คเอาท์</title>
</head>
<body>
    <!-- เมนูหรือสิ่งที่ต้องการแสดงใน header -->
    <nav>
        <a href="index.php">หน้าแรก</a>
        <a href="login.php">เข้าสู่ระบบ</a>
        <a href="logout.php">ออกจากระบบ</a>
    </nav>
