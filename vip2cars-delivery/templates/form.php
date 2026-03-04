<?php
ob_start();
$isEdit = !empty($vehicle);
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
// keep old input for next request only
unset($_SESSION['errors'], $_SESSION['old']);
// normalize placa for display
$displayPlaca = $old['placa'] ?? ($isEdit ? ($vehicle['placa'] ?? '') : '');
if ($displayPlaca !== '' && preg_match('/^([A-Za-z]{3})[- ]?(\d{3})$/i', $displayPlaca, $mp)) {
    $displayPlaca = strtoupper($mp[1] . '-' . $mp[2]);
}
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= $isEdit ? 'Editar vehículo' : 'Registrar nuevo vehículo' ?></h5>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?action=<?= $isEdit ? 'edit' : 'create' ?>" class="needs-validation" novalidate>
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                    <?php endif; ?>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Placa *</label>
                            <input name="placa" class="form-control <?= isset($errors['placa']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($displayPlaca ?? '') ?>" required>
                            <div class="invalid-feedback"><?= $errors['placa'] ?? 'La placa es obligatoria.' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marca *</label>
                            <input name="marca" class="form-control <?= isset($errors['marca']) ? 'is-invalid' : '' ?>" required value="<?= htmlspecialchars($old['marca'] ?? ($isEdit ? $vehicle['marca'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['marca'] ?? 'La marca es obligatoria.' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Modelo *</label>
                            <input name="modelo" class="form-control <?= isset($errors['modelo']) ? 'is-invalid' : '' ?>" required value="<?= htmlspecialchars($old['modelo'] ?? ($isEdit ? $vehicle['modelo'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['modelo'] ?? 'El modelo es obligatorio.' ?></div>
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Año</label>
                            <?php $currentYear = (int)date('Y'); $maxYear = $currentYear + 1; ?>
                            <input name="anio" type="number" inputmode="numeric" pattern="\d{4}" min="1900" max="<?= $maxYear ?>" step="1" placeholder="YYYY" class="form-control <?= isset($errors['anio']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['anio'] ?? ($isEdit ? $vehicle['anio'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['anio'] ?? "Año inválido (1900 - $maxYear)." ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input name="nombre" class="form-control" value="<?= htmlspecialchars($old['nombre'] ?? ($isEdit ? $vehicle['nombre'] : '')) ?>">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Apellidos</label>
                            <input name="apellidos" class="form-control" value="<?= htmlspecialchars($old['apellidos'] ?? ($isEdit ? $vehicle['apellidos'] : '')) ?>">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Nro. Documento *</label>
                            <input name="documento" class="form-control <?= isset($errors['documento']) ? 'is-invalid' : '' ?>" required value="<?= htmlspecialchars($old['documento'] ?? ($isEdit ? $vehicle['documento'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['documento'] ?? 'El nro. de documento es obligatorio.' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo *</label>
                            <input name="correo" type="email" class="form-control <?= isset($errors['correo']) ? 'is-invalid' : '' ?>" required value="<?= htmlspecialchars($old['correo'] ?? ($isEdit ? $vehicle['correo'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['correo'] ?? 'El correo es obligatorio.' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono *</label>
                            <input name="telefono" class="form-control <?= isset($errors['telefono']) ? 'is-invalid' : '' ?>" required value="<?= htmlspecialchars($old['telefono'] ?? ($isEdit ? $vehicle['telefono'] : '')) ?>">
                            <div class="invalid-feedback"><?= $errors['telefono'] ?? 'El teléfono es obligatorio.' ?></div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <button class="btn btn-success" type="submit"><i class="bi bi-save2"></i> Guardar</button>
                            <a href="index.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
                        </div>
                        <?php if ($isEdit): ?>
                            <small class="text-muted align-self-center">Última actualización: <?= htmlspecialchars($vehicle['updated_at'] ?? $vehicle['created_at'] ?? '') ?></small>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
