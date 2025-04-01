<?php
session_start();
include('db_config.php');
include('includes/header.php');

// ตรวจสอบการเข้าสู่ระบบ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบชื่อผู้ใช้และรหัสผ่าน
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบชื่อผู้ใช้";
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
?>
