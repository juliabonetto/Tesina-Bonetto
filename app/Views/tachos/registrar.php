<h1>Registrar mi Eco-Tacho</h1>


<?php if (!isset($dispositivo)): ?>
    <!-- Primer paso: ingresar código -->
    <form action="<?= base_url('buscar-tacho-por-codigo') ?>" method="post">
        <label>Código de activación (el que te mostró la ESP32)</label>
        <input type="text" name="codigo" required>
        <button type="submit">Buscar</button>
    </form>
<?php else: ?>
    <!-- Segundo paso: completar datos -->
    <form action="<?= base_url('asignar-tacho') ?>" method="post">
        <input type="hidden" name="dispositivo_id" value="<?= $dispositivo->id ?>">
       
        <label>Nombre del tacho (ya registrado)</label>
        <input type="text" value="<?= esc($dispositivo->nombre) ?>" disabled>
       
        <label>Tipo</label>
        <select name="tipo">
            <option value="residencial">Residencial</option>
            <option value="institucional">Institucional</option>
            <option value="empresarial">Empresarial</option>
            <option value="municipal">Municipal</option>
        </select>
       
        <label>Ubicación</label>
        <input type="text" name="ubicacion">
       
        <button type="submit">Asignar como propietario</button>
    </form>
<?php endif; ?>
