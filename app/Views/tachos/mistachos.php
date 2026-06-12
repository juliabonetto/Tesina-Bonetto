<h1>Mis Eco-Tachos</h1>




<a href="<?= base_url('unirse-tacho') ?>">
    Unirse a un EcoScam
</a>
<a href="<?= base_url('registrar-tacho') ?>">
    Registrar nuevo Eco-Tacho
</a>


<hr>


<?php foreach($tachos as $tacho): ?>


<div class="card">


    <h3><?= esc($tacho->nombre) ?></h3>


    <p>
        Tipo: <?= esc($tacho->tipo) ?>
    </p>


    <p>
        Ubicación: <?= esc($tacho->ubicacion) ?>
    </p>


<a href="<?= base_url('estadisticas-tacho/'.$tacho->id) ?>">
    Ver estadísticas
</a>


</div>


<?php endforeach; ?>
