<?php 
// views/inicio.php
include 'partials/header.php'; 

// El controlador ya se aseguró de que el usuario esté logueado para llegar aquí.
?>

<div class="welcome-message">
    <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?>!</h2>
    <p>Seleccioná tu parada de origen y destino para encontrar la mejor ruta.</p>
</div>

<form action="index.php?action=buscar-ruta" method="POST" class="form-planificador">
    <div class="form-group">
        <label for="origen">Desde:</label>
        <select name="origen_id" id="origen" required>
            <option value="">-- Seleccioná una parada --</option>
            <?php foreach ($paradas as $parada): ?>
                <option value="<?php echo $parada->id; ?>"><?php echo htmlspecialchars($parada->nombre); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="destino">Hasta:</label>
        <select name="destino_id" id="destino" required>
            <option value="">-- Seleccioná una parada --</option>
            <?php foreach ($paradas as $parada): ?>
                <option value="<?php echo $parada->id; ?>"><?php echo htmlspecialchars($parada->nombre); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn">Buscar Ruta</button>
</form>

<hr>

<h2 style="color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">Recorridos de Líneas</h2>
<ul class="lista-lineas">
    <?php foreach ($lineas as $linea): ?>
        <li>
            <a href="index.php?action=ver-linea&id=<?php echo $linea->id; ?>">
                <strong><?php echo htmlspecialchars($linea->nombre); ?>:</strong>
                <span><?php echo htmlspecialchars($linea->descripcion); ?></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'partials/footer.php'; ?>
