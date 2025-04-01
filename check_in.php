<?php
include('db_config.php');
include('includes/header.php');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือยัง
if (!isset($_SESSION['username'])) {
    echo "กรุณาเข้าสู่ระบบก่อน";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['username']; // ใช้ session username เป็นรหัสพนักงาน
    $date = date('Y-m-d');
    $time_in = date('H:i:s');
    
    // บันทึกข้อมูลเวลาเข้า
    $sql = "INSERT INTO attendance (username, date, time_in) VALUES ('$employee_id', '$date', '$time_in')";
    
    if ($conn->query($sql) === TRUE) {
        echo "บันทึกเวลาเข้าเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<h2>บันทึกเวลาเข้า</h2>
<form method="POST">
    <input type="submit" value="บันทึกเวลาเข้า">
</form>

<?php
include('includes/footer.php');
?>
