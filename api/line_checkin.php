<?php
function send_to_discord($data) {
    $json_data = json_encode([
        "username" => "ZKTime แอป",
        "avatar_url" => "https://cdn-icons-png.flaticon.com/512/1041/1041916.png",
        "embeds" => [[
            "title" => "🟢 เช็คอินแล้ว!",
            "color" => hexdec("00FF00"),
            "description" =>
                "\n👤 ชื่อผู้ใช้ : `{$data['username']}`\n\n" .
                "📅 วันที่ : {$data['date']}\n\n" .
                "⏰ เวลาเข้า : {$data['time_in']}",
            "footer" => [
                "text" => "ZKTime System",
                "icon_url" => "https://cdn-icons-png.flaticon.com/512/847/847969.png"
            ],
            "timestamp" => date("c")
        ]]
    ], 
}
?>
