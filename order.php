<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $webhook_url = "https://discord.com/api/webhooks/1349850414543142912/6ujUtioGiTKVrXMrs-dQbB83Ss5799TzqwczsAdxyeroOXcvaX-ALTRetR25_RywY-D5";

    $product = $_POST["product"];
    $name = $_POST["name"];
    $date = date("d.m.Y H:i");

    $data = [
        "username" => "Goodboy Shop",
        "avatar_url" => "https://via.placeholder.com/100",
        "embeds" => [[
            "title" => "🛒 **Neue Bestellung erhalten!**",
            "color" => 16753920,
            "fields" => [
                ["name" => "🛍️ **Produkt:**", "value" => "**$product**", "inline" => false],
                ["name" => "👤 **Besteller:**", "value" => "**$name**", "inline" => false],
                ["name" => "📅 **Bestellzeit:**", "value" => "**$date**", "inline" => false]
            ],
            "footer" => ["text" => "Goodboy Shop - Powered by Discord"]
        ]]
    ];

    $json_data = json_encode($data);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo "<h2 style='color:limegreen;'>✅ Bestellung erfolgreich gesendet!</h2>";
}
?>