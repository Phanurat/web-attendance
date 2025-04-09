<?php
session_start();
include('db_config.php');
date_default_timezone_set('Asia/Bangkok');

if (!isset($_SESSION['username'])) {
    echo "<div class='container'><p>กรุณาเข้าสู่ระบบก่อน <a href='login.php'>คลิกที่นี่</a></p></div>";
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['username'];
    $date = date('Y-m-d');
    $time_out = date('H:i:s');

    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];

        $sql = "UPDATE attendance SET time_out = ? WHERE username = ? AND date = ? AND time_out IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $time_out, $employee_id, $date);

        if ($stmt->execute()) {
            $message = "<strong>✅ บันทึกเวลาออกเรียบร้อยแล้ว</strong><br>วันที่: $date<br>เวลาออก: $time_out<br>ชื่อผู้ใช้: $username";

            $select_token = $conn->query("SELECT * FROM token");

            while ($row = $select_token->fetch_assoc()) {
                if ($row["action"] == 1) {
                    $data_checkout = "วันที่: " . $date . "\nเวลาออก: " . $time_out . "\nชื่อผู้ใช้: " . $username;
                    $access_token = $row['token_bot'];
                    $url = 'https://api.line.me/v2/bot/message/push';
                    $to = $row['token_group'];
                    $headers = [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $access_token
                    ];

                    $data = [
                        'to' => $to,
                        'messages' => [
                            ['type' => 'text', 'text' => $data_checkout]
                        ]
                    ];

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);

                    if ($response === false) {
                        $message .= "<br><span style='color:red;'>❌ ส่งข้อความไม่สำเร็จ: $error</span>";
                    } else {
                        $message .= "<br><span style='color:green;'>📨 ส่งข้อความ LINE สำเร็จ</span>";
                    }
                }
            }
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
    <title>บันทึกเวลาออก</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
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
            color: #444;
        }

        .btn {
            display: inline-block;
            background-color: #f44336;
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
            background-color: #d32f2f;
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
    <h2>บันทึกเวลาออก</h2>

    <div>
        <a href="index.php" class="nav-link">หน้าแรก</a>
        <a href="logout.php" class="nav-link">ออกจากระบบ</a>
    </div>

    <form method="POST">
        <input type="submit" class="btn" value="⏰ บันทึกเวลาออก">
    </form>

    <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>