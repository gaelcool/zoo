<?php 
require_once 'lib/common.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $pdo = getPDO();
    
    // Get credentials
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];
    
    // Try to login
    $userData = tryLogin($pdo, $usuario, $clave);
    
    if ($userData)
    {
        // Login successful
        login($userData['usuario'], $userData['nombre']);
        
        header('Location: lp.php');
        exit();
    }
    else
    {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>Iniciar Sesión - Zoolandia</title>
</head>
<body>
    
  <div class="login-container">
    <div class="login-left">
      <form action="login.php" method="POST" class="login-form">
        <h2>Inicia sesión</h2>
        
        <?php if ($error): ?>
          <div class="notification error show">
            <span class="icon">✗</span>
            <span><?php echo htmlEscape($error); ?></span>
          </div>
        <?php endif; ?>
        
        <div class="input-box">
          <input type="text" name="usuario" id="usuario" required 
                 value="<?php echo isset($usuario) ? htmlEscape($usuario) : ''; ?>">
          <label>usuario</label>
        </div>
        
        <div class="input-box">
          <input type="password" name="clave" id="clave" required>
          <label>Contraseña</label>
        </div>
        
     
         
       
        
        <button type="submit">Login</button>
        
        <div class="register-link">
          <p>No tienes cuenta? <a href="register.php">Registrate hoy</a></p>
        </div>
      </form>
    </div>
    
    <div class="login-right">
      <!-- Background image will be applied via CSS -->
    </div>
  </div>
</body>
</html>