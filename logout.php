<?php
session_start();  // เริ่มต้น session
session_unset();  // ลบข้อมูล session ทั้งหมด
session_destroy();  // ทำลาย session
header("Location: login.php");  // รีไดเรกต์กลับไปที่หน้าล็อกอิน
exit();
?>
