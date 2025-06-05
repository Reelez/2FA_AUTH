# 🔐 Sistema de Autenticación 2FA en PHP

Este proyecto es un sistema de autenticación con **verificación en dos pasos (2FA)** utilizando **PHP**, **MySQL** y **Google Authenticator**. Fue desarrollado como una práctica de seguridad web, incluyendo trazabilidad de eventos como registro, login y logout.

## 🧩 Funcionalidades principales

- Registro de usuarios con validaciones seguras.
- Almacenamiento de contraseñas usando `password_hash`.
- Activación del segundo factor (2FA) con código QR.
- Verificación del código 2FA con Google Authenticator.
- Gestión de sesiones seguras y control de acceso.
- Trazabilidad de eventos (registro, inicio/cierre de sesión).
- Soporte para dos usuarios de base de datos:
  - `root` (acceso completo)
  - `usuario_seguro` (permisos mínimos: SELECT, INSERT, UPDATE)

## 📂 Estructura general

- `registro.php` → Registro de usuario.
- `login.php` y `login_form.php` → Inicio de sesión.
- `verificar_2fa.php` → Verificación de código 2FA.
- `panelControl.php` → Panel principal tras autenticación.
- `logout.php` → Cierre de sesión y registro del evento.
- `clases/` → Clases de conexión y trazabilidad.

## 🔄 Flujo del sistema

1. **Registro:** El usuario se registra y se genera un secreto 2FA.
2. **Activación 2FA:** Se escanea un código QR generado desde el servidor.
3. **Inicio de sesión:** El usuario ingresa sus credenciales.
4. **Verificación 2FA:** Se solicita el código del autenticador.
5. **Acceso:** Si el código es válido, accede al panel.
6. **Cierre de sesión:** Se registra el evento y se destruye la sesión.

## 🛠 Tecnologías utilizadas

- PHP 7+
- MySQL / MariaDB
- Google Authenticator (libreta `sonata-project/google-authenticator`)
- HTML / CSS básico
- PDO para conexión segura a la base de datos

## 📎 Repositorio del proyecto

🔗 [https://github.com/Reelez/2FA_AUTH](https://github.com/Reelez/2FA_AUTH)

---

## ⚠️ Notas

- Requiere Composer para instalar dependencias si se usa la librería de Google Authenticator.
- Puedes elegir usar el usuario `root` (`123root`) o el usuario seguro `usuario_seguro` (`123seguro`) en `mysql.inc.php`.
- Asegúrate de que tu servidor tenga habilitado `mbstring` y `openssl`.

---

## ✍️ Autor

Proyecto realizado por **@Reelez** para prácticas académicas y demostración de seguridad web.

