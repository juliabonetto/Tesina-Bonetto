<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar contraseña</title>
  <style>
    body { font-family: 'Montserrat', sans-serif; background:#f4f6f9; padding:30px }
    .card { max-width:480px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.08) }
    h2 { color:#2a56b4; text-align:center }
    label { display:block; margin-top:12px; font-weight:600 }
    input { width:100%; padding:10px; margin-top:6px; border-radius:6px; border:1px solid #ddd }
    .btn { margin-top:14px; padding:10px 14px; background:#2a56b4; color:#fff; border:none; border-radius:8px; cursor:pointer }
    .msg { padding:10px; border-radius:6px; margin-bottom:12px }
    .ok { background:#e8f5e9; color:#2e7d32 }
    .error { background:#fdecea; color:#c0392b }
  </style>
</head>
<body>
  <div class="card">
    <h2>Cambiar mi contraseña</h2>

    <?php if(session()->getFlashdata('success')): ?>
      <div class="msg ok"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="msg error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('usuario/actualizarPass') ?>">
      <label>Contraseña actual</label>
      <input type="password" name="actual" required>

      <label>Nueva contraseña</label>
      <input type="password" name="nueva" required minlength="6">

      <label>Confirmar nueva contraseña</label>
      <input type="password" name="confirmar" required minlength="6">

      <button type="submit" class="btn">Actualizar contraseña</button>
    </form>
  </div>
</body>
</html>
