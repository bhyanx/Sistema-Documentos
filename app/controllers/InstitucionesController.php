<?php
//require_once("../config/configuracion.php");
require_once("../models/Instituciones.php");

$institucion = new Instituciones();
$fechaActual = date("Y-m-d");

$action = $_GET['action'] ?? $_POST['action'] ?? 'Consultar';

header('Content-Type: application/json');

switch ($action) {
    case 'RegistrarInstitucion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodInstitucion' => null,
                    'NombreInstitucion' => $_POST['NombreInstitucion'],
                    'TipoInstitucion' => $_POST['TipoInstitucion'],
                    'Pais' => $_POST['Pais'],
                    'Ciudad' => $_POST['Ciudad'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $institucion->crear($data);
                echo json_encode(['status' => true, 'message' => 'Institución registrada con éxito.']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Error al registrar institución: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ActualizarInstitucion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodInstitucion' => $_POST['CodInstitucion'],
                    'NombreInstitucion' => $_POST['NombreInstitucion'],
                    'TipoInstitucion' => $_POST['TipoInstitucion'],
                    'Pais' => $_POST['Pais'],
                    'Ciudad' => $_POST['Ciudad'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $institucion->actualizar($data['CodInstitucion'], $data);
                echo json_encode(['status' => true, 'message' => 'Institución actualizada con éxito.']);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al actualizar institución: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ListarInstituciones':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = $institucion->listarTodo();
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al listar instituciones: ' . $e->getMessage()]);
            }
        }
        break;

    default:
        echo json_encode(['status' => false, 'message' => 'Acción no válida.']);
        break;

    case 'get_institucion':
        try {
            $CodInstitucion = $_POST['CodInstitucion'] ?? null;
            if (!$CodInstitucion) {
                throw new Exception("CodInstitucion no proporcionado.");
            }
            $data = $institucion->obtenerInstitucion($CodInstitucion);
            if ($data) {
                echo json_encode(['status' => true, 'data' => $data, 'message' => 'Institución encontrada.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Institución no encontrada.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al obtener institución: ' . $e->getMessage()]);
        }
        break;
}

?>
