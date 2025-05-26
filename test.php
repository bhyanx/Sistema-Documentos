<?php
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

class TestConexion extends Conectar {
    public function probarConexion() {
        try {
            $conexion = $this->ConexionBdPracticante();
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