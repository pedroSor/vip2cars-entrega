<?php
// Script to initialize the SQLite database and create tables
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) mkdir($dataDir, 0777, true);
$dbFile = $dataDir . '/database.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("CREATE TABLE IF NOT EXISTS vehicles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    placa TEXT NOT NULL,
    marca TEXT,
    modelo TEXT,
    anio TEXT,
    nombre TEXT,
    apellidos TEXT,
    documento TEXT,
    correo TEXT,
    telefono TEXT,
    created_at TEXT,
    updated_at TEXT
)");

echo "Base de datos inicializada en: " . $dbFile . "\n";
echo "Abra public/index.php en su navegador.\n";
