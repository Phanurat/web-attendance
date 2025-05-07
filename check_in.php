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

function sendAsyncRequest($url, $data_checkin){
    $json_data = json_encode($data_checkin);
    $headers = ["Content-Type: application/json"];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100); 

    curl_exec($ch);
    curl_close($ch);
}

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
            
                send_to_discord($data_checkin);
                sendAsyncRequest("http://192.168.1.154:8000/", $data_checkin);
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
        .slot-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .slot {
            width: 80px;
            height: 80px;
            border: 3px solid #fff;
            border-radius: 10px;
            background: #111;
            overflow: hidden;
            position: relative;
            box-shadow: 0 0 15px #0f0;
        }

        .reel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            transition: transform 0.6s ease-out;
        }

        .symbol {
            height: 80px;
            line-height: 80px;
            font-size: 48px;
        }

        button {
            padding: 15px 30px;
            font-size: 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(to right, #ff0, #f90);
            color: black;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(to right, #f90, #ff0);
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
        <div class="message" id="message-box"><?= $message ?></div>
        <script>
            // ใช้ JavaScript เพื่อให้ข้อความแสดงทันที
            document.getElementById('message-box').style.display = 'block';
        </script>
    <?php endif; ?>
</div>
<div class="slot-container">
    <h1>🎰 สล็อตแมชชีนสุดสวย</h1>
    <?php
        // PHP: คืนค่าสุ่ม 3 รีล เมื่อมีการเรียกผ่าน AJAX
        if (isset($_GET['spin'])) {
            $symbols = ['🍒', '🍋', '🍇', '🔔', '⭐', '7️⃣'];
            $results = [
                $symbols[array_rand($symbols)],
                $symbols[array_rand($symbols)],
                $symbols[array_rand($symbols)]
            ];
            header('Content-Type: application/json');
            echo json_encode($results);
            exit;
        }
    ?>
    <div class="slot-container">
        <div class="slot"><div class="reel" id="reel1"></div></div>
        <div class="slot"><div class="reel" id="reel2"></div></div>
        <div class="slot"><div class="reel" id="reel3"></div></div>
        <button onclick="spin()">ปั่นเลย!</button>
        <script>
            function spin() {
                fetch("?spin=1")
                    .then(res => res.json())
                    .then(result => {
                        const symbols = ['🍒', '🍋', '🍇', '🔔', '⭐', '7️⃣'];
                        const reels = [result[0], result[1], result[2]];

                        for (let i = 0; i < 3; i++) {
                            const reel = document.getElementById('reel' + (i+1));
                            reel.innerHTML = '';

                            // เพิ่มสัญลักษณ์ปลอม 15 อัน
                            for (let j = 0; j < 15; j++) {
                                const el = document.createElement('div');
                                el.className = 'symbol';
                                el.textContent = symbols[Math.floor(Math.random() * symbols.length)];
                                reel.appendChild(el);
                            }

                            // เพิ่มผลลัพธ์จริง
                            const final = document.createElement('div');
                            final.className = 'symbol';
                            final.textContent = reels[i];
                            reel.appendChild(final);

                            // ใช้ setTimeout เพื่อเลื่อนแต่ละรีลช้าทีละตัว
                            setTimeout(() => {
                                reel.style.transform = `translateY(-${80 * 15}px)`;
                            }, i * 600); // 0ms, 600ms, 1200ms
                        }
                    });
            }
            </script>
    </div>
    
</div>

</body>
</html>