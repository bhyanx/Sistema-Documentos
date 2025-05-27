<?php
require_once '../config/configuracion.php';

class RangosExperiencia
{

    private $db;

    public function __construct()
    {
        $this->db = (new Conectar())->ConexionBdRailway();
        //$this->db = (new Conectar())->ConexionBdPruebas();
    }

    //* LISTAR TODO 
    public function listarTodo()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM tRangosExperiencia ORDER BY NombreRango');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in RangosExperiencia::listarTodo: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* CREAR RANGO EXPERIENCIA

    public function crear($data){
        try{
            $stmt = $this->db->prepare('INSERT INTO tRangosExperiencia (NombreRango, AniosMinimo, AniosMaximo, Estado, UserUpdate, FechaUpdate) VALUES (?,?,?,?,?,NOW())');
            $stmt->execute([$data['NombreRango'], $data['AniosMinimo'], $data['AniosMaximo'], $data['Estado'], $data['UserUpdate']]);
            return $this->db->lastInsertId();
        }catch(\PDOException $e){
            error_log("Error in RangosExperiencia::crear: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN CREAR RANGO EXPERIENCIA

    //* ACTUALIZAR RANGO EXPERIENCIA

    public function actualizar($CodRango, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tRangosExperiencia SET NombreRango = ?, AniosMinimo = ?, AniosMaximo = ?, Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodRango = ?');
            $stmt->execute([$data['NombreRango'], $data['AniosMinimo'], $data['AniosMaximo'], $data['Estado'], $data['UserUpdate'], $CodRango]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in RangosExperiencia::actualizar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function desactivar($CodRango, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tRangosExperiencia SET Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodRango = ?');
            $stmt->execute([$data['Estado'], $data['UserUpdate'], $CodRango]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in RangosExperiencia::desactivar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN ACTUALIZAR RANGO EXPERIENCIA

    public function obtenerRango($CodRango)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tRangosExperiencia WHERE CodRango = ?');
            $stmt->execute([$CodRango]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in RangosExperiencia::obtenerRango: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }
}
