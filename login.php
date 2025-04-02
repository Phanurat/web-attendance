<?php
// เริ่ม session
session_start();

// เชื่อมต่อฐานข้อมูล
include('db_config.php');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือยัง
if (isset($_SESSION['username'])) {
    // ถ้าเข้าสู่ระบบแล้วให้ redirect ไปหน้าแรก
    header("Location: index.php");
    exit();  // ควรใช้ exit() หลังจาก header() เพื่อหยุดการทำงานของสคริปต์
}

// เช็คการเข้าสู่ระบบจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลผู้ใช้ในฐานข้อมูล (ใช้ Prepared Statements ป้องกัน SQL Injection)
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่านที่กรอก
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;  // เก็บข้อมูลผู้ใช้ใน session
            header("Location: index.php");  // เปลี่ยนหน้าไปยังหน้าแรกหลังจากเข้าสู่ระบบสำเร็จ
            exit();  // ควรใช้ exit() หลังจาก header()
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบชื่อผู้ใช้ในระบบ";
    }
}
?>

<!-- HTML ฟอร์มการเข้าสู่ระบบ -->
<h2>เข้าสู่ระบบ</h2>
<form method="POST">
    ชื่อผู้ใช้: <input type="text" name="username" required><br>
    รหัสผ่าน: <input type="password" name="password" required><br>
    <input type="submit" value="เข้าสู่ระบบ">
    <p><a href="register.php">สมัครสมาชิก</a></p>
</form>
