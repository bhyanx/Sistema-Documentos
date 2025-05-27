<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Conectar {
    
    protected $dbh;

    public function ConexionBdRailway()
    {
        try {
            $conexion = new PDO(
                "mysql:host=metro.proxy.rlwy.net;port=31823;dbname=railway",
                'root',
                'KkjRAMPoRgXeUGERlhCQCZCuyWsGcVgl'
            );
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            // error_log("Error de conexión a bdPracticante: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            error_log("Error de conexión a bdPracticante: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
