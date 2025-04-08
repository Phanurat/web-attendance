<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝ระบบเช็คอิน/เช็คเอาท์</title>
    <link rel="stylesheet" href="styles.css"> <!-- ใช้ไฟล์ CSS ของคุณ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- ส่วนของ Header ที่สามารถใช้ในทุกหน้า -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">ระบบเช็คอิน/เช็คเอาท์</a>

            <!-- Hamburger Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">📝ลงเวลางาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">📆ตารางเวลา</a>
                    </li>
                    <li class="nav-item d-flex align-items-center text-light">
                        <?php if (isset($_SESSION['username'])): ?>
                            <span class="nav-link">
                                <img src="https://cdn-icons-png.flaticon.com/128/924/924915.png" width="24" height="24" class="me-1">
                                <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
                            </span>
                        <?php else: ?>
                            <a class="nav-link text-light" href="login.php">เข้าสู่ระบบ</a>
                            <a class="nav-link ms-2 text-light" href="register.php">สมัครสมาชิก</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-3" href="logout.php">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- เมนูหรือการนำทาง -->

