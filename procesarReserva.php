<?php
require_once 'lib/common.php';
session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: booking.php');
    exit();
}

$pdo = getPDO();

// Get form data
$tipo_tour = $_POST['tipo_tour'];
$fecha_visita = $_POST['fecha_visita'];
$adultos = intval($_POST['adultos']);
$menores = intval($_POST['menores']);
$ninos = intval($_POST['ninos']);

// Calculate total price
$tourPrices = ['recorrido' => 50, 'tematico' => 100, 'vip' => 150];
$basePrice = $tourPrices[$tipo_tour];

$agePrice = ($adultos * 40) + ($menores * 60) + ($ninos * 30);
$precioTotal = $basePrice + $agePrice;

// Get user ID
$usuario = getCurrentUser();
$stmt = $pdo->prepare("SELECT id_usr FROM usuarios WHERE usuario = :usuario");
$stmt->execute([':usuario' => $usuario]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$id_usr = $userData['id_usr'];

try {
    // Insert reservation
    $stmt = $pdo->prepare("
        INSERT INTO reservas 
        (id_usr, tipo_tour, fecha_visita, cantidad_adultos, cantidad_menores, cantidad_ninos, precio_total) 
        VALUES 
        (:id_usr, :tipo_tour, :fecha_visita, :adultos, :menores, :ninos, :precio_total)
    ");
    
    $stmt->execute([
        ':id_usr' => $id_usr,
        ':tipo_tour' => $tipo_tour,
        ':fecha_visita' => $fecha_visita,
        ':adultos' => $adultos,
        ':menores' => $menores,
        ':ninos' => $ninos,
        ':precio_total' => $precioTotal
    ]);
    
    $reserva_id = $pdo->lastInsertId();
    
    // Redirect to confirmation page
    header("Location: confirmacion.php?id=$reserva_id");
    exit();
    
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al procesar la reserva. Intenta nuevamente.";
    header('Location: booking.php');
    exit();
}
?>