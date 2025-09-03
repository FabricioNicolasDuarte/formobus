<?php 

include 'partials/header.php'; 
?>

<div class="page-header">
    <h2 style="color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">Tu historial de viajes</h2>
    <?php if (!empty($historial)): ?>
        <form action="index.php?action=resetear-historial" method="POST" onsubmit="return confirm('¿Estás seguro de que querés eliminar todo tu historial? Esta acción no se puede deshacer.');">
            <button type="submit" class="btn btn-danger">Resetear Historial</button>
        </form>
    <?php endif; ?>
</div>

<?php
if (isset($_SESSION['mensaje_exito'])) {
    echo '<div class="alerta-exito">' . htmlspecialchars($_SESSION['mensaje_exito']) . '</div>';
    unset($_SESSION['mensaje_exito']);
}
?>

<div class="historial-container">
    <?php if (!empty($historial)): ?>
        <ul class="lista-historial">
            <?php foreach ($historial as $item): ?>
                <li>
                    <div class="historial-info">
                        <span class="historial-fecha"><?php echo date('d/m/Y H:i', strtotime($item['fecha_busqueda'])); ?></span>
                        <p><strong>Desde:</strong> <?php echo htmlspecialchars($item['origen_nombre']); ?></p>
                        <p><strong>Hasta:</strong> <?php echo htmlspecialchars($item['destino_nombre']); ?></p>
                    </div>
                    
                    <div class="historial-accion">
                        <form action="index.php?action=buscar-ruta" method="POST">
                            <input type="hidden" name="origen_id" value="<?php echo $item['origen_parada_id']; ?>">
                            <input type="hidden" name="destino_id" value="<?php echo $item['destino_parada_id']; ?>">
                            <input type="hidden" name="from_history" value="1">
                            <button type="submit" class="btn btn-small">Ver Ruta</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alerta-info">
            <p>Aún no has planificado ningún viaje. ¡Realizá tu primera búsqueda para verla aquí!</p>
        </div>
    <?php endif; ?>
</div>

<?php 
include 'partials/footer.php'; 
?>