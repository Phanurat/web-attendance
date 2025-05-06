<?php
function send_to_discord($data) {
    $webhook_url = "https://discord.com/api/webhooks/1361993042839605338/4K_aic_Y_KBQ0KiK-RCAuuwTaDFGe6syTzvQP5YpaOgz9t8q466uJbktPfL7VQUERXaf";

    $embed = [
        "title" => "🔴 พนักงานลงเวลาออกแล้ว!",
        "color" => hexdec("FF0000"),
        "description" => 
            "👤 **ชื่อผู้ใช้**: `{$data['username']}`\n" .
            "📅 **วันที่**: {$data['date']}\n" .
            "⏰ **เวลาออก**: {$data['time_out']}",
        "footer" => [
            "text" => "ZKTime System",
            "icon_url" => "https://yourdomain.com/img/img1.png"
        ],
        "timestamp" => date("c")
    ];

    $payload = json_encode([
        "username" => "ZKTime แอป",
        "avatar_url" => "https://cdn-icons-png.flaticon.com/512/1041/1041916.png",
        "embeds" => [$embed]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log('Discord Webhook Error: ' . curl_error($ch));
    }
    curl_close($ch);

    return $response;
}
?>
