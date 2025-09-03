<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormoBus - Tu Guía de Transporte</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?php echo BASE_URL; ?>public/">
                    <img src="<?php echo BASE_URL; ?>public/img/formobuslogo1.png" alt="Logo de FormoBus">
                </a>
            </div>
            
            <nav class="main-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>public/index.php?action=inicio">Planificar Viaje</a>
                    <a href="<?php echo BASE_URL; ?>public/index.php?action=historial">Historial</a>
                    <a href="<?php echo BASE_URL; ?>public/index.php?action=reportar">Reportar</a>
                <?php endif; ?>
            </nav>
            
            <div class="auth-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-info">
                        <?php 
                            
                            $avatar = $_SESSION['user_avatar'] ?? (BASE_URL . 'public/img/default-avatar.png'); 
                        ?>
                        <a href="<?php echo BASE_URL; ?>public/index.php?action=perfil" style="display: flex; align-items: center; text-decoration: none; color: white;">
                           <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="user-avatar">
                           <span style="margin-left: 10px;">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/index.php?action=logout" class="btn btn-logout">Salir</a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>public/index.php?action=login">Iniciar Sesión</a>
                    <a href="<?php echo BASE_URL; ?>public/index.php?action=registro" class="btn">Registrarse</a>
                <?php endif; ?>
            </div>
            <button id="menu-toggle" class="menu-toggle">☰</button>
        </div>
    </header>
    
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="mobile-menu" id="mobile-menu">
        <a href="<?php echo BASE_URL; ?>public/index.php?action=perfil">Mi Perfil</a>
        <hr>
        <a href="<?php echo BASE_URL; ?>public/index.php?action=inicio">Planificar Viaje</a>
        <a href="<?php echo BASE_URL; ?>public/index.php?action=historial">Historial</a>
        <a href="<?php echo BASE_URL; ?>public/index.php?action=reportar">Reportar</a>
        <hr>
        <a href="<?php echo BASE_URL; ?>public/index.php?action=logout">Cerrar Sesión</a>
    </div>
    <?php endif; ?>
    
    <main class="container">