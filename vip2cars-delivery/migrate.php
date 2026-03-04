<?php
// Simple migration runner: ejecuta todos los .sql en la carpeta sql/
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) mkdir($dataDir, 0777, true);
$dbFile = $dataDir . '/database.sqlite';
try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlFiles = glob(__DIR__ . '/sql/*.sql');
    foreach ($sqlFiles as $file) {
        echo "Ejecutando: $file\n";
        $sql = file_get_contents($file);
        try {
            $pdo->exec($sql);
            echo "OK\n";
        } catch (Exception $e) {
            echo "Error en $file: " . $e->getMessage() . "\n";
        }
    }

    echo "Migraciones finalizadas. DB: $dbFile\n";
} catch (Exception $e) {
    echo "No se pudo abrir o crear la base de datos: " . $e->getMessage() . "\n";
}
