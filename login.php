<?php
session_start();
include('db_config.php');

// ถ้า login แล้ว redirect ไปหน้า index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";  // ตัวแปรไว้แสดงข้อความผิดพลาด

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "❌ รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "❌ ไม่พบชื่อผู้ใช้ในระบบ";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f2f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-weight: 500;
        }

        .error-text {
            color: red;
            font-size: 14px;
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 20px;
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <h3 class="text-center mb-4">เข้าสู่ระบบ</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="username" placeholder="ระบุชื่อผู้ใช้" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสผ่าน</label>
                    <input type="password" class="form-control" name="password" placeholder="ระบุรหัสผ่าน" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">🔐 เข้าสู่ระบบ</button>

                <p class="text-center mt-3">
                    ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
