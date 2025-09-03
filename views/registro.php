<?php 

include 'partials/header.php'; 
?>

<div class="auth-container">
    <form action="index.php?action=store-user" method="POST" class="auth-form">
        <h2>Crear Cuenta</h2>
        <p>Creá tu cuenta para acceder a todas las funciones.</p>
        
        <?php if (isset($error)): ?>
            <div class="alerta-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn">Registrarse</button>
        <div class="auth-switch">
            ¿Ya tenés cuenta? <a href="index.php?action=login">Iniciá Sesión</a>
        </div>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
