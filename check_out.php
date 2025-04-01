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
    $time_out = date('H:i:s');
    
    // บันทึกข้อมูลเวลาออก
    $sql = "UPDATE attendance SET time_out = '$time_out' WHERE employee_id = '$employee_id' AND date = '$date' AND time_out IS NULL";
    
    if ($conn->query($sql) === TRUE) {
        echo "บันทึกเวลาออกเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<h2>บันทึกเวลาออก</h2>
<form method="POST">
    <input type="submit" value="บันทึกเวลาออก">
</form>

<?php
include('includes/footer.php');
?>
