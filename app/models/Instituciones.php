<?php
require_once '../config/configuracion.php';

class Instituciones
{

    private $db;

    public function __construct()
    {
        $this->db = (new Conectar())->ConexionBdRailway();
    }

    //* LISTAR TODO 
    public function listarTodo()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM tInstituciones ORDER BY NombreInstitucion');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Instituciones::listarTodo: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* CREAR INSTITUCION

    public function crear($data){
        try{
            $stmt = $this->db->prepare('INSERT INTO tInstituciones (NombreInstitucion, TipoInstitucion, Pais, Ciudad, Estado, UserUpdate, FechaUpdate) VALUES (?,?,?,?,?,?,NOW())');
            $stmt->execute([$data['NombreInstitucion'], $data['TipoInstitucion'], $data['Pais'], $data['Ciudad'], $data['Estado'], $data['UserUpdate']]);
            return $this->db->lastInsertId();
        }catch(\PDOException $e){
            error_log("Error in Instituciones::crear: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN CREAR INSTITUCION

    //* ACTUALIZAR INSTITUCION

    public function actualizar($CodInstitucion, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tInstituciones SET NombreInstitucion = ?, TipoInstitucion = ?, Pais = ?, Ciudad = ?, Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodInstitucion = ?');
            $stmt->execute([$data['NombreInstitucion'], $data['TipoInstitucion'], $data['Pais'], $data['Ciudad'], $data['Estado'], $data['UserUpdate'], $CodInstitucion]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in Instituciones::actualizar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function desactivar($CodInstitucion, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tInstituciones SET Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodInstitucion = ?');
            $stmt->execute([$data['Estado'], $data['UserUpdate'], $CodInstitucion]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in Instituciones::desactivar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function obtenerInstitucion($CodInstitucion)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tInstituciones WHERE CodInstitucion = ?');
            $stmt->execute([$CodInstitucion]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Instituciones::obtenerInstitucion: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN ACTUALIZAR INSTITUCION
}
