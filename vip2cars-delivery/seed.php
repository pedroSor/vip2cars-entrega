<?php
// Seed de ejemplo para la tabla vehicles
require __DIR__ . '/src/VehicleModel.php';

$model = new \VIP2\VehicleModel();

$samples = [
    ['placa'=>'ABC-123','marca'=>'Toyota','modelo'=>'Corolla','anio'=>'2018','nombre'=>'Juan','apellidos'=>'Pérez','documento'=>'12345678','correo'=>'juan.perez@example.com','telefono'=>'987654321'],
    ['placa'=>'XYZ-987','marca'=>'Honda','modelo'=>'Civic','anio'=>'2020','nombre'=>'María','apellidos'=>'González','documento'=>'87654321','correo'=>'maria.g@example.com','telefono'=>'912345678'],
    ['placa'=>'LMN-456','marca'=>'Ford','modelo'=>'Focus','anio'=>'2017','nombre'=>'Carlos','apellidos'=>'Ramírez','documento'=>'11223344','correo'=>'carlos.r@example.com','telefono'=>'923456789']
];

try {
    foreach ($samples as $s) {
        $model->create($s);
    }
    echo "Semillas insertadas\n";
} catch (Exception $e) {
    echo "Error al insertar semillas: " . $e->getMessage() . "\n";
}
