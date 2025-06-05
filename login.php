<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'clases/mysql.inc.php';
require_once 'trazabilidad.php';
require_once 'Sanitizar.php'; // Incluimos la clase para sanitizar

$db = new mod_db();
$traza = new Trazabilidad();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizamos los datos de entrada
    $usuario = Sanitizar::usuario($_POST['usuario'] ?? '');
    $contrasena = Sanitizar::contrasena($_POST['contrasena'] ?? '');

    if ($usuario && $contrasena) {
        // Validar longitud mínima de contraseña (mínimo 8 caracteres)
        if (strlen($contrasena) < 8) {
            $mensaje = "<div class='alert alert-warning'>⚠️ La contraseña debe tener al menos 8 caracteres.</div>";
        } else {
            $sql = "SELECT * FROM usuarios WHERE usuario = " . $db->sql_quote($usuario);
            $result = $db->consultar($sql);
            $fila = $result ? $result->fetch(PDO::FETCH_ASSOC) : null;

            if ($fila && password_verify($contrasena, $fila['hashMagic'])) {
                $_SESSION['usuario'] = $usuario;

                // Registrar evento de login
                $traza->registrarEvento($usuario, 'login');

                header("Location: validar2fa.php");
                exit;
            } else {
                $mensaje = "<div class='alert alert-danger'>❌ Usuario o contraseña incorrectos.</div>";
            }
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>⚠️ Ingresa todos los campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
    function togglePassword() {
        const input = document.getElementById("contrasena");
        const icon = document.getElementById("toggleBtn");
        input.type = input.type === "password" ? "text" : "password";
        icon.textContent = input.type === "password" ? "👁️" : "🙈";
    }
    </script>
</head>
<body>
    <div class="login-card">
        <h2>🔐 Iniciar sesión</h2>
        <?= $mensaje ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" required />
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <div style="display:flex; gap:10px;">
                    <input type="password" name="contrasena" id="contrasena" required />
                    <button type="button" onclick="togglePassword()" id="toggleBtn">👁️</button>
                </div>
            </div>

            <input type="submit" value="Ingresar" class="btn-primary" />
        </form>

        <a href="registro.php" class="btn-secondary">Registrarse</a>
    </div>
</body>
</html>
