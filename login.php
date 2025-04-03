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
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <h3 class="text-center mb-4">สมัครสมาชิก</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="text" class="form-label">Username : </label>
                    <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password : </label>
                    <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                <p class="text-center mt-3">
                    <a href="register.php">สมัครสมาชิก?</a>
                </p>
            </form>
        </div>
    </div>  
</body>

