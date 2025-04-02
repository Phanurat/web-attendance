<?php
$servername = "localhost";  // ชื่อของ service ใน docker-compose.yml
$username = "root";
$password = "";
$dbname = "attendance";  // ชื่อฐานข้อมูลที่ใช้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}else{
    #echo "Connect Successfully";
}
?>
