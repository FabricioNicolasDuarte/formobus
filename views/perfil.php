<?php 
// views/perfil.php
include 'partials/header.php'; 
?>

<div class="perfil-container">
    <div class="perfil-header">
        <?php 
            $avatar = $usuario->avatar_url ?? (BASE_URL . 'public/img/default-avatar.png');
        ?>
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar del usuario" class="perfil-avatar">
        <h2>Mi Perfil</h2>
    </div>

    <?php
    if (isset($_SESSION['mensaje_exito'])) {
        echo '<div class="alerta-exito">' . htmlspecialchars($_SESSION['mensaje_exito']) . '</div>';
        unset($_SESSION['mensaje_exito']);
    }
    if (isset($_SESSION['mensaje_error'])) {
        echo '<div class="alerta-error">' . htmlspecialchars($_SESSION['mensaje_error']) . '</div>';
        unset($_SESSION['mensaje_error']);
    }
    ?>

    <form action="index.php?action=actualizar-perfil" method="POST" enctype="multipart/form-data">
        
        <div class="form-section">
            <h3>Datos Personales</h3>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario->nombre); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario->email); ?>" required>
            </div>
        </div>

        <div class="form-section">
            <h3>Cambiar Imagen de Perfil</h3>
            <p>Puedes subir una imagen desde tu PC o pegar el enlace a una imagen de internet (ej: de Google Drive, Imgur, etc.). Si usas ambos, la imagen subida tendrá prioridad.</p>
            
            <div class="form-group">
                <label for="avatar_pc">Subir desde la computadora</label>
                <input type="file" name="avatar_pc" id="avatar_pc" accept="image/png, image/jpeg, image/gif">
            </div>
            
            <div class="form-group">
                <label for="avatar_url">O pegar URL de una imagen</label>
                <input type="url" name="avatar_url" id="avatar_url" placeholder="https://ejemplo.com/imagen.jpg">
                <small>Para Google Drive, haz clic derecho sobre la imagen, selecciona "Obtener enlace", cambia la restricción a "Cualquier persona con el enlace" y copia el enlace.</small>
            </div>
        </div>

        <div class="form-section">
            <h3>Cambiar Contraseña</h3>
            <p>Dejar en blanco para no cambiar la contraseña.</p>
            <div class="form-group">
                <label for="current_password">Contraseña Actual</label>
                <input type="password" name="current_password" id="current_password">
            </div>
            <div class="form-group">
                <label for="new_password">Nueva Contraseña</label>
                <input type="password" name="new_password" id="new_password">
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirmar Nueva Contraseña</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password">
            </div>
        </div>
        
        <button type="submit" class="btn">Guardar Cambios</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>