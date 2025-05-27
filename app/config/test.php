<?php
require_once './configuracion.php'; 

class TestConexion extends Conectar {
    public function probarConexion() {
        try {
            $conexion = $this->ConexionBdRailway();
            // $conexion = $this->ConexionBdPruebas();
            if ($conexion) {
                echo "Conexión exitosa a la base de datos.";
            } else {
                echo "No se pudo establecer la conexión.";
            }
        } catch (Exception $e) {
            echo "Error al intentar conectar: " . $e->getMessage();
        }
    }
}

$test = new TestConexion();
$test->probarConexion();