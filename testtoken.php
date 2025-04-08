<?php
include("db_config.php");
#$access_token = 'NHKsC7y5n/2wI7RCtg2LtgvGr9AnxBw8GUuOkc1KV5NrbQMBIPiqpm1Lzv5c3foznqTri/8rxcOlt3DsNjtEx+nJy85vRgPyDAbdHc3ypApK1nH5SQIokkKgaXk3L2hvh228SWkXngciLkCDFfa5sQdB04t89/1O/w1cDnyilFU=';

// ข้อมูลผู้รับ
#$to = 'Ccd9af2b36d4aaac6888361625a72afe9'; 
/*$url = 'https://api.line.me/v2/bot/message/push';

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
];*/

$select_token = $conn->query("SELECT * FROM token");

while ($row = $select_token->fetch_assoc()) {
    #echo "Token ID: " . $row["token_id"] . "<br>";
    if ($row["action"] == 1){
        echo "Token ID : " . $row["token_id"] . "<br>";
        echo "Token Bot : " . $row["token_bot"] . "<br>";
        echo "Token Group : " . $row["token_group"] . "<br>";
        echo "ชื่อไลน์แจ้งเตือน : " . $row["name"] . "<br>";
    }
        
}

?>