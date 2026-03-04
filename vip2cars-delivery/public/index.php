<?php
require __DIR__ . '/../src/VehicleModel.php';
require __DIR__ . '/../src/Validator.php';

session_start();

$model = new \VIP2\VehicleModel();

$action = $_REQUEST['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $placaInput = trim($_POST['placa'] ?? '');
    // normalize placa input (ABC123 -> ABC-123) and uppercase
    if (preg_match('/^([A-Za-z]{3})[- ]?(\d{3})$/', $placaInput, $m)) {
        $placaNorm = strtoupper($m[1] . '-' . $m[2]);
    } else {
        $placaNorm = strtoupper($placaInput);
    }

    $data = [
        'placa' => $placaNorm,
        'marca' => $_POST['marca'] ?? '',
        'modelo' => $_POST['modelo'] ?? '',
        'anio' => $_POST['anio'] ?? '',
        'nombre' => $_POST['nombre'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'documento' => $_POST['documento'] ?? '',
        'correo' => $_POST['correo'] ?? '',
        'telefono' => $_POST['telefono'] ?? ''
    ];

    $errors = \VIP2\Validator::validateVehicle($data, $model, null);
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $data;
        header('Location: index.php?action=new');
        exit;
    }

    try {
        $model->create($data);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registro creado.'];
    } catch (\Exception $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error al crear: ' . $e->getMessage()];
    }
    header('Location: index.php');
    exit;
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $placaInput = trim($_POST['placa'] ?? '');
    if (preg_match('/^([A-Za-z]{3})[- ]?(\d{3})$/', $placaInput, $m)) {
        $placaNorm = strtoupper($m[1] . '-' . $m[2]);
    } else {
        $placaNorm = strtoupper($placaInput);
    }

    $data = [
        'placa' => $placaNorm,
        'marca' => $_POST['marca'] ?? '',
        'modelo' => $_POST['modelo'] ?? '',
        'anio' => $_POST['anio'] ?? '',
        'nombre' => $_POST['nombre'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'documento' => $_POST['documento'] ?? '',
        'correo' => $_POST['correo'] ?? '',
        'telefono' => $_POST['telefono'] ?? ''
    ];
    $errors = \VIP2\Validator::validateVehicle($data, $model, $id);
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $data;
        header('Location: index.php?action=edit&id=' . $id);
        exit;
    }

    try {
        $model->update($id, $data);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registro actualizado.'];
    } catch (\Exception $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error al actualizar: ' . $e->getMessage()];
    }
    header('Location: index.php');
    exit;
}

if ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    try {
        if ($id) $model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registro eliminado.'];
    } catch (\Exception $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error al eliminar: ' . $e->getMessage()];
    }
    header('Location: index.php');
    exit;
}

if ($action === 'new') {
    $vehicle = null;
    include __DIR__ . '/../templates/form.php';
    exit;
}

if ($action === 'edit') {
    $id = intval($_GET['id'] ?? 0);
    $vehicle = $model->find($id);
    include __DIR__ . '/../templates/form.php';
    exit;
}

$q = trim($_GET['q'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;
$total = $model->countAll($q);
$vehicles = $model->all($q, $perPage, $offset);
include __DIR__ . '/../templates/list.php';
