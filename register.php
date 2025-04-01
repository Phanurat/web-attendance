<?php
include('db_config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // ตรวจสอบว่าชื่อผู้ใช้มีอยู่ในระบบหรือไม่
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "ชื่อผู้ใช้นี้มีอยู่แล้ว";
    } else {
        // เพิ่มข้อมูลผู้ใช้ใหม่
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "ลงทะเบียนสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a>";
        } else {
            echo "เกิดข้อผิดพลาด: " . $conn->error;
        }
    }
}
?>

<h2>สมัครสมาชิก</h2>
<form method="POST">
    ชื่อผู้ใช้: <input type="text" name="username" required><br>
    รหัสผ่าน: <input type="password" name="password" required><br>
    <input type="submit" value="สมัครสมาชิก">
</form>

<?php
include('includes/footer.php');
?>
