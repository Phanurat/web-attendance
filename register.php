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
            echo "ลงทะเบียนสำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาด: " . $conn->error;
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="register-container">
            <h3 class="text-center mb-4">สมัครสมาชิก</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                </div>
                <button type="submit" class="btn btn-success w-100">สมัครสมาชิก</button>
                <p class="text-center mt-3">
                    มีบัญชีอยู่แล้วใช่ไหม? <a href="login.php">เข้าสู่ระบบ</a>
                </p>
            </form>
        </div>
    </div>
</body>
<?php
include('includes/footer.php');
?>
