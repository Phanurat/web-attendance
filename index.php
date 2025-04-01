<?php
session_start();
include('includes/header.php');

// ตรวจสอบว่า user ได้เข้าสู่ระบบหรือยัง
if (!isset($_SESSION['username'])) {
    echo "กรุณาเข้าสู่ระบบ <a href='login.php'>ที่นี่</a>";
    exit;
}

echo "ยินดีต้อนรับ, " . $_SESSION['username'];
?>

<h2>ระบบเช็คเข้าออกงาน</h2>
<p><a href="check_in.php">คลิกที่นี่เพื่อบันทึกเวลาเข้า</a></p>
<p><a href="check_out.php">คลิกที่นี่เพื่อบันทึกเวลาออก</a></p>
<p><a href="logout.php">ออกจากระบบ</a></p>

<?php
include('includes/footer.php');
?>
