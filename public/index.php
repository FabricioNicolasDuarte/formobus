<?php
// public/index.php

// Es lo primero que debe ejecutarse para poder usar sesiones.
session_start();

// --- CARGA DE CONFIGURACIÓN Y MODELOS ---
require_once __DIR__ . '/../config/app.php'; 
require_once __DIR__ . '/../app/models/Linea.php';
require_once __DIR__ . '/../app/models/Parada.php';
require_once __DIR__ . '/../app/models/Mapa.php';
require_once __DIR__ . '/../app/models/Reporte.php';
require_once __DIR__ . '/../app/models/Usuario.php';
require_once __DIR__ . '/../app/models/Historial.php';

// --- FUNCIONES HELPER (Ayudantes) ---

function estaLogueado() {
    return isset($_SESSION['user_id']);
}

function protegerRuta() {
    if (!estaLogueado()) {
        header('Location: ' . BASE_URL . 'public/index.php?action=login');
        exit();
    }
}

// --- ROUTER PRINCIPAL ---
$action = $_GET['action'] ?? 'inicio';

// --- MANEJO DE RUTAS PÚBLICAS (No requieren sesión) ---
// Rutas de autenticación
if (in_array($action, ['login', 'registro', 'authenticate', 'store-user'])) {
    if (estaLogueado()) {
        header('Location: ' . BASE_URL . 'public/');
        exit();
    }
    switch ($action) {
        case 'login':
            include __DIR__ . '/../views/login.php';
            exit();
        case 'registro':
            include __DIR__ . '/../views/registro.php';
            exit();
        case 'authenticate':
            $usuario = new Usuario();
            $user_found = $usuario->findByEmail($_POST['email']);
            if ($user_found && $usuario->verificarPassword($_POST['password'])) {
                $_SESSION['user_id'] = $usuario->id;
                $_SESSION['user_nombre'] = $usuario->nombre;
                $_SESSION['user_avatar'] = $usuario->avatar_url;
                header('Location: ' . BASE_URL . 'public/');
            } else {
                $error = "Email o contraseña incorrectos.";
                include __DIR__ . '/../views/login.php';
            }
            exit();
        case 'store-user':
            $usuario = new Usuario();
            $usuario->nombre = $_POST['nombre'];
            $usuario->email = $_POST['email'];
            $usuario->password = $_POST['password'];
            if ($usuario->registrar()) {
                header('Location: ' . BASE_URL . 'public/index.php?action=login');
            } else {
                $error = "El email ya está en uso o hubo un error.";
                include __DIR__ . '/../views/registro.php';
            }
            exit();
    }
}

// Ruta "Acerca de"
if ($action === 'acerca-de') {
    include __DIR__ . '/../views/acerca_de.php';
    exit();
}


// --- RUTAS PROTEGIDAS (Requieren que el usuario esté logueado) ---
// A partir de aquí, todas las acciones requieren una sesión activa.
protegerRuta();

switch ($action) {
    case 'inicio':
        $paradas = Parada::all();
        $lineas = Linea::all();
        include __DIR__ . '/../views/inicio.php';
        break;

    case 'buscar-ruta':
        $origen_id = $_POST['origen_id'] ?? null;
        $destino_id = $_POST['destino_id'] ?? null;
        
        if (!$origen_id || !$destino_id) {
             header('Location: ' . BASE_URL . 'public/');
             exit();
        }

        // Solo guardamos si NO es una re-búsqueda desde el historial.
        if (!isset($_POST['from_history'])) {
            $historial = new Historial();
            $historial->usuario_id = $_SESSION['user_id'];
            $historial->origen_parada_id = $origen_id;
            $historial->destino_parada_id = $destino_id;
            $historial->save();
        }

        $mapa = new Mapa();
        $ruta = $mapa->encontrarRuta($origen_id, $destino_id);
        $paradaOrigen = Parada::find($origen_id);
        $paradaDestino = Parada::find($destino_id);
        include __DIR__ . '/../views/mostrar_ruta.php';
        break;

    case 'historial':
        $historial = Historial::findByUserId($_SESSION['user_id']);
        include __DIR__ . '/../views/historial.php';
        break;

    case 'resetear-historial':
        Historial::deleteByUserId($_SESSION['user_id']);
        $_SESSION['mensaje_exito'] = "Tu historial de viajes ha sido eliminado correctamente.";
        header('Location: ' . BASE_URL . 'public/index.php?action=historial');
        exit();
        break;

    case 'ver-linea':
        $linea = Linea::find($_GET['id']);
        if ($linea) {
            $recorrido = $linea->getRecorridoCompleto();
            include __DIR__ . '/../views/ver_linea.php';
        } else {
            header('Location: ' . BASE_URL . 'public/');
        }
        break;

    case 'reportar':
        $lineas = Linea::all();
        include __DIR__ . '/../views/reportar.php';
        break;

    case 'guardar-reporte':
        $reporte = new Reporte();
        $reporte->linea_id = $_POST['linea_id'];
        $reporte->tipo_reporte = $_POST['tipo_reporte'];
        $reporte->comentario = $_POST['comentario'];
        
        if ($reporte->save()) {
            $mensaje = "¡Gracias! Tu reporte ha sido enviado con éxito.";
        } else {
            $mensaje = "Hubo un error al enviar tu reporte.";
            $error = true;
        }
        $lineas = Linea::all();
        include __DIR__ . '/../views/reportar.php';
        break;
    
    case 'perfil':
        $usuario = Usuario::findById($_SESSION['user_id']);
        include __DIR__ . '/../views/perfil.php';
        break;

    case 'actualizar-perfil':
        $usuario = Usuario::findById($_SESSION['user_id']);
        $updateData = [
            'nombre' => $_POST['nombre'],
            'email' => $_POST['email']
        ];
        $newAvatarUrl = null;

        if (isset($_FILES['avatar_pc']) && $_FILES['avatar_pc']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['avatar_pc'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($file['type'], $allowedTypes)) {
                $uploadDir = __DIR__ . '/uploads/avatars/';
                $fileName = uniqid() . '-' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $newAvatarUrl = BASE_URL . 'public/uploads/avatars/' . $fileName;
                }
            }
        } 
        else if (!empty($_POST['avatar_url'])) {
            if (filter_var($_POST['avatar_url'], FILTER_VALIDATE_URL)) {
                $newAvatarUrl = $_POST['avatar_url'];
            }
        }
        
        if ($newAvatarUrl) {
            $updateData['avatar_url'] = $newAvatarUrl;
            $_SESSION['user_avatar'] = $newAvatarUrl;
        }

        if ($usuario->update($updateData)) {
            $_SESSION['user_nombre'] = $updateData['nombre'];
            $_SESSION['mensaje_exito'] = '¡Tu perfil ha sido actualizado con éxito!';
        } else {
            $_SESSION['mensaje_error'] = 'Hubo un error al actualizar tu perfil o no había cambios que guardar.';
        }
        
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            if ($usuario->verificarPassword($_POST['current_password'])) {
                if ($_POST['new_password'] === $_POST['confirm_new_password']) {
                    $usuario->updatePassword($_POST['new_password']);
                    $_SESSION['mensaje_exito'] .= ' ¡Tu contraseña ha sido cambiada!';
                } else {
                    $_SESSION['mensaje_error'] = 'La nueva contraseña no coincide en la confirmación.';
                }
            } else {
                $_SESSION['mensaje_error'] = 'La contraseña actual que ingresaste es incorrecta.';
            }
        }

        header('Location: ' . BASE_URL . 'public/index.php?action=perfil');
        exit();
        break;

    case 'logout':
        session_destroy();
        header('Location: ' . BASE_URL . 'public/index.php?action=login');
        exit();
        break;

    default:
        header('Location: ' . BASE_URL . 'public/');
        break;
}