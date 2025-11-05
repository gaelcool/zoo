<?php
require_once 'lib/common.php';
session_start();

// Only process if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPDO();
    
    // Get and sanitize input
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $usuario = trim($_POST["usuario"]);
    $clave = $_POST["clave"];
    
    $error = '';
    $success = false;
    
    try {
        // Check if username exists
        if (userExists($pdo, $usuario)) {
            $error = "El usuario ya existe";
        }
        // Check if email exists
        elseif (emailExists($pdo, $correo)) {
            $error = "El correo ya está registrado";
        }
        else {
            // Hash password securely
            $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, usuario, clave) VALUES (:nombre, :correo, :usuario, :clave)");
            $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':usuario' => $usuario,
                ':clave' => $hashedPassword
            ]);
            
            $success = true;
        }
    } catch (PDOException $e) {
        $error = "Error al registrarse. Intenta nuevamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Registro - Zoolandia</title>
</head>
<body>
    <section></section>
    
    <div class="register-container">
        <div class="register-left">
            <form action="register.php" method="post" class="register-form">
                <h2>Crea tu cuenta! <p>@</p></h2> 

                <?php if (isset($success) && $success): ?>
                    <div class="notification success show">
                        <span class="icon">✓</span>
                        <span>¡Cuenta creada exitosamente!</span>
                    </div>
                    <a href="login.php" style="display: block; margin-top: 20px;">
                        <button type="button" style="width: 100%;">Ir a Iniciar Sesión</button>
                    </a>
                <?php elseif (isset($error) && $error): ?>
                    <div class="notification error show">
                        <span class="icon">✗</span>
                        <span><?php echo htmlEscape($error); ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="input-box">
                    <input type="text" name="nombre" id="nombre" required
                           value="<?php echo isset($nombre) ? htmlEscape($nombre) : ''; ?>">
                    <label for="nombre">Nombre</label>
                    <div class="validation-box"></div>
                </div>
                
                <div class="input-box">
                    <input type="email" name="correo" id="correo" required
                           value="<?php echo isset($correo) ? htmlEscape($correo) : ''; ?>">
                    <label for="correo">Correo electrónico</label>
                    <div class="validation-box"></div>
                </div>
                
                <div class="input-box">
                    <input type="text" name="usuario" id="usuario" required
                           value="<?php echo isset($usuario) ? htmlEscape($usuario) : ''; ?>">
                    <label for="usuario">Usuario</label>
                    <div class="validation-box"></div>
                </div>
                
                <div class="input-box">
                    <input type="password" name="clave" id="clave" required minlength="6">
                    <label for="clave">Contraseña</label>
                    <div class="validation-box"></div>
                </div>

                <button type="submit">Registrarse</button>

                <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
            </form>
        </div>
        
        <div class="register-right">
            <!-- Background image will be applied via CSS -->
        </div>
        <script src="script.js"></script>
    </div>
    <footer class="main-footer">
        <p>&copy; 2025 Zoolandia. Suerte.</p>
    </footer>
</body>
</html>