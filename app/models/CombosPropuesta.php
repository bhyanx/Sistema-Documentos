<?php
require_once '../config/configuracion.php';

class CombosPropuesta
{

    private $db;

    public function __construct()
    {
        $this->db = (new Conectar())->ConexionBdRailway();
        //$this->db = (new Conectar())->ConexionBdPruebas();
    }

    public function comboInstituciones()
    {
        try {
            $stmt = $this->db->query('SELECT CodInstitucion, NombreInstitucion FROM tInstituciones WHERE Estado = 1 ORDER BY NombreInstitucion');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in CombosPropuesta::comboInstituciones: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function comboTitulos()
    {
        try {
            $stmt = $this->db->query('SELECT CodTitulo, NombreTitulo FROM tTitulos WHERE Estado = 1 ORDER BY NombreTitulo');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in CombosPropuesta::comboTitulos: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function comboRangosExperiencia()
    {
        try {
            $stmt = $this->db->query('SELECT CodRango, NombreRango FROM tRangosExperiencia WHERE Estado = 1 ORDER BY NombreRango');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in CombosPropuesta::comboRangosExperiencia: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }
}
