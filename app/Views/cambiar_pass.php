<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar contraseña</title>
  <style>
    body { 
      font-family: 'Roboto', sans-serif; 
      margin: 0; 
      padding: 0; 
      background-color: rgba(218, 255, 227, 0.73); /* Fondo verde translúcido */
    }
    .card { 
      max-width:480px; 
      margin:50px auto; 
      background: rgba(255,255,255,0.95); /* Blanco con transparencia */
      padding:20px; 
      border-radius:12px; 
      box-shadow:0 6px 18px rgba(0,0,0,0.15); 
      border:2px solid rgba(63, 199, 92, 0.8); /* Verde translúcido */
    }
    h2 { 
      color: rgba(27, 94, 32, 1); /* Verde oscuro sólido */
      text-align:center 
    }
    label { 
      display:block; 
      margin-top:12px; 
      font-weight:600; 
      color: rgba(46, 125, 50, 1); /* Verde medio */
    }
    input { 
      width:100%; 
      padding:10px; 
      margin-top:6px; 
      border-radius:6px; 
      border:1px solid rgba(165, 214, 167, 1); /* Verde suave */
      background-color: rgba(232, 245, 233, 0.8); /* Verde muy claro translúcido */
    }
    .btn { 
      margin-top:14px; 
      padding:10px 14px; 
      background: rgba(67, 160, 71, 1); /* Verde medio */
      color:#fff; 
      border:none; 
      border-radius:8px; 
      cursor:pointer; 
      transition:background 0.3s 
    }
    .btn:hover { 
      background: rgba(27, 94, 32, 1); /* Verde más oscuro al pasar el mouse */
    }
    .msg { 
      padding:10px; 
      border-radius:6px; 
      margin-bottom:12px 
    }
    .ok { 
      background: rgba(232, 245, 233, 1); /* Verde claro */
      color: rgba(27, 94, 32, 1) /* Texto verde oscuro */
    }
    .error { 
      background: rgba(255, 235, 238, 1); /* Rojo claro para contraste */
      color: rgba(198, 40, 40, 1) /* Texto rojo oscuro */
    }
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
