<?php
require_once 'clases/mysql.inc.php';

class Trazabilidad {
    private $db;

    public function __construct() {
        $this->db = new mod_db();
    }

    /**
     * Registra un evento en la tabla trazabilidad.
     * @param string $usuario - Nombre de usuario.
     * @param string $evento - Tipo de evento (login, logout, etc.).
     */
    public function registrarEvento($usuario, $evento) {
        $fechaHora = date('Y-m-d H:i:s');

        $datos = [
            'usuario' => $usuario,
            'evento' => $evento,
            'fecha_hora' => $fechaHora
        ];

        $this->db->insertSeguro('trazabilidad', $datos);
    }
}
