<?php
require_once 'lib/common.php';
session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Get reservation ID
$reserva_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$reserva_id) {
    header('Location: lp.php');
    exit();
}

$pdo = getPDO();

// Get reservation details
$stmt = $pdo->prepare("
    SELECT r.*, u.nombre, u.usuario 
    FROM reservas r 
    JOIN usuarios u ON r.id_usr = u.id_usr 
    WHERE r.id_reserva = :id AND u.usuario = :usuario
");
$stmt->execute([
    ':id' => $reserva_id,
    ':usuario' => getCurrentUser()
]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    header('Location: lp.php');
    exit();
}

// Format tour type
$tourNames = [
    'recorrido' => 'Recorrido General',
    'tematico' => 'Tour Temático',
    'vip' => 'Visita VIP'
];
$tourName = $tourNames[$reserva['tipo_tour']];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación - Zoolandia</title>
    <link rel="stylesheet" href="confirmacion.css">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <h1>ZOOLANDIA</h1>
            <nav>
                <a href="lp.php" class="back-btn">← Inicio</a>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <div class="confirmation-container">
        <div class="confirmation-card">
            <div class="success-icon">✓</div>
            <h2>¡Reserva Confirmada!</h2>
            <p class="success-message">Tu reserva ha sido procesada exitosamente</p>

            <div class="reservation-details">
                <h3>Detalles de tu reserva</h3>
                
                <div class="detail-row">
                    <span class="label">ID de Reserva:</span>
                    <span class="value">#<?php echo htmlEscape($reserva['id_reserva']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Nombre:</span>
                    <span class="value"><?php echo htmlEscape($reserva['nombre']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Tipo de Tour:</span>
                    <span class="value"><?php echo htmlEscape($tourName); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Fecha de Visita:</span>
                    <span class="value"><?php echo date('d/m/Y', strtotime($reserva['fecha_visita'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Adultos Mayores:</span>
                    <span class="value"><?php echo htmlEscape($reserva['cantidad_adultos']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Menores:</span>
                    <span class="value"><?php echo htmlEscape($reserva['cantidad_menores']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Niños:</span>
                    <span class="value"><?php echo htmlEscape($reserva['cantidad_ninos']); ?></span>
                </div>

                <div class="detail-row total">
                    <span class="label">Total Pagado:</span>
                    <span class="value">$<?php echo number_format($reserva['precio_total'], 2); ?> MXN</span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="lp.php" class="btn-primary">Volver al Inicio</a>
                <a href="booking.php" class="btn-secondary">Nueva Reserva</a>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; 2025 Zoolandia. Todos los derechos reservados.</p>
    </footer>
</body>
</html>