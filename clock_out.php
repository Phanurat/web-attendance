<?php
session_start();
include('db_config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
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
    รหัสพนักงาน: <input type="text" name="employee_id" required>
    <input type="submit" value="บันทึกเวลาออก">
</form>

<?php
include('includes/footer.php');
?>
