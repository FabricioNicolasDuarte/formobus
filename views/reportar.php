<?php 

include 'partials/header.php'; 
?>

<h2 style="color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">Reportar una incidencia</h2>
<p style="color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">Ayúdanos a mejorar el servicio. Tu reporte es anónimo.</p>

<?php if (isset($mensaje)): ?>
    <div class="<?php echo (isset($error) && $error) ? 'alerta-error' : 'alerta-exito'; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>


<form action="index.php?action=guardar-reporte" method="POST" class="form-planificador">
    <div class="form-group">
        <label for="linea_id">Línea a reportar:</label>
        <select name="linea_id" id="linea_id" required>
            <option value="">-- Seleccioná una línea --</option>
            <?php foreach ($lineas as $linea): ?>
                <option value="<?php echo htmlspecialchars($linea->id); ?>"><?php echo htmlspecialchars($linea->nombre); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="tipo_reporte">Tipo de incidencia:</label>
        <select name="tipo_reporte" id="tipo_reporte" required>
            <option value="DEMORA">Demora excesiva</option>
            <option value="MAL_ESTADO">Unidad en mal estado</option>
            <option value="FRECUENCIA">Mala frecuencia</option>
            <option value="OTRO">Otro</option>
        </select>
    </div>
    <div class="form-group">
        <label for="comentario">Comentario (opcional):</label>
        <textarea name="comentario" id="comentario" rows="4" placeholder="Añadí más detalles aquí..."></textarea>
    </div>
    <button type="submit" class="btn">Enviar Reporte</button>
</form>

<?php include 'partials/footer.php'; ?>