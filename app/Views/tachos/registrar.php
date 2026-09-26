<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Registrar Eco-Tacho | EcoS-cam</title>

<style>
body{
    margin:0;
    background:#f7faf7;
    font-family:system-ui;
    color:#1c2620
}

.container{
    max-width:900px;
    margin:auto;
    padding:35px 20px
}

.btn{
    display:inline-block;
    text-decoration:none;
    background:#2f7a3f;
    color:#fff;
    padding:12px 18px;
    border-radius:12px
}

.box{
    background:#fff;
    border:1px solid #dfe8e1;
    border-radius:18px;
    padding:30px;
    margin-top:20px
}

label{
    display:block;
    font-weight:700;
    margin:15px 0 7px
}

input,select{
    width:100%;
    padding:13px;
    border:1px solid #dfe8e1;
    border-radius:10px;
    box-sizing:border-box
}

button{
    width:100%;
    margin-top:20px;
    padding:14px;
    border:0;
    border-radius:12px;
    background:#2f7a3f;
    color:#fff;
    font-weight:700;
    cursor:pointer
}

.error{
    background:#fdeaea;
    color:#a32121;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px
}

.info{
    background:#e8f4ea;
    color:#1f4d2b;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px
}
</style>

</head>

<body>

<div class="container">

<a class="btn" href="<?= site_url('mis-tachos') ?>">
    ← Volver
</a>

<div class="box">

<h1>Registrar Eco-Tacho</h1>

<p>Ingresá el código que te mostró la ESP32.</p>

<?php if (session()->getFlashdata('error')): ?>

```
<div class="error">
    <?= esc(session()->getFlashdata('error')) ?>
</div>
```

<?php endif; ?>

<?php if (session()->getFlashdata('warning')): ?>

```
<div class="error">
    <?= esc(session()->getFlashdata('warning')) ?>
</div>
```

<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>

```
<div class="info">
    <?= esc(session()->getFlashdata('success')) ?>
</div>
```

<?php endif; ?>

<form action="<?= base_url('guardar-tacho') ?>" method="post">

<?= csrf_field() ?>

<label for="codigo_activacion">
    Código de activación
</label>

<input
id="codigo_activacion"
name="codigo_activacion"
maxlength="6"
minlength="6"
style="text-transform:uppercase"
required

>

<label for="nombre">
    Nombre del Eco-Tacho
</label>

<input
id="nombre"
name="nombre"
placeholder="Ej. Eco-Tacho 1"
required

>

<label for="tipo">
    Tipo
</label>

<select name="tipo" id="tipo" required>

```
<option value="">
    Seleccioná un tipo
</option>

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
```

</select>

<label for="ubicacion">
    Ubicación
</label>

<input
name="ubicacion"
id="ubicacion"
placeholder="Ej. Cocina, oficina"

>

<button type="submit">
    ♻️ Registrar Eco-Tacho
</button>

</form>

</div>

</div>

</body>
</html>
