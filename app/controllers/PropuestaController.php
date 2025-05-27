<?php
require_once("../models/Propuesta.php");
require_once("../models/CombosPropuesta.php");

$propuesta = new Propuesta();
$comboPropuesta = new CombosPropuesta();
$fechaActual = date("Y-m-d");

$action = $_GET['action'] ?? $_POST['action'] ?? 'Consultar';

header('Content-Type: application/json');

switch ($action) {
    case 'RegistrarPropuesta':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pTituloPropuesta = $_POST['TituloPropuesta'];
                $pDescripcion = $_POST['Descripcion'];
                $pEsAbierta = $_POST['EsAbierta'];
                $pFechaInicio = $_POST['FechaInicio'];
                $pFechaFin = $_POST['FechaFin'];
                $pUserRegistro = $_SESSION['CodEmpleado'];
                $pInstituciones = $_POST['Instituciones'];
                $pActividades = $_POST['Actividades'];
                $pUsuarios = $_POST['Usuarios'];

                $propuesta->registrarPropuesta(
                    $pTituloPropuesta,
                    $pDescripcion,
                    $pEsAbierta,
                    $pFechaInicio,
                    $pFechaFin,
                    $pUserRegistro,
                    json_encode($pInstituciones),
                    json_encode($pActividades),
                    json_encode($pUsuarios)
                );

                echo json_encode(['status' => true, 'message' => 'Propuesta registrada con éxito.']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Error al registrar propuesta: ' . $e->getMessage()]);
            }
        }
        break;

    case 'combos':
        try {
            $instituciones = $comboPropuesta->comboInstituciones();
            $titulos = $comboPropuesta->comboTitulos();
            $rangos = $comboPropuesta->comboRangosExperiencia();

            $combos = [
                'instituciones' => $instituciones,
                'titulos' => $titulos,
                'rangos' => $rangos
            ];

            echo json_encode(['status' => true, 'data' => $combos, 'message' => 'Combos cargados correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al cargar combos: ' . $e->getMessage()]);
        }
        break;
    case 'getInstituciones':
        try {
            $instituciones = $comboPropuesta->comboInstituciones();
            echo json_encode(['status' => true, 'data' => $instituciones, 'message' => 'Instituciones cargadas correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al cargar instituciones: ' . $e->getMessage()]);
        }
        break;
    default:
        echo json_encode(['status' => false, 'message' => 'Acción no válida.']);
        break;
}
