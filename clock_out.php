<?php
session_start();
include('db_config.php');
include('includes/header.php');

// ตั้งเวลาเป็นเวลาไทย
date_default_timezone_set('Asia/Bangkok');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // ใช้ username แทน employee_id
    $date = date('Y-m-d');
    $time_out = date('H:i:s');

    // ตรวจสอบว่าได้บันทึกเวลาเข้าไปแล้วในวันนี้หรือไม่
    $check_sql = "SELECT * FROM attendance 
                  JOIN users ON attendance.employee_id = users.id
                  WHERE users.username = ? AND date = ? AND time_out IS NULL";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // บันทึกข้อมูลเวลาออก
        $sql = "UPDATE attendance SET time_out = ? 
                WHERE employee_id = (SELECT id FROM users WHERE username = ?) 
                AND date = ? AND time_out IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $time_out, $username, $date);

        if ($stmt->execute()) {
            echo "บันทึกเวลาออกเรียบร้อย";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    } else {
        echo "คุณยังไม่ได้บันทึกเวลาเข้าในวันนี้ หรือคุณได้บันทึกเวลาออกแล้ว.";
    }
}
?>

<h2>บันทึกเวลาออก</h2>
<form method="POST">
    ชื่อผู้ใช้: <input type="text" name="username" required>
    <input type="submit" value="บันทึกเวลาออก">
</form>

<?php
include('includes/footer.php');
?>
