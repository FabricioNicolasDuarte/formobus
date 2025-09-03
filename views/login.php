<?php 
// views/login.php
include 'partials/header.php'; 
?>

<div class="auth-container">
    <form action="index.php?action=authenticate" method="POST" class="auth-form">
        <h2>Iniciar Sesión</h2>
        <p>Accedé a tu cuenta para reportar incidencias.</p>
        
        <?php if (isset($error)): ?>
            <div class="alerta-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn">Ingresar</button>
        <div class="auth-switch">
            ¿No tenés cuenta? <a href="index.php?action=registro">Registrate</a>
        </div>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
