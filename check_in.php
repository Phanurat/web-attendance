<?php
session_start();
include('db_config.php');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือยัง
if (!isset($_SESSION['username'])) {
    echo "<div class='container'><p>กรุณาเข้าสู่ระบบก่อน <a href='login.php'>คลิกที่นี่</a></p></div>";
    exit();
}

$message = "";
date_default_timezone_set('Asia/Bangkok');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['username'];

    $sql = "SELECT id, username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $username = $row['username'];

        $date = date('Y-m-d');
        $time_in = date('H:i:s');

        $sql = "INSERT INTO attendance (users_id, username, date, time_in) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $username, $date, $time_in);

        if ($stmt->execute()) {
            $message = "<strong>✅ บันทึกเวลาเข้าเรียบร้อยแล้ว</strong><br>วันที่: $date<br>เวลาเข้า: $time_in<br>ชื่อผู้ใช้: $username";

            $select_token = $conn->query("SELECT * FROM token");

            while ($row = $select_token->fetch_assoc()) {
                include('api/discord_api.php');
                
                $data_checkin = [
                    "username" => $username,
                    "date" => $date,
                    "time_in" => $time_in
                ];
            
                // เรียกใช้ฟังก์ชันส่งข้อมูลไปยัง Discord
                send_to_discord($data_checkin);
            
                $url = "http://192.168.1.140:8000/"; 

                // ตั้งค่าหัวข้อ (Headers) สำหรับการส่งข้อมูลเป็น JSON
                $headers = [
                    "Content-Type: application/json"
                ];

                // แปลงข้อมูลเป็น JSON
                $json_data = json_encode($data_checkin);

                // ใช้ cURL ส่งข้อมูลไปยัง Flask API
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  // กำหนด Headers
                curl_setopt($ch, CURLOPT_POST, true);  // ใช้ POST
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);  // ส่งข้อมูล
            }
            
            // หมายเหตุ: ไม่ใช้ return ภายใน while loop
            
        } else {
            $message = "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    } else {
        $message = "ไม่พบข้อมูลผู้ใช้ในระบบ";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกเวลาเข้า</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 14px 28px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .nav-link {
            margin: 10px;
            display: inline-block;
            color: #007BFF;
            text-decoration: none;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 20px;
            color: #333;
            font-size: 15px;
            line-height: 1.6;
        }

        @media (max-width: 480px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            .btn {
                width: 100%;
                font-size: 15px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>บันทึกเวลาเข้า</h2>
    
    <div>
        <a href="index.php" class="nav-link">หน้าแรก</a>
        <a href="logout.php" class="nav-link">ออกจากระบบ</a>
    </div>

    <form method="POST">
        <input type="submit" class="btn" value="🕒 บันทึกเวลาเข้า">
    </form>

    <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>