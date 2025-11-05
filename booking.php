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
    <title>Reservar Tour - Zoolandia</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <h1>ZOOLANDIA</h1>
            <nav>
                <a href="lp.php" class="back-btn">← Volver</a>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <div class="booking-container">
        <div class="booking-card">
            <h2>¡Vive una experiencia inolvidable!</h2>
            <p class="user-greeting">Reservando como: <strong><?php echo htmlEscape($nombre); ?></strong></p>

            <form action="procesarReserva.php" method="POST" class="booking-form">
                <div class="section-title">Información de costos</div>
                
                <div class="tour-options">
                    <label class="tour-option">
                        <input type="radio" name="tipo_tour" value="recorrido" required>
                        <div class="tour-card">
                            <h3>Recorrido</h3>
                            <p class="price">$50.00 MXN</p>
                            <p class="description">Acceso general al zoológico</p>
                        </div>
                    </label>

                    <label class="tour-option">
                        <input type="radio" name="tipo_tour" value="tematico" required>
                        <div class="tour-card highlight">
                            <h3>Tour Temático</h3>
                            <p class="price">$100.00 MXN</p>
                            <p class="description">Incluye guía especializado</p>
                        </div>
                    </label>

                    <label class="tour-option">
                        <input type="radio" name="tipo_tour" value="vip" required>
                        <div class="tour-card">
                            <h3>Visita VIP</h3>
                            <p class="price">$150.00 MXN</p>
                            <p class="description">Acceso exclusivo + interacción</p>
                        </div>
                    </label>
                </div>

                <div class="section-title">Fecha de visita</div>
                <div class="input-group">
                    <label for="fecha_visita">Selecciona la fecha:</label>
                    <input type="date" name="fecha_visita" id="fecha_visita" required 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="section-title">Clasificación</div>
                
                <div class="age-inputs">
                    <div class="input-group">
                        <label for="adultos">Adultos mayores (60+ años)</label>
                        <input type="number" name="adultos" id="adultos" 
                               min="0" max="20" value="0" data-price="40">
                        <span class="price-tag">$40.00 MXN</span>
                    </div>

                    <div class="input-group">
                        <label for="menores">Adultos 18+</label>
                        <input type="number" name="menores" id="menores" 
                               min="0" max="20" value="0" data-price="60">
                        <span class="price-tag">$60.00 MXN</span>
                    </div>

                    <div class="input-group">
                        <label for="ninos">Niños menores de 18</label>
                        <input type="number" name="ninos" id="ninos" 
                               min="0" max="20" value="0" data-price="30">
                        <span class="price-tag">$30.00 MXN</span>
                    </div>
                </div>

                <div class="total-section">
                    <h3>Total estimado: <span id="total">$0.00 MXN</span></h3>
                </div>

                <button type="submit" class="submit-btn">Confirmar Reserva</button>
            </form>
        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; 2025 Zoolandia. Todos los derechos reservados.</p>
    </footer>

    <script>
        const form = document.querySelector('.booking-form');
        const tourRadios = document.querySelectorAll('input[name="tipo_tour"]');
        const ageInputs = document.querySelectorAll('.age-inputs input[type="number"]');
        const totalDisplay = document.getElementById('total');

        function calculateTotal() {
            let basePrice = 0;
            
            const selectedTour = document.querySelector('input[name="tipo_tour"]:checked');
            if (selectedTour) {
                const prices = { recorrido: 50, tematico: 100, vip: 150 };
                basePrice = prices[selectedTour.value];
            }
//funcion? JAJAJAJ odio las funciones, mjr llevenme al cine
            let ageTotal = 0;
            ageInputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const price = parseInt(input.dataset.price);
                ageTotal += quantity * price;
            });

            const total = basePrice + ageTotal;
            totalDisplay.textContent = `$${total.toFixed(2)} MXN`;
        }
//funciono :)
        tourRadios.forEach(radio => radio.addEventListener('change', calculateTotal));
        ageInputs.forEach(input => input.addEventListener('input', calculateTotal));
    </script>
</body>
</html>