<?php 

include 'partials/header.php'; 
?>

<div style="background-color: rgba(0, 0, 0, 0.65); padding: 2rem; border-radius: 10px;">

    <h2 style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Tu Ruta Sugerida</h2>
    <p style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Desde: <strong><?php echo htmlspecialchars($paradaOrigen->nombre); ?></strong></p>
    <p style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Hasta: <strong><?php echo htmlspecialchars($paradaDestino->nombre); ?></strong></p>

    <hr style="background-color: rgba(255,255,255,0.3); border: none; height: 1px;">

    <?php if ($ruta): ?>
        <div class="resultado-ruta" style="background: #fff; color: #333; padding: 1.5rem; border-radius: 8px;">
            <h3 style="color: #000000ff;">Pasos a seguir:</h3>
            <ol>
                <?php 
                $lineaActual = null;
                foreach ($ruta as $i => $tramo): 
                    // Si la línea del tramo actual es diferente a la anterior, es un nuevo paso (o el primero)
                    if ($lineaActual !== $tramo['linea']->id) {
                        if ($lineaActual !== null) {
                            // Si no es el primer colectivo, cerramos los tags de la instrucción anterior
                            echo "</ul>Bájate en <strong>" . htmlspecialchars($ruta[$i-1]['destino']->nombre) . "</strong>.</li>";
                        }
                        $lineaActual = $tramo['linea']->id;
                        echo "<li>Tomá el colectivo <strong>" . htmlspecialchars($tramo['linea']->nombre) . "</strong> en la parada <strong>" . htmlspecialchars($tramo['origen']->nombre) . "</strong>. Viajarás por las siguientes paradas:<ul>";
                    }
                ?>
                    <li><?php echo htmlspecialchars($tramo['destino']->nombre); ?></li>
                <?php 
                    // Si es el último tramo de la ruta, cerramos todo.
                    if ($i === count($ruta) - 1) {
                        echo "</ul>¡Llegaste a tu destino!</li>";
                    }
                endforeach; 
                ?>
            </ol>
        </div>
    <?php else: ?>
        <div class="alerta-error">
            <h3>No se pudo encontrar una ruta.</h3>
            <p>Es posible que no haya una conexión directa entre las paradas seleccionadas en nuestra base de datos actual. Pronto implementaremos rutas con trasbordos.</p>
        </div>
    <?php endif; ?>

</div>

<a href="index.php" class="btn" style="margin-top: 1.5rem;">&larr; Volver a planificar</a>

<?php include 'partials/footer.php'; ?>