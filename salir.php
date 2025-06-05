<?php
include("comunes/loginfunciones.php");
require_once 'clases/mysql.inc.php';
require_once 'trazabilidad.php';

session_start();

// Registrar trazabilidad antes de destruir la sesión
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $traza = new Trazabilidad();
    $traza->registrarEvento($usuario, 'logout');
}

// Destruir sesión
session_destroy();

// Redirigir al login
redireccionar("login.php");
?>
