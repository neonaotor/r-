<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$uploadDir = "uploads/";
$codeDir = "codes/";

if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
if (!is_dir($codeDir)) mkdir($codeDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    // Prüfe, ob eine ZIP-Datei hochgeladen wird
    if (pathinfo($fileName, PATHINFO_EXTENSION) !== "zip") {
        echo json_encode(["error" => "Nur ZIP-Dateien erlaubt!"]);
        exit;
    }

    // Prüfen, ob die Datei tatsächlich hochgeladen wurde
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo json_encode(["error" => "Fehler beim Hochladen der Datei!"]);
        exit;
    }

    // Erzeuge einen zufälligen Code für den Abruf
    $accessCode = substr(md5(time()), 0, 10);
    file_put_contents($codeDir . $accessCode, $fileName);

    // JSON korrekt ausgeben
    header('Content-Type: application/json');
    echo json_encode(["message" => "Datei erfolgreich hochgeladen!", "code" => $accessCode]);
    exit;
}

// Falls GET-Anfrage für Code-Eingabe kommt
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])) {
    $code = $_GET['code'];
    if (file_exists($codeDir . $code)) {
        $fileName = file_get_contents($codeDir . $code);
        echo json_encode(["file" => $fileName, "download_url" => $uploadDir . $fileName]);
    } else {
        echo json_encode(["error" => "Ungültiger Code!"]);
    }
    exit;
}

// Falls keine gültige Anfrage kommt
echo json_encode(["error" => "Ungültige Anfrage"]);
exit;
?>
