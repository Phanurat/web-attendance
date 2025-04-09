<?php
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- สำคัญมากสำหรับมือถือ -->
    <title>ระบบบันทึกเวลาเข้าออก</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
        }

        nav a, nav span {
            color: white;
            margin: 8px 10px;
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        nav a:hover {
            color: #ffcc00;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .welcome {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 10px auto;
            padding: 15px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            color: white;
        }

        .btn-checkin {
            background-color: #4CAF50;
        }

        .btn-checkin:hover {
            background-color: #45a049;
        }

        .btn-checkout {
            background-color: #f44336;
        }

        .btn-checkout:hover {
            background-color: #e53935;
        }

        /* 📱 Responsive tweaks */
        @media (max-width: 480px) {
            .welcome {
                font-size: 18px;
            }

            .btn {
                font-size: 15px;
                padding: 12px;
            }

            nav a, nav span {
                font-size: 14px;
                margin: 5px;
            }
        }
    </style>
</head>
<body>

<nav>
    <?php if (isset($_SESSION['username'])): ?>
        <?php $username = htmlspecialchars($_SESSION['username']); ?>
        <span>ยินดีต้อนรับ, <?= $username ?></span>
        <a href="logout.php">ออกจากระบบ</a>
    <?php else: ?>
        <a href="login.php">เข้าสู่ระบบ</a>
        <a href="register.php">สมัครสมาชิก</a>
    <?php endif; ?>
</nav>

<?php
// ตรวจสอบว่า user ได้เข้าสู่ระบบหรือยัง
if (!isset($_SESSION['username'])) {
    echo "<div class='container'><p>กรุณาเข้าสู่ระบบ <a href='login.php'>ที่นี่</a></p></div>";
    exit;
}
?>

<div class="container">
    <div class="welcome">กรุณาเลือกทำรายการ</div>
    <a href="check_in.php" class="btn btn-checkin">✅ คลิกที่นี่เพื่อบันทึกเวลาเข้า</a>
    <a href="check_out.php" class="btn btn-checkout">⏰ คลิกที่นี่เพื่อบันทึกเวลาออก</a>
</div>

</body>
</html>
