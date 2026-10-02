<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width,initial-scale=1"
>

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

h1{
    margin-top:0;
}

h2{
    margin-top:25px;
}

label{
    display:block;
    font-weight:700;
    margin:15px 0 7px
}

input,
select{
    width:100%;
    padding:13px;
    border:1px solid #dfe8e1;
    border-radius:10px;
    box-sizing:border-box;
    font-family:inherit;
    font-size:15px;
}

input:disabled{
    background:#f1f3f1;
    color:#555;
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
    cursor:pointer;
    font-size:15px;
}

button:hover{
    background:#256333;
}

.error{
    background:#fdeaea;
    color:#a32121;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
}

.info{
    background:#e8f4ea;
    color:#1f4d2b;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
}

.success-box{
    background:#e8f4ea;
    color:#1f4d2b;
    padding:16px;
    border-radius:12px;
    margin:20px 0;
}

.ayuda{
    color:#66736a;
    font-size:14px;
    margin-top:6px;
}

.separador{
    height:1px;
    background:#e1e8e2;
    margin:25px 0;
}

</style>

</head>

<body>

<div class="container">

<a
    class="btn"
    href="<?= site_url('mis-tachos') ?>"
>
    ← Volver
</a>

<div class="box">

<h1>Registrar Eco-Tacho</h1>


<?php if (session()->getFlashdata('error')): ?>

<div class="error">
    <?= esc(session()->getFlashdata('error')) ?>
</div>

<?php endif; ?>


<?php if (session()->getFlashdata('warning')): ?>

<div class="error">
    <?= esc(session()->getFlashdata('warning')) ?>
</div>

<?php endif; ?>


<?php if (session()->getFlashdata('success')): ?>

<div class="info">
    <?= esc(session()->getFlashdata('success')) ?>
</div>

<?php endif; ?>


<?php if (!isset($dispositivo)): ?>


<!-- ====================================================== -->
<!-- PASO 1: INGRESAR CÓDIGO                                -->
<!-- ====================================================== -->

<h2>Buscar Eco-Tacho</h2>

<p>
    Ingresá el código de activación que te mostró la ESP32.
</p>

<form
    action="<?= base_url('buscar-tacho-por-codigo') ?>"
    method="post"
>

<?= csrf_field() ?>

<label for="codigo">
    Código de activación
</label>

<input
    id="codigo"
    name="codigo"
    maxlength="6"
    minlength="6"
    placeholder="Ej. ABC123"
    style="text-transform:uppercase"
    value="<?= old('codigo') ?>"
    required
>

<div class="ayuda">
    Ingresá los 6 caracteres del código que aparece en la
    configuración de tu Eco-Tacho.
</div>

<button type="submit">
    🔍 Buscar Eco-Tacho
</button>

</form>


<?php else: ?>


<!-- ====================================================== -->
<!-- PASO 2: CONFIGURAR EL TACHO                            -->
<!-- ====================================================== -->

<h2>Eco-Tacho encontrado</h2>

<div class="success-box">

<strong>✅ Eco-Tacho encontrado correctamente</strong>

<p>
    El código ingresado corresponde a este Eco-Tacho.
</p>

</div>


<form
    action="<?= base_url('asignar-tacho') ?>"
    method="post"
>

<?= csrf_field() ?>


<input
    type="hidden"
    name="dispositivo_id"
    value="<?= esc($dispositivo->id) ?>"
>


<!-- ------------------------------------------------------ -->
<!-- CÓDIGO                                                 -->
<!-- ------------------------------------------------------ -->

<label for="codigo_mostrado">
    Código de activación
</label>

<input
    id="codigo_mostrado"
    value="<?= esc($dispositivo->codigo_activacion) ?>"
    disabled
>


<!-- ------------------------------------------------------ -->
<!-- NOMBRE                                                 -->
<!-- ------------------------------------------------------ -->

<label for="nombre">
    Nombre del Eco-Tacho
</label>

<input
    id="nombre"
    name="nombre"
    value="<?= esc($dispositivo->nombre) ?>"
    required
>

<div class="ayuda">
    Este es el nombre que configuraste desde el celular.
    Podés editarlo si lo escribiste incorrectamente.
</div>


<div class="separador"></div>


<!-- ------------------------------------------------------ -->
<!-- TIPO                                                   -->
<!-- ------------------------------------------------------ -->

<label for="tipo">
    Tipo
</label>

<select
    name="tipo"
    id="tipo"
    required
>

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

</select>


<!-- ------------------------------------------------------ -->
<!-- UBICACIÓN                                              -->
<!-- ------------------------------------------------------ -->

<label for="ubicacion">
    Ubicación
</label>

<input
    name="ubicacion"
    id="ubicacion"
    placeholder="Ej. Cocina, oficina"
    value="<?= esc($dispositivo->ubicacion ?? '') ?>"
    required
>


<!-- ------------------------------------------------------ -->
<!-- CONFIRMAR                                              -->
<!-- ------------------------------------------------------ -->

<button type="submit">
    ✅ Asignar como propietario
</button>

</form>


<?php endif; ?>

</div>

</div>

</body>

</html>