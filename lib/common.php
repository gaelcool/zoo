<?php

function getRootPath(){
    return realpath(__DIR__ . '/..');
}

function getDatabasePath(){
    return getRootPath() . '/data/zoolandia.db';
}

function getDsn(){
    return 'sqlite:' . getDatabasePath();
}

function getPDO(){
    $pdo = new PDO(getDsn());
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

/**
 * Verify user credentials and return user data if valid
 * @return array|false Returns user data array or false on failure
 */
function tryLogin(PDO $pdo, $usuario, $clave)
{
    $sql = "
        SELECT
            id_usr, usuario, nombre, correo, clave
        FROM
            usuarios
        WHERE
            usuario = :usuario
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verify password and return user data if valid
    if ($user && password_verify($clave, $user['clave'])) {
        return $user;
    }
    
    return false;
}

/**
 * Log in a user by setting session variables
 */
function login($usuario, $nombre)
{
    session_regenerate_id(true);
    $_SESSION['usuario'] = $usuario;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['logged_in'] = true;
}

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Log out current user
 */
function logout()
{
    session_unset();
    session_destroy();
}

/**
 * Get current logged in user's username
 */
function getCurrentUser()
{
    return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
}

/**
 * Check if a user exists by username
 */
function userExists(PDO $pdo, $usuario)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
    $stmt->execute([':usuario' => $usuario]);
    return $stmt->fetchColumn() > 0;
}

/**
 * Check if an email exists
 */
function emailExists(PDO $pdo, $correo)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $correo]);
    return $stmt->fetchColumn() > 0;
}

?>