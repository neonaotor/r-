<?php

_start();
$uploadDir = "uploads/";
$codeDir = "codes/";

// Ordner erstellen, falls nicht vorhanden
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
if (!is_dir($codeDir)) mkdir($codeDir, 0777, true);

// Falls eine Datei hochgeladen wird
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    // Prüfe, ob es eine ZIP-Datei ist
    if (pathinfo($fileName, PATHINFO_EXTENSION) !== "zip") {
        header("Location: index.html?error=NUR+ZIP-DATEIEN+ERLAUBT!");
        exit;
    }

    // Datei speichern
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        // Code generieren
        $accessCode = substr(md5(time()), 0, 10);
        file_put_contents($codeDir . $accessCode, $fileName);
        header("Location: index.html?upload=" . $accessCode);
    } else {
        header("Location: index.html?error=Fehler+beim+Hochladen!");
    }
    exit;
}

// Falls ein Code zum Abrufen eingegeben wird
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])) {
    $code = $_GET['code'];
    if (file_exists($codeDir . $code)) {
        $fileName = file_get_contents($codeDir . $code);
        header("Location: index.html?file=" . urlencode($fileName));
    } else {
        header("Location: index.html?error=Ungültiger+Code!");
    }
    exit;
}
?>
