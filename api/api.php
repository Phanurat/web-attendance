<?php
// ใส่ Channel Access Token ของคุณที่นี่
$access_token = 'NHKsC7y5n/2wI7RCtg2LtgvGr9AnxBw8GUuOkc1KV5NrbQMBIPiqpm1Lzv5c3foznqTri/8rxcOlt3DsNjtEx+nJy85vRgPyDAbdHc3ypApK1nH5SQIokkKgaXk3L2hvh228SWkXngciLkCDFfa5sQdB04t89/1O/w1cDnyilFU=';

// ข้อมูลผู้รับ
$to = 'Ccd9af2b36d4aaac6888361625a72afe9'; // สามารถใช้ user ID หรือ group ID

// ข้อความที่คุณต้องการส่ง
$message = 'บันทึกเวลาออกเรียบร้อย';

// ข้อมูลที่ส่งไปยัง LINE API
$data = [
    'to' => $to,
    'messages' => [
        [
            'type' => 'text',
            'text' => $message
        ]
    ]
];

// เรียกใช้งาน LINE API
$url = 'https://api.line.me/v2/bot/message/push';

// กำหนด header
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
];

// เริ่มต้น cURL session
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// ส่งคำขอและรับผลลัพธ์
$response = curl_exec($ch);

// ปิด cURL session
curl_close($ch);

// ตรวจสอบการตอบกลับจาก API
if ($response === false) {
    echo "เกิดข้อผิดพลาดในการส่งข้อความ";
} else {
    echo "ข้อความถูกส่งสำเร็จ";
}
?>


