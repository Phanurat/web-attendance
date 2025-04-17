<?php
function send_to_discord($data) {
    $webhook_url = "https://discord.com/api/webhooks/1361993042839605338/4K_aic_Y_KBQ0KiK-RCAuuwTaDFGe6syTzvQP5YpaOgz9t8q466uJbktPfL7VQUERXaf";

    $json_data = json_encode([
        "username" => "ZKTime แอป",
        "avatar_url" => "https://cdn-icons-png.flaticon.com/512/1041/1041916.png",
        "embeds" => [[
            "title" => "🔴 พนักงานลงเวลาออกแล้ว!",
            "color" => hexdec("FF0000"),
            "description" =>
                "\n👤 ชื่อผู้ใช้ : `{$data['username']}`\n\n" .
                "📅 วันที่ : {$data['date']}\n\n" .
                "⏰ เวลาเข้า : {$data['time_in']}",
            "footer" => [
                "text" => "ZKTime System",
                "icon_url" => "https://yourdomain.com/img/img1.png"
            ],
            "timestamp" => date("c")
        ]]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
