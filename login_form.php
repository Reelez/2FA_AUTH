<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css" type="text/css" />
    <script src="jquery/jquery-latest.js"></script>
    <script src="jquery/jquery.validate.js"></script>
    <script>
    $(document).ready(function(){
        $("#deteccionUser").validate({
            rules: {
                usuario: "required",
                contrasena: "required"
            }
        });
    });
    </script>
</head>
<body>
    <div class="login-card">
        <h2>Iniciar sesión</h2>
        <form id="deteccionUser" method="POST" action="procesar_login.php">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input id="usuario" name="usuario" type="text" required />
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <div style="position: relative;">
                    <input id="contrasena" name="contrasena" type="password" required />
                    <button type="button" id="togglePassword" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer;">👁️</button>
                </div>
            </div>

            <input type="submit" value="Ingresar" class="btn-primary" />
        </form>

        <a href="registro.php" class="btn-secondary">Registrarse</a>
    </div>

    <script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordInput = document.getElementById("contrasena");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.textContent = type === "password" ? "👁️" : "🙈";
    });
    </script>
</body>
</html>
