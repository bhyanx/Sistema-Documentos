<?php
require_once '../config/configuracion.php';

class Titulos
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
            $stmt = $this->db->query('SELECT * FROM tTitulos ORDER BY NombreTitulo');
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Titulos::listarTodo: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* CREAR TITULO

    public function crear($data){
        try{
            $stmt = $this->db->prepare('INSERT INTO tTitulos (NombreTitulo, Especialidad, Estado, UserUpdate, FechaUpdate) VALUES (?,?,?,?,NOW())');
            $stmt->execute([$data['NombreTitulo'], $data['Especialidad'], $data['Estado'], $data['UserUpdate']]);
            return $this->db->lastInsertId();
        }catch(\PDOException $e){
            error_log("Error in Titulos::crear: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN CREAR TITULO

    //* ACTUALIZAR TITULO

    public function actualizar($CodTitulo, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tTitulos SET NombreTitulo = ?, Especialidad = ?, Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodTitulo = ?');
            $stmt->execute([$data['NombreTitulo'], $data['Especialidad'], $data['Estado'], $data['UserUpdate'], $CodTitulo]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in Titulos::actualizar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    public function desactivar($CodTitulo, $data){
        try{
            $stmt = $this->db->prepare('UPDATE tTitulos SET Estado = ?, UserUpdate = ?, FechaUpdate = NOW() WHERE CodTitulo = ?');
            $stmt->execute([$data['Estado'], $data['UserUpdate'], $CodTitulo]);
            return $stmt->rowCount();
        }catch(\PDOException $e){
            error_log("Error in Titulos::desactivar: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

    //* FIN ACTUALIZAR TITULO

    public function obtenerTitulo($CodTitulo)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tTitulos WHERE CodTitulo = ?');
            $stmt->execute([$CodTitulo]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Titulos::obtenerTitulo: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }
}
