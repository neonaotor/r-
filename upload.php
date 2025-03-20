<?php
session_start();
$uploadDir = "uploads/";
$codeDir = "codes/";

if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
if (!is_dir($codeDir)) mkdir($codeDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = json_decode(file_get_contents("php://input"), true)['content'];
    $fileName = "scan_" . time() . ".txt";
    file_put_contents($uploadDir . $fileName, $content);

    $accessCode = substr(md5(time()), 0, 10);
    file_put_contents($codeDir . $accessCode, $fileName);

    echo json_encode(["message" => "Datei gespeichert!", "code" => $accessCode]);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])) {
    $code = $_GET['code'];
    if (file_exists($codeDir . $code)) {
        $fileName = file_get_contents($codeDir . $code);
        echo json_encode(["file" => $fileName, "download_url" => $uploadDir . $fileName]);
    } else {
        echo json_encode(["error" => "Ungültiger Code!"]);
    }
}
?>
