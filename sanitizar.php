<?php
class Sanitizar {

    // Sanear texto eliminando etiquetas HTML y caracteres especiales
    public static function texto(string $dato): string {
        $dato = trim($dato); // Eliminar espacios al inicio y final
        $dato = strip_tags($dato); // Quitar etiquetas HTML
        $dato = htmlspecialchars($dato, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); // Convertir caracteres especiales en entidades HTML
        return $dato;
    }





    // Sanear email y validar formato
    public static function email(string $email): ?string {
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }





    // Sanear nombres, forzando mayúscula inicial y solo letras y espacios
    public static function nombre(string $nombre): string {
        $nombre = trim($nombre);
        $nombre = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/u", "", $nombre); // Solo letras y espacios
        $nombre = mb_convert_case($nombre, MB_CASE_TITLE, "UTF-8"); // Mayúscula en inicial de cada palabra
        return $nombre;
    }





    // Sanear usuario: quitar espacios y caracteres especiales no permitidos (ejemplo alfanumérico y guiones bajos)
    public static function usuario(string $usuario): string {
        $usuario = trim($usuario);
        $usuario = preg_replace("/[^a-zA-Z0-9_]/", "", $usuario); 
        return $usuario;
    }



    

    // Sanitizar contraseña solo elimina espacios al inicio y fin (el contenido se mantiene para hash)
    public static function contrasena(string $pass): string {
        return trim($pass);
    }
}
?>
