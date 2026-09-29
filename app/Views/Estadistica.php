<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Estadísticas | EcoS-cam</title><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root{--green-dark:#1f4d2b;--green:#2f7a3f;--green-light:#4ea25c;--green-soft:#e8f4ea;--bg:#f7faf7;--card:#fff;--text:#1c2620;--muted:#647069;--border:#dfe8e1;--shadow:0 4px 14px rgba(20,40,25,.08);--radius:18px}*{box-sizing:border-box;margin:0;padding:0}body{background:var(--bg);font-family:system-ui;color:var(--text);padding:30px 20px}.container{max-width:1200px;margin:auto}.header{background:#fff;border:2px solid var(--green);border-radius:var(--radius);padding:25px;margin-bottom:25px}.volver{display:inline-block;background:var(--text);color:#fff;padding:10px 18px;border-radius:10px;text-decoration:none;margin-bottom:12px}.header h1{color:var(--green)}.badge{display:inline-block;background:var(--green-soft);padding:7px 15px;border-radius:20px;margin-top:8px}.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:25px}.card,.panel,.table{background:#fff;border:2px solid var(--green);border-radius:var(--radius);padding:22px;box-shadow:var(--shadow)}.card{text-align:center}.card h2{color:var(--green-dark);margin-top:8px}.charts{display:grid;grid-template-columns:1fr 1fr;gap:25px;margin-bottom:25px}.chartbox{height:300px}.panel h2,.table h2{text-align:center;margin-bottom:18px;color:var(--green-dark)}table{width:100%;border-collapse:collapse}th{background:var(--green);color:#fff;padding:12px}td{padding:11px;text-align:center;border-bottom:1px solid var(--border)}@media(max-width:800px){.cards,.charts{grid-template-columns:1fr}}
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a class="volver" href="<?= site_url('mis-tachos') ?>">← Volver</a>
            <h1>Estadísticas de <?= esc($tacho->nombre) ?></h1>
            <div class="badge"><?= esc(ucfirst($tacho->tipo)) ?></div>
                        <div class="badge"> Codígo: <?= esc(ucfirst($tacho->codigo_activacion)) ?></div>
        </div>
<div class="cards">
    <div class="card">
        <h3>Total Clasificaciones</h3>
        <h2><?= $total ?></h2></div>
        <div class="card"><h3>Clasificaciones Hoy</h3>
        <h2><?= (int)$hoy['cantidad'] ?></h2></div>
        <div class="card"><h3>Confianza Promedio</h3>
        <h2><?= round(((float)$promedio['promedio'])*100,2) ?>%</h2></div>
    </div>
<div class="charts">
    <div class="panel">
        <h2>Distribución de residuos</h2>
        <div class="chartbox"><canvas id="grafico">
        </canvas>
    </div>
</div>
<div class="panel">
    <h2>Resumen</h2>
    <?php $ls=json_decode($labels,true)?:[];$ds=json_decode($datos,true)?:[];foreach($ls as $i=>$label): ?>
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border)"><strong><?= esc($label) ?></strong><span><?= (int)($ds[$i]??0) ?></span></div><?php endforeach; if(!$ls): ?>
            <p>No hay clasificaciones para este Eco-Tacho.</p><?php endif; ?></div>
        </div>
<div class="table">
    <h2>Últimas Clasificaciones</h2>
    <div style="overflow:auto">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Residuo</th>
                    <th>Confianza</th>
                    <th>Tipo</th>
                    <th>Final</th>
                </tr>
            </thead>
            <tbody><?php foreach($ultimos as $fila): ?><tr>
                <td><?= esc($fila['fecha_hora']) ?></td>
                <td><?= esc(ucfirst($fila['residuo'])) ?></td>
                <td><?= round($fila['confianza']*100,2) ?>%</td>
                <td><?= esc(ucfirst($fila['clasificacion'])) ?></td>
                <td><?= esc($fila['categoria_final'] ?? '-') ?></td>
            </tr><?php endforeach; if(!$ultimos): ?><tr>
                <td colspan="5">No hay registros.</td>
            </tr><?php endif; ?>
        </tbody>
    </table>
</div>
</div>
</div>
<script>new Chart(document.getElementById('grafico'),{type:'pie',data:{labels:<?= $labels ?>,datasets:[{data:<?= $datos ?>}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}});
</script>
</body>
</html>
