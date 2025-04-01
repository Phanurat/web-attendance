<?php
session_start();
include('db_config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $date = date('Y-m-d');
    $time_in = date('H:i:s');

    // บันทึกข้อมูลเวลาเข้า
    $sql = "INSERT INTO attendance (employee_id, date, time_in) VALUES ('$employee_id', '$date', '$time_in')";

    if ($conn->query($sql) === TRUE) {
        echo "บันทึกเวลาเข้าเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<h2>บันทึกเวลาเข้า</h2>
<form method="POST">
    รหัสพนักงาน: <input type="text" name="employee_id" required>
    <input type="submit" value="บันทึกเวลาเข้า">
</form>

<?php
include('includes/footer.php');
?>
