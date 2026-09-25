<!DOCTYPE html><html lang="es">
    <head><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mis Eco-Tachos | EcoS-cam</title><style>
:root{--g:#2f7a3f;--gd:#1f4d2b;--soft:#e8f4ea;--bg:#f7faf7;--muted:#647069}*{box-sizing:border-box}body{margin:0;background:var(--bg);font-family:system-ui;color:#1c2620}.container{max-width:1250px;margin:auto;padding:35px 20px}.top{display:flex;justify-content:space-between;align-items:center;gap:20px;background:linear-gradient(135deg,#e6f5e8,#f7fcf8);padding:35px;border-radius:18px;margin-bottom:25px}.btn{display:inline-block;text-decoration:none;background:linear-gradient(135deg,var(--g),#4ea25c);color:#fff;padding:12px 18px;border-radius:12px}.actions{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:25px}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px}.card{position:relative;background:#fff;border:1px solid #dfe8e1;border-radius:18px;padding:25px;box-shadow:0 4px 14px rgba(20,40,25,.08)}.delete{position:absolute;right:12px;top:10px;border:0;background:transparent;font-size:20px;cursor:pointer}.status{font-weight:700;color:var(--g)}.warn{color:#b3261e}@media(max-width:700px){.top{flex-direction:column;align-items:flex-start}}
</style></head><body><div class="container"><a class="btn" href="<?= site_url('usuario/principal') ?>">← Volver</a>
<div class="top"><div><h1>Mis <span style="color:var(--g)">Eco-Tachos</span></h1>
<p>Administrá tus Eco-Tachos y consultá las estadísticas de cada dispositivo.</p></div>
<strong><?= count($tachos) ?> Eco-Tachos registrados</strong></div><div class="actions">
    <a class="btn" href="<?= base_url('unirse-tacho') ?>">➕ Unirse a un EcoScam</a>
    <a class="btn" href="<?= base_url('registrar-tacho') ?>">♻️ Registrar nuevo Eco-Tacho</a></div>
    <div class="grid"><?php if(!$tachos): ?><div class="card"><h3>No tenés Eco-Tachos registrados.</h3>
        <p>Registrá uno o uníte usando un código.</p></div><?php endif; ?><?php foreach($tachos as $tacho): ?>
            <div class="card"><button class="delete" data-id="<?= $tacho->id ?>">🗑</button><h3><?= esc($tacho->nombre) ?></h3>
            <p><strong>Tipo:</strong> <?= esc($tacho->tipo) ?></p><p><strong>Ubicación:</strong>
             <?= esc($tacho->ubicacion ?? 'Sin ubicación') ?></p><p><strong>Tu rol:</strong> <?= esc($tacho->rol ?? 'lector') ?></p>
             <p class="<?= empty($tacho->habilitado) ? 'warn' : 'status' ?>">
                <?= empty($tacho->habilitado) ? '🔴 No habilitado' : '🟢 Habilitado' ?></p>
            
            
               <a class="btn" href="<?= base_url('estadisticas-tacho/'.$tacho->id) ?>">
    📊 Ver estadísticas
</a>

<a
    class="btn"
    href="http://192.168.1.150:8080/tacho/<?= (int)$tacho->id ?>"
    target="_blank"
>
    🖥️ Abrir simulación
</a>
            </div>
                <?php endforeach; ?></div></div>
                <script>document.querySelectorAll('.delete').forEach(b=>b.addEventListener('click',async()=>{if(!confirm('¿Eliminar este Eco-Tacho de tu lista?'))return;const id=b.dataset.id;const fd=new URLSearchParams();<?php if(function_exists('csrf_token')): ?>fd.append('<?= csrf_token() ?>','<?= csrf_hash() ?>');<?php endif; ?>const r=await fetch('<?= base_url('eliminar-tacho') ?>/'+id,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','Content-Type':'application/x-www-form-urlencoded'},body:fd});const d=await r.json();if(d.success)location.reload();else alert(d.message||'No se pudo eliminar');}));</script></body></html>
