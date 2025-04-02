<?php
session_start();
include('includes/header.php');

// ตรวจสอบว่า user ได้เข้าสู่ระบบหรือยัง
if (!isset($_SESSION['username'])) {
    echo "กรุณาเข้าสู่ระบบ <a href='login.php'>ที่นี่</a>";
    exit;
}
?>



<?php
include('includes/footer.php');
?>
<nav>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- ถ้าผู้ใช้เข้าสู่ระบบแล้ว -->
            <?php
                $username = htmlspecialchars($_SESSION['username']); // ป้องกันการโจมตีจาก XSS
                echo "ยินดีต้อนรับ, " . $username;
            ?>
            <a href="logout.php">ออกจากระบบ</a>
        <?php else: ?>
            <!-- ถ้ายังไม่ได้เข้าสู่ระบบ -->
            <a href="login.php">เข้าสู่ระบบ</a>
            <a href="register.php">สมัครสมาชิก</a>
        <?php endif; ?>
    </nav>

    <p><a href="check_in.php">คลิกที่นี่เพื่อบันทึกเวลาเข้า</a></p>
    <p><a href="check_out.php">คลิกที่นี่เพื่อบันทึกเวลาออก</a></p>