<h1>Registrar EcoScam</h1>

<form action="<?= base_url('guardar-tacho') ?>" method="post">

    <label>Nombre</label>
    <input type="text" name="nombre" required>

    <br><br>

    <label>Tipo</label>

    <select name="tipo">

        <option value="residencial">
            Residencial
        </option>

        <option value="institucional">
            Institucional
        </option>

        <option value="empresarial">
            Empresarial
        </option>

        <option value="municipal">
            Municipal
        </option>

    </select>

    <br><br>

    <label>Ubicación</label>
    <input type="text" name="ubicacion">

    <br><br>

    <label>Código de activación</label>
    <input type="text" name="codigo">

    <br><br>

    <button type="submit">
        Registrar
    </button>

</form>