<?php
//require_once("../config/configuracion.php");
require_once("../models/Titulos.php");

$titulo = new Titulos();
$fechaActual = date("Y-m-d");

$action = $_GET['action'] ?? $_POST['action'] ?? 'Consultar';

header('Content-Type: application/json');

switch ($action) {
    case 'RegistrarTitulo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodTitulo' => null,
                    'NombreTitulo' => $_POST['NombreTitulo'],
                    'Especialidad' => $_POST['Especialidad'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $titulo->crear($data);
                echo json_encode(['status' => true, 'message' => 'Título registrado con éxito.']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Error al registrar título: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ActualizarTitulo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodTitulo' => $_POST['CodTitulo'],
                    'NombreTitulo' => $_POST['NombreTitulo'],
                    'Especialidad' => $_POST['Especialidad'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $titulo->actualizar($data['CodTitulo'], $data);
                echo json_encode(['status' => true, 'message' => 'Título actualizado con éxito.']);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al actualizar título: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ListarTitulos':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = $titulo->listarTodo();
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al listar títulos: ' . $e->getMessage()]);
            }
        }
        break;

    default:
        echo json_encode(['status' => false, 'message' => 'Acción no válida.']);
        break;

    case 'get_titulo':
        try {
            $CodTitulo = $_POST['CodTitulo'] ?? null;
            if (!$CodTitulo) {
                throw new Exception("CodTitulo no proporcionado.");
            }
            $data = $titulo->obtenerTitulo($CodTitulo);
            if ($data) {
                echo json_encode(['status' => true, 'data' => $data, 'message' => 'Título encontrado.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Título no encontrado.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al obtener título: ' . $e->getMessage()]);
        }
        break;
}
?>
