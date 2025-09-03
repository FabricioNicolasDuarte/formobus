<?php 

include 'partials/header.php'; 
?>

<a href="<?php echo BASE_URL; ?>public/index.php?action=inicio" class="btn-volver" style="text-decoration:none; color: var(--primary-color); margin-bottom: 20px; display: inline-block; font-weight: 500;">&larr; Volver a todas las líneas</a>

<div class="linea-detalle-container">

    <div class="linea-header">
        <h2><?php echo htmlspecialchars($linea->nombre); ?></h2>
    </div>

    <?php if (!empty($linea->imagen_recorrido)): ?>
        <div class="imagen-recorrido-box">
            <h3><i class="fas fa-map-marked-alt"></i> Mapa del Recorrido</h3>
            <img src="<?php echo BASE_URL . 'public/img/recorridos/' . htmlspecialchars($linea->imagen_recorrido); ?>" alt="Mapa del recorrido de la <?php echo htmlspecialchars($linea->nombre); ?>">
        </div>
    <?php endif; ?>

    <div class="linea-info-box">
        <h3><i class="fas fa-clock"></i> Horarios y Frecuencia</h3>
        <p><?php echo nl2br(htmlspecialchars($linea->descripcion)); ?></p>
    </div>

    <div class="recorrido-box">
        <h3><i class="fas fa-route"></i> Detalle de Paradas</h3>
        <?php if (!empty($recorrido['ida']) || !empty($recorrido['vuelta'])): ?>
            
            <div class="recorrido-sentido">
                <h4>Recorrido de IDA</h4>
                <?php if(!empty($recorrido['ida'])): ?>
                    <ol class="lista-recorrido">
                        <?php foreach ($recorrido['ida'] as $parada): ?>
                            <li><?php echo htmlspecialchars($parada->nombre); ?></li>
                        <?php endforeach; ?>
                    </ol>
                <?php else: ?>
                    <p>No se encontró un recorrido de ida para esta línea.</p>
                <?php endif; ?>
            </div>

            <div class="recorrido-sentido">
                <h4>Recorrido de VUELTA</h4>
                 <?php if(!empty($recorrido['vuelta'])): ?>
                    <ol class="lista-recorrido">
                        <?php foreach ($recorrido['vuelta'] as $parada): ?>
                            <li><?php echo htmlspecialchars($parada->nombre); ?></li>
                        <?php endforeach; ?>
                    </ol>
                <?php else: ?>
                    <p>No se encontró un recorrido de vuelta para esta línea.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p class="alerta-info">No se encontró un recorrido para esta línea.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.linea-info-box, .recorrido-box, .imagen-recorrido-box {
    background: var(--white-transparent);
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
.imagen-recorrido-box img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-top: 1rem;
}
.linea-info-box h3, .recorrido-box h3, .recorrido-sentido h4, .imagen-recorrido-box h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #eee;
}
.linea-info-box p {
    line-height: 1.8;
}
.recorrido-sentido {
    margin-top: 2rem;
}
.lista-recorrido {
    list-style: none;
    padding-left: 0;
}
.lista-recorrido li {
    padding: 0.85rem;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
    padding-left: 35px;
    font-size: 0.95rem;
    min-height: 40px;
    display: flex;
    align-items: center;
}
.lista-recorrido li:last-child {
    border-bottom: none;
}


.lista-recorrido li::before {
    content: '';
    background-image: url('<?php echo BASE_URL; ?>public/img/icons/parada_icon.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    
    
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;

}

</style>

<?php include 'partials/footer.php'; ?>