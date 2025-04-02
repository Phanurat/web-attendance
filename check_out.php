<?php
session_start();  // เริ่ม session เพื่อใช้ $_SESSION
include('db_config.php');
include('includes/header.php');

// ตั้งค่า timezone เป็น Asia/Bangkok
date_default_timezone_set('Asia/Bangkok');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือยัง
if (!isset($_SESSION['username'])) {
    echo "กรุณาเข้าสู่ระบบก่อน";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['username']; // ใช้ session username เป็นรหัสพนักงาน
    $date = date('Y-m-d');  // วันที่ในรูปแบบ YYYY-MM-DD
    $time_out = date('H:i:s');  // เวลาออกในรูปแบบ HH:MM:SS

    // ตรวจสอบว่า user มี id จริงในตาราง users
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];  // ได้ username

        // ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
        $sql = "UPDATE attendance SET time_out = ? WHERE username = ? AND date = ? AND time_out IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $time_out, $employee_id, $date);

        if ($stmt->execute()) {
            echo "บันทึกเวลาออกเรียบร้อย";
            echo "<br>วันที่: " . $date . "<br>เวลาออก: " . $time_out . "<br>ชื่อผู้ใช้: " . $username;
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    } else {
        echo "ไม่พบข้อมูลผู้ใช้ในระบบ";
    }
}
?>

<h2>บันทึกเวลาออก</h2>
<a href="index.php">หน้าแรก</a>
<a href="logout.php">ออกจากระบบ</a>
<form method="POST">
    <input type="submit" value="บันทึกเวลาออก">
</form>

<?php
include('includes/footer.php');
?>
