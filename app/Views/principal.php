<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EcoS-cam principal</title>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
<style>
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;align-items:center;justify-content:center;padding:20px}.modal-contenido{background:#fff;border-radius:18px;max-width:800px;width:100%;max-height:85vh;overflow:auto;padding:28px;position:relative}.cerrar{position:absolute;right:20px;top:12px;font-size:30px;cursor:pointer}.lista-tachos{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:15px}.tarjeta-tacho{padding:18px;border:1px solid #dfe8e1;border-radius:15px}.btn-modal{display:inline-block;padding:10px 14px;border-radius:10px;background:#2f7a3f;color:#fff;text-decoration:none}.estado{font-size:.9rem;margin-top:10px}.activo{color:#2f7a3f;font-weight:700}
</style>
</head>
<body>
<header class="navbar"><div class="nav-inner">
<a href="#" class="brand"><img src="<?= base_url('img/Captura_de_pantalla_2026-04-24_090557-removebg-preview.png') ?>" alt="Logo EcoS-cam" class="brand-logo"><span>EcoS-cam</span></a>
<nav class="nav-links"><a href="<?= base_url('mis-tachos') ?>">Mis Tachos</a><a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">Contacto</a><a href="<?= base_url('pagos/checkout') ?>" class="btn-premium">Obtener EcoS-cam</a></nav>
<div class="menu"><button class="menu-button">☰ Menú</button><div class="menu-content"><a href="<?= site_url('usuario/perfil') ?>">👤 Perfil</a><a href="<?= site_url('usuario/servicios') ?>">🛠️ Servicios</a><a href="<?= site_url('usuario/politica_privacidad') ?>">📄 Políticas de privacidad</a><a href="<?= site_url('usuario/cerrarSesion') ?>">🔒 Cerrar sesión</a></div></div>
</div></header>
<main class="container">
<section class="welcome-block"><div class="welcome-text"><h1>¡Bienvenid@, <span class="user-name"><?= esc($usuario['nombre']) ?></span>!</h1><p>Gestioná tus residuos, revisá estadísticas y ayudá al medio ambiente desde tu panel principal.</p></div><div class="hero-badge">🌱 Sistema activo</div></section>
<section class="cards-grid">
<div class="card"><h3>♻ Residuos reciclados</h3><p><?= $residuosHoy ?> residuos reciclados hoy.</p></div>
<div class="card">
<h3>⚠️ Revisar tacho</h3>
<?php if (!empty($alertaTacho) && !empty($alertaTacho['alerta_papel'])): ?>
<p>🗑️ <?= esc($alertaTacho['nombre']) ?></p>
<p>♻️ Plástico/Vidrio</p>
<p>Revisar y cambiar la bolsa.</p>

<?php else: ?>
<p>✅ No hay tachos que revisar.</p>
<?php endif; ?>
</div>
<div class="card"><h3>🏆 Nivel ecológico</h3><p><?= esc($nivelEco) ?></p></div>
</section>
<div class="card card-tacho"><div class="tacho-info"><div><?php if($tachoSeleccionado): ?><h3>🗑 <?= esc($tachoSeleccionado['nombre']) ?></h3><p>Mostrando estadísticas de este Eco-Tacho.</p><p>Estado: <?= !empty($tachoSeleccionado['habilitado']) ? '🟢 Habilitado' : '🔴 No habilitado' ?></p><?php else: ?><h3>Ningún Eco-Tacho seleccionado</h3><p>Registrá o uníte mediante código.</p><?php endif; ?></div><?php if(count($tachos) > 1): ?><button class="btn-cambiar" onclick="abrirModal()">📊 Cambiar estadísticas</button><?php endif; ?></div></div>
<section class="dashboard-extra">
<div class="tarjeta-contenedor"><h2 class="titulo-impacto">🌱 Compartí tu impacto ecológico</h2><div id="tarjeta-logro" class="tarjeta-logro"><div class="impact-header"><div class="brand"><img src="<?= base_url('img/Captura_de_pantalla_2026-04-24_090557-removebg-preview.png') ?>" alt="Logo" class="brand-logo"><span>EcoS-cam</span></div><div class="fecha"><?= date('d M Y') ?></div></div><p class="impact-label">Mi impacto</p><h2 class="impact-name"><?= esc($usuario['nombre']) ?></h2><div class="impact-number"><div class="big-number"><?= $residuosHoy ?></div><div class="number-text">residuos<br>reciclados</div></div><div class="impact-info"><div class="info-box"><span>Nivel</span><strong>🏆 <?= esc($nivelEco) ?></strong></div></div>

<div class="impact-footer">
    <span>Reciclá con inteligencia</span>

    <?php if ($tachoSeleccionado): ?>
        <span>
            🗑️ <?= esc($tachoSeleccionado['nombre']) ?>
        </span>
    <?php endif; ?>
</div>

</div><div class="acciones-logro"><button onclick="descargarTarjeta()">📥 Descargar</button><button onclick="copiarTexto()">📋 Copiar</button></div></div>
<div class="panel"><h2>📊 Estadísticas</h2><canvas id="graficoResiduos"></canvas></div>
</section>
<footer class="footer">EcoS-cam © 2026 - Todos los derechos reservados</footer>
</main>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function descargarTarjeta(){const t=document.getElementById('tarjeta-logro');if(!t)return;html2canvas(t,{scale:2,useCORS:true,backgroundColor:null}).then(c=>{const a=document.createElement('a');a.download='ecoscam-logro.png';a.href=c.toDataURL('image/png');a.click();}).catch(console.error)}
function copiarTexto(){navigator.clipboard.writeText("Hoy reciclé <?= $residuosHoy ?> residuos usando EcoS-cam ♻. Mi impacto ambiental estimado es de <?= $impactoAmbiental ?>% y actualmente soy <?= esc($nivelEco) ?>.").then(()=>alert('Texto copiado')).catch(()=>alert('No se pudo copiar el texto.'))}
function cambiarBolsa(){
 fetch("<?= site_url('tacho/cambiar-bolsa') ?>",{method:"POST",headers:{"X-Requested-With":"XMLHttpRequest"}})
 .then(r=>r.json()).then(data=>{if(data.success){alert(data.message||"Alerta limpiada.");location.reload();}else{alert(data.message||"No se pudo limpiar la alerta.");}})
 .catch(()=>alert("No se pudo conectar con el servidor."));
}
const canvas=document.getElementById('graficoResiduos');if(canvas){new Chart(canvas,{type:'bar',data:{labels:<?= $labels ?>,datasets:[{label:'Residuos',data:<?= $datos ?>}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}})}
</script>
<div id="modalTachos" class="modal"><div class="modal-contenido"><span class="cerrar" onclick="cerrarModal()">×</span><h2>Elegí un Eco-Tacho</h2><?php if(empty($tachos)): ?><p>No tenés Eco-Tachos registrados.</p><?php else: ?><div class="lista-tachos"><?php foreach($tachos as $t): ?><div class="tarjeta-tacho"><h3>🗑 <?= esc($t['nombre']) ?></h3><p><?= esc($t['ubicacion'] ?? '') ?></p><small><?= esc($t['tipo']) ?></small><div class="estado"><?= !empty($t['habilitado']) ? '🟢 Habilitado' : '🔴 No habilitado' ?></div><br><a class="btn-modal" href="<?= site_url('seleccionar-tacho/'.$t['id']) ?>">Ver estadísticas</a></div><?php endforeach; ?></div><?php endif; ?></div></div>
<script>function abrirModal(){document.getElementById('modalTachos').style.display='flex'}function cerrarModal(){document.getElementById('modalTachos').style.display='none'}window.addEventListener('click',e=>{const m=document.getElementById('modalTachos');if(e.target===m)m.style.display='none'});</script>
</body></html>
