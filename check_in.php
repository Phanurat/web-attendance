<?php
session_start();  // เริ่ม session เพื่อใช้ $_SESSION
include('db_config.php');
include('includes/header.php');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือยัง
if (!isset($_SESSION['username'])) {
    echo "กรุณาเข้าสู่ระบบก่อน";
    exit();
}

date_default_timezone_set('Asia/Bangkok');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ใช้ session username เป็นรหัสพนักงาน
    $employee_id = $_SESSION['username']; 

    // ตรวจสอบว่า user มี id จริงในตาราง users
    $sql = "SELECT id, username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];  // ได้รหัสผู้ใช้
        $username = $row['username'];  // ได้ username

        // บันทึกข้อมูลเวลาเข้า
        $date = date('Y-m-d');
        $time_in = date('H:i:s');

        // ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
        $sql = "INSERT INTO attendance (users_id, username, date, time_in) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $username, $date, $time_in);  // ผูกค่าทั้งหมด
        
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

<h2>บันทึกเวลาเข้า</h2>
<a href="index.php">หน้าแรก</a>
<a href="logout.php">ออกจากระบบ</a>
<form method="POST">
    <input type="submit" value="บันทึกเวลาเข้า">
</form>

<?php
include('includes/footer.php');
?>
