<!DOCTYPE html>
<html>
<head>
    <title>Unirse a EcoScam</title>
</head>
<body>

<h1>Unirse a un EcoScam</h1>

<form action="<?= base_url('procesar-union') ?>" method="post">

    <label>Código EcoScam</label>

    <input
        type="text"
        name="codigo"
        required
    >

    <button type="submit">
        Unirse
    </button>

</form>

</body>
</html>