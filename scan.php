<?php
if (!isset($_GET['action'])) {
    echo json_encode(["error" => "Keine Aktion angegeben!"]);
    exit;
}

if ($_GET['action'] == 'processes') {
    $processList = shell_exec("tasklist");
    $lines = explode("\n", trim($processList));
    echo json_encode(array_slice($lines, 3));  // Entferne Kopfzeilen
}

if ($_GET['action'] == 'files') {
    $suspiciousDirs = ["C:\\Cheats", "C:\\Users\\" . get_current_user() . "\\Downloads", "C:\\Windows\\Temp"];
    $foundFiles = [];

    foreach ($suspiciousDirs as $dir) {
        if (is_dir($dir)) {
            foreach (glob("$dir/*") as $file) {
                $foundFiles[] = $file;
            }
        }
    }

    echo json_encode($foundFiles);
}
?>
