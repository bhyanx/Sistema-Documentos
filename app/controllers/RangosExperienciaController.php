<?php
//require_once("../config/configuracion.php");
require_once("../models/RangosExperiencia.php");

$rangoExperiencia = new RangosExperiencia();
$fechaActual = date("Y-m-d");

$action = $_GET['action'] ?? $_POST['action'] ?? 'Consultar';

header('Content-Type: application/json');

switch ($action) {
    case 'RegistrarRangoExperiencia':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodRango' => null,
                    'NombreRango' => $_POST['NombreRango'],
                    'AniosMinimo' => $_POST['AniosMinimo'],
                    'AniosMaximo' => $_POST['AniosMaximo'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $rangoExperiencia->crear($data);
                echo json_encode(['status' => true, 'message' => 'Rango de experiencia registrado con éxito.']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Error al registrar rango de experiencia: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ActualizarRangoExperiencia':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'CodRango' => $_POST['CodRango'],
                    'NombreRango' => $_POST['NombreRango'],
                    'AniosMinimo' => $_POST['AniosMinimo'],
                    'AniosMaximo' => $_POST['AniosMaximo'],
                    'Estado' => $_POST['Estado'],
                    'UserUpdate' => $_SESSION['CodEmpleado']
                ];
                $rangoExperiencia->actualizar($data['CodRango'], $data);
                echo json_encode(['status' => true, 'message' => 'Rango de experiencia actualizado con éxito.']);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al actualizar rango de experiencia: ' . $e->getMessage()]);
            }
        }
        break;

    case 'ListarRangosExperiencia':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = $rangoExperiencia->listarTodo();
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'message' => 'Error al listar rangos de experiencia: ' . $e->getMessage()]);
            }
        }
        break;

    case 'get_rango':
        try {
            $CodRango = $_POST['CodRango'] ?? null;
            if (!$CodRango) {
                throw new Exception("CodRango no proporcionado.");
            }
            $data = $rangoExperiencia->obtenerRango($CodRango);
            if ($data) {
                echo json_encode(['status' => true, 'data' => $data, 'message' => 'Rango de experiencia encontrado.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Rango de experiencia no encontrado.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al obtener rango de experiencia: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => false, 'message' => 'Acción no válida.']);
        break;
}
?>
