<?php
ob_start();
?>

<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert alert-<?= htmlspecialchars($f['type']) ?>" role="alert"><?= htmlspecialchars($f['message']) ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <a href="index.php?action=new" class="btn btn-primary me-2"><i class="bi bi-plus-lg"></i> Nuevo vehículo</a>
        <a href="../init_db.php" class="btn btn-outline-secondary"><i class="bi bi-database-fill-add"></i> (Re)crear BBDD</a>
    </div>
    <div class="d-flex align-items-center gap-2">
        <div class="text-muted small">Total: <?= count($vehicles) ?></div>
        <div class="btn-group btn-group-sm" role="group" aria-label="view toggle">
            <button id="btn-table" class="btn btn-outline-secondary active"><i class="bi bi-list"></i></button>
            <button id="btn-cards" class="btn btn-outline-secondary"><i class="bi bi-grid-3x3-gap-fill"></i></button>
        </div>
    </div>
</div>

<form method="get" class="mb-3">
  <div class="input-group">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input id="search" name="q" value="<?= htmlspecialchars($q ?? '') ?>" type="search" class="form-control" placeholder="Buscar por placa, marca, cliente...">
    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
  </div>
</form>

<div id="table-view" class="table-responsive">
    <table class="table align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Marca / Modelo</th>
            <th>Año</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th class="text-end">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicles as $v): ?>
            <tr class="vehicle-row">
                <td class="fw-bold">#<?= $v['id'] ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($v['placa']) ?></span></td>
                <td><?= htmlspecialchars($v['marca'] . ' / ' . $v['modelo']) ?></td>
                <td><?= htmlspecialchars($v['anio']) ?></td>
                <td><?= htmlspecialchars($v['nombre'] . ' ' . $v['apellidos']) ?></td>
                <td><?= htmlspecialchars($v['correo']) ?><br><small class="text-muted"><?= htmlspecialchars($v['telefono']) ?></small></td>
                <td class="text-end">
                    <a href="index.php?action=edit&id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i></a>
                    <a href="index.php?action=delete&id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar este registro?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="cards-view" class="cards-grid d-none">
  <?php foreach ($vehicles as $v): ?>
    <div class="card vehicle-card" data-search="<?= htmlspecialchars(strtolower($v['placa'].' '.$v['marca'].' '.$v['modelo'].' '.$v['nombre'].' '.$v['apellidos'])) ?>">
      <div class="card-body d-flex justify-content-between align-items-start gap-3">
        <div>
          <h5 class="card-title mb-1"><?= htmlspecialchars($v['marca'] . ' ' . $v['modelo']) ?></h5>
          <p class="mb-1"><span class="badge bg-info text-dark"><?= htmlspecialchars($v['placa']) ?></span> • <?= htmlspecialchars($v['anio']) ?></p>
          <p class="mb-0 small text-muted"><?= htmlspecialchars($v['nombre'] . ' ' . $v['apellidos']) ?> — <?= htmlspecialchars($v['correo']) ?> • <?= htmlspecialchars($v['telefono']) ?></p>
        </div>
        <div class="text-end">
          <a href="index.php?action=edit&id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-warning mb-1"><i class="bi bi-pencil-square"></i></a>
          <a href="index.php?action=delete&id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar este registro?')"><i class="bi bi-trash"></i></a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php
// Paginación simple
$pages = max(1, (int)ceil(($total ?? 0) / ($perPage ?? 10)));
if ($pages > 1): ?>
  <nav aria-label="Paginación" class="mt-3">
    <ul class="pagination justify-content-center">
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?q=<?= urlencode($q) ?>&page=<?= $page-1 ?>">Anterior</a>
      </li>
      <?php for ($p = 1; $p <= $pages; $p++): ?>
        <li class="page-item <?= $p == $page ? 'active' : '' ?>"><a class="page-link" href="?q=<?= urlencode($q) ?>&page=<?= $p ?>"><?= $p ?></a></li>
      <?php endfor; ?>
      <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
        <a class="page-link" href="?q=<?= urlencode($q) ?>&page=<?= $page+1 ?>">Siguiente</a>
      </li>
    </ul>
  </nav>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';

