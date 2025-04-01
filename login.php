<?php
ob_start();  // เริ่มต้นการบัฟเฟอร์ข้อมูล

session_start();
include('db_config.php');
include('includes/header.php');

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลผู้ใช้ในฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่านที่กรอกเข้ามา
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;  // เก็บข้อมูลผู้ใช้ใน session
            header("Location: index.php");  // เปลี่ยนหน้าไปยังหน้าแรกหลังจากเข้าสู่ระบบสำเร็จ
            exit;  // หยุดการทำงานของสคริปต์
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบชื่อผู้ใช้ในระบบ";
    }
}
?>

<h2>เข้าสู่ระบบ</h2>
<form method="POST">
    ชื่อผู้ใช้: <input type="text" name="username" required><br>
    รหัสผ่าน: <input type="password" name="password" required><br>
    <input type="submit" value="เข้าสู่ระบบ">
</form>

<?php
include('includes/footer.php');
ob_end_flush();  // ส่งข้อมูลทั้งหมดที่บัฟเฟอร์ไว้
?>
