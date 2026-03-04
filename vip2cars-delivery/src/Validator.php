<?php
namespace VIP2;

class Validator
{
    public static function validateVehicle(array $data, ?\VIP2\VehicleModel $model = null, ?int $excludeId = null): array
    {
        $errors = [];

        $placa = strtoupper(trim($data['placa'] ?? ''));
        if ($placa === '') {
            $errors['placa'] = 'La placa es obligatoria.';
        } else {
            // allow user input like ABC123 or ABC-123 and normalize
            if (preg_match('/^([A-Z]{3})[- ]?(\d{3})$/i', $placa, $m)) {
                $placa = strtoupper($m[1] . '-' . $m[2]);
            }
            if (!preg_match('/^[A-Z]{3}-\d{3}$/', $placa)) {
                $errors['placa'] = 'Formato inválido. Use ABC-123.';
            } else {
                if ($model) {
                    $existing = $model->findByPlaca($placa);
                    if ($existing && ($excludeId === null || (int)$existing['id'] !== (int)$excludeId)) {
                        $errors['placa'] = 'La placa ya existe.';
                    }
                }
            }
        }

        $correo = trim($data['correo'] ?? '');
        if ($correo === '') {
            $errors['correo'] = 'El correo es obligatorio.';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = 'Correo inválido.';
        }

        $telefono = trim($data['telefono'] ?? '');
        if ($telefono === '') {
            $errors['telefono'] = 'El teléfono es obligatorio.';
        } elseif (!preg_match('/^[0-9+\s\-]{6,20}$/', $telefono)) {
            $errors['telefono'] = 'Teléfono inválido.';
        }

        $anio = trim($data['anio'] ?? '');
        if ($anio === '') {
            $errors['anio'] = 'El año es obligatorio.';
        } else {
            if (!preg_match('/^\d{4}$/', $anio)) {
                $errors['anio'] = 'Año inválido. Use formato YYYY.';
            } else {
                $y = (int)$anio;
                $current = (int)date('Y');
                $max = $current + 1;
                if ($y < 1900 || $y > $max) {
                    $errors['anio'] = "Año fuera de rango (1900 - $max).";
                }
            }
        }

        // Required simple fields
        $required = ['marca' => 'La marca es obligatoria.', 'modelo' => 'El modelo es obligatorio.', 'nombre' => 'El nombre es obligatorio.', 'apellidos' => 'Los apellidos son obligatorios.', 'documento' => 'El nro. de documento es obligatorio.'];
        foreach ($required as $field => $msg) {
            $val = trim($data[$field] ?? '');
            if ($val === '') $errors[$field] = $msg;
        }

        return $errors;
    }
}
