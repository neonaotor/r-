<?php
session_start();
$uploadDir = "uploads/";
$codeDir = "codes/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
if (!is_dir($codeDir)) mkdir($codeDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

    // Erzeuge einen zufälligen Code für den Abruf
    $accessCode = substr(md5(time()), 0, 10);
    file_put_contents($codeDir . $accessCode, $fileName);

    echo json_encode(["message" => "Datei erfolgreich hochgeladen!", "code" => $accessCode]);
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
