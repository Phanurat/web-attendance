<?php
$access_token = 'NHKsC7y5n/2wI7RCtg2LtgvGr9AnxBw8GUuOkc1KV5NrbQMBIPiqpm1Lzv5c3foznqTri/8rxcOlt3DsNjtEx+nJy85vRgPyDAbdHc3ypApK1nH5SQIokkKgaXk3L2hvh228SWkXngciLkCDFfa5sQdB04t89/1O/w1cDnyilFU=';

// ข้อมูลผู้รับ
$to = 'Ccd9af2b36d4aaac6888361625a72afe9'; 
$url = 'https://api.line.me/v2/bot/message/push';

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
];

?>