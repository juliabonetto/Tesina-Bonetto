<!DOCTYPE html>

<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>Unirse a EcoScam</title>

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

input{
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

.success{
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

<h1>Unirse a EcoScam</h1>

<p>
    Ingresá el código de activación del Eco-Tacho.
</p>

<?php if (session()->getFlashdata('error')): ?>

<div class="error">
    <?= esc(session()->getFlashdata('error')) ?>
</div>

<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>

<div class="success">
    <?= esc(session()->getFlashdata('success')) ?>
</div>

<?php endif; ?>

<form action="<?= base_url('procesar-union') ?>" method="post">

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

<button type="submit">
    ➕ Unirse al EcoScam
</button>

</form>

</div>

</div>

</body>

</html>
