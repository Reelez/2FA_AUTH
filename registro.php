<?php
require 'vendor/autoload.php';
include("clases/mysql.inc.php");

session_start();
$db = new mod_db();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Sanitizar::usuario($_POST['usuario'] ?? '');
            $nombre = Sanitizar::nombre($_POST['nombre'] ?? '');
            $apellido = Sanitizar::nombre($_POST['apellido'] ?? '');
            $correo = Sanitizar::email($_POST['correo'] ?? '');
            $contrasena = Sanitizar::contrasena($_POST['contrasena'] ?? '');


    // Convertir nombre y apellido a mayúsculas
    $nombre = mb_strtoupper(trim($nombre), 'UTF-8');
    $apellido = mb_strtoupper(trim($apellido), 'UTF-8');

    if ($nombre && $usuario && $correo && $contrasena) {

        // Verificar que usuario no exista
        $sqlUsuario = "SELECT COUNT(*) FROM usuarios WHERE Usuario = " . $db->sql_quote($usuario);
        $existeUsuario = $db->consultar($sqlUsuario)->fetchColumn();

        if ($existeUsuario) {
            $mensaje = "<div class='alert alert-warning'>⚠️ El nombre de usuario ya está en uso.</div>";
        } else {
            // Verificar que correo no exista
            $sqlCorreo = "SELECT COUNT(*) FROM usuarios WHERE correo = " . $db->sql_quote($correo);
            $existeCorreo = $db->consultar($sqlCorreo)->fetchColumn();

            if ($existeCorreo) {
                $mensaje = "<div class='alert alert-warning'>⚠️ El correo ya está registrado.</div>";
            } else {
                // Validar longitud mínima de contraseña
                if (strlen($contrasena) < 8) {
                    $mensaje = "<div class='alert alert-warning'>⚠️ La contraseña debe tener al menos 8 caracteres.</div>";
                } else {
                    // todo OK, insertar usuario
                    $hash = password_hash($contrasena, PASSWORD_BCRYPT);//se encripta la contra

                    $sqlInsert = "INSERT INTO usuarios (Nombre, Usuario, Apellido, correo, Sexo, HashMagic) VALUES (
                        " . $db->sql_quote($nombre) . ",
                        " . $db->sql_quote($usuario) . ",
                        " . $db->sql_quote($apellido) . ",
                        " . $db->sql_quote($correo) . ",
                        $sexo,
                        " . $db->sql_quote($hash) . "
                    )";

                    if ($db->consultar($sqlInsert)) {
                        $_SESSION['usuario'] = $usuario;
                        $usuario_id = $db->getConexion()->lastInsertId();
                        $_SESSION['usuario_id'] = $usuario_id;

                        header("Location: GenerarSecreto.php");
                        exit;
                    } else {
                        $mensaje = "<div class='alert alert-danger'>❌ Error al registrar el usuario.</div>";
                    }
                }
            }
        }

    } else {
        $mensaje = "<div class='alert alert-warning'>⚠️ Todos los campos son obligatorios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/formulario.css" />
    <script>
    function togglePassword() {
        const input = document.getElementById("contrasena");
        const icon = document.getElementById("toggleBtn");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈";
        } else {
            input.type = "password";
            icon.textContent = "👁️";
        }
    }
    </script>
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card">
        <h3>📝 Formulario de Registro</h3>
        <?= $mensaje ?? '' ?>
        <form method="POST" action="">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required />

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required />

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required />

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required />

            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" required>
                <option value="0">Masculino</option>
                <option value="1">Femenino</option>
            </select>

            <label for="contrasena">Contraseña</label>
            <div style="display:flex; gap:10px; align-items:center;">
                <input type="password" id="contrasena" name="contrasena" required />
                <button type="button" onclick="togglePassword()" id="toggleBtn">👁️</button>
            </div>

            <button type="submit" class="btn-primary">Registrarse</button>
        </form>
    </div>
</div>

</body>
</html>
