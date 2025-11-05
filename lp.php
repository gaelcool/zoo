<?php
require_once 'lib/common.php';
session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$nombre = $_SESSION['nombre'];
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Zoolandia</title>
    <link rel="stylesheet" href="lp.css"> 
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <h1>ZOOLANDIA</h1>
            <nav>
                <a href="booking.php" class="booking-btn">Reservar Tour</a>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <div class="welcome-section">
        <div class="user-info">
            <h2>¡Bienvenido, <?php echo htmlEscape($nombre); ?>!</h2>
            <p class="username">@<?php echo htmlEscape($usuario); ?></p>
        </div>
    </div>
    
    <div class="content-area">
        <div class="article-card">
            <img src="testarticle.png" alt="Artículo de muestra" class="article-image">
            <div class="article-content">
                <h3 class="article-title">Conservación de Especies en Peligro</h3>
                <p class="article-subtitle">Descubre cómo Zoolandia protege la biodiversidad</p>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; 2025 Zoolandia. Todos los derechos reservados.</p>
    </footer>
</body>
</html>