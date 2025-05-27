<?php
require_once '../config/configuracion.php';

class Propuesta
{

    private $db;

    public function __construct()
    {
        $this->db = (new Conectar())->ConexionBdRailway();
    }

    public function registrarPropuesta(
        $pTituloPropuesta,
        $pDescripcion,
        $pEsAbierta,
        $pFechaInicio,
        $pFechaFin,
        $pUserRegistro,
        $pInstituciones,
        $pActividades,
        $pUsuarios
    ) {
        try {
            $stmt = $this->db->prepare('CALL sp_RegistrarPropuestaTrabajo(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $pTituloPropuesta,
                $pDescripcion,
                $pEsAbierta,
                $pFechaInicio,
                $pFechaFin,
                $pUserRegistro,
                $pInstituciones,
                $pActividades,
                $pUsuarios
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error in Propuesta::registrarPropuesta: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }
}
