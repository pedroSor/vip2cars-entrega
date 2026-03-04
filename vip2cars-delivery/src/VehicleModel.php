<?php
namespace VIP2;

use PDO;

class VehicleModel
{
    private $pdo;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../data/database.sqlite';
        $dsn = 'sqlite:' . $dbPath;
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all(string $q = null, ?int $limit = null, int $offset = 0)
    {
        $sql = 'SELECT * FROM vehicles';
        $params = [];
        if ($q) {
            $sql .= ' WHERE placa LIKE :q OR marca LIKE :q OR modelo LIKE :q OR nombre LIKE :q OR apellidos LIKE :q';
            $params[':q'] = "%$q%";
        }
        $sql .= ' ORDER BY id DESC';
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_STR);
        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(string $q = null): int
    {
        $sql = 'SELECT COUNT(*) FROM vehicles';
        $params = [];
        if ($q) {
            $sql .= ' WHERE placa LIKE :q OR marca LIKE :q OR modelo LIKE :q OR nombre LIKE :q OR apellidos LIKE :q';
            $params[':q'] = "%$q%";
        }
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function find(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM vehicles WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByPlaca(string $placa)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM vehicles WHERE placa = ?');
        $stmt->execute([$placa]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO vehicles (placa, marca, modelo, anio, nombre, apellidos, documento, correo, telefono, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, datetime("now"), datetime("now"))');
        return $stmt->execute([
            $data['placa'], $data['marca'], $data['modelo'], $data['anio'], $data['nombre'], $data['apellidos'], $data['documento'], $data['correo'], $data['telefono']
        ]);
    }

    public function update(int $id, array $data)
    {
        $stmt = $this->pdo->prepare('UPDATE vehicles SET placa = ?, marca = ?, modelo = ?, anio = ?, nombre = ?, apellidos = ?, documento = ?, correo = ?, telefono = ?, updated_at = datetime("now") WHERE id = ?');
        return $stmt->execute([
            $data['placa'], $data['marca'], $data['modelo'], $data['anio'], $data['nombre'], $data['apellidos'], $data['documento'], $data['correo'], $data['telefono'], $id
        ]);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM vehicles WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
