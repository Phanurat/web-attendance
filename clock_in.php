<?php
session_start();
include('db_config.php');
include('includes/header.php');

// ตั้งเวลาเป็นเวลาไทย
date_default_timezone_set('Asia/Bangkok');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // ใช้ username แทน employee_id
    $date = date('Y-m-d');
    $time_in = date('H:i:s');

    // ตรวจสอบว่ามีการบันทึกเวลาเข้าแล้วหรือไม่
    $check_sql = "SELECT * FROM attendance 
                  JOIN users ON attendance.employee_id = users.id
                  WHERE users.username = ? AND date = ? AND time_in IS NULL";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // บันทึกข้อมูลเวลาเข้า
        $sql = "INSERT INTO attendance (employee_id, date, time_in) 
                SELECT id, ?, ? FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $date, $time_in, $username);

        if ($stmt->execute()) {
            echo "บันทึกเวลาเข้าเรียบร้อย";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    } else {
        echo "คุณได้บันทึกเวลาเข้าแล้วในวันนี้ หรือไม่พบชื่อผู้ใช้นี้ในระบบ";
    }
}
?>

<h2>บันทึกเวลาเข้า</h2>
<form method="POST">
    ชื่อผู้ใช้: <input type="text" name="username" required>
    <input type="submit" value="บันทึกเวลาเข้า">
</form>

<?php
include('includes/footer.php');
?>
