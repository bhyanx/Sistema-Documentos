<?php
session_start();
require_once '../config/configuracion.php';
require_once '../models/Usuarios.php';

$usuario = new Usuarios();

$action = $_GET['action'] ?? $_POST['action'] ?? 'Consultar';

switch ($action) {

    case 'AccesoUsuario':
        header('Content-Type: application/json');
        $datos = $usuario->Login($_POST["CodUsuario"], $_POST["ClaveAcceso"]);
        if ($datos && is_array($datos)) {
            $row = $datos[0];

            // Limpiar sesión anterior
            session_unset();
            session_destroy();
            session_start();

            // Debug - Verificar datos antes de guardar en sesión
            error_log("Datos a guardar en sesión: " . print_r($row, true));

            // Guardar datos en la sesión
            $_SESSION["CodUsuario"] = $row["CodUsuario"] ?? '';
            $_SESSION["CodEmpleado"] = $row["CodEmpleado"] ?? '';
            $_SESSION["IdRol"] = $row["IdRol"] ?? '';
            $_SESSION["UrlUltimaSession"] = $row["UrlUltimaSession"] ?? '';
            $_SESSION["ClaveAcceso"] = $row["ClaveAcceso"] ?? '';
            $_SESSION["NombreTrabajador"] = $row["NombreTrabajador"] ?? '';
            $_SESSION["PrimerNombre"] = $row["PrimerNombre"] ?? '';
            $_SESSION["SegundoNombre"] = $row["SegundoNombre"] ?? '';
            $_SESSION["ApellidoPaterno"] = $row["ApellidoPaterno"] ?? '';
            $_SESSION["ApellidoMaterno"] = $row["ApellidoMaterno"] ?? '';

            // Debug - Verificar datos guardados en sesión
            error_log("Datos guardados en sesión: " . print_r($_SESSION, true));

            // Cargar los permisos del usuario
            $idRol = $_SESSION['IdRol'];
            error_log("IdRol del usuario: " . $idRol);
            $datapermisos = $usuario->leerMenuRol($idRol);
            error_log("Permisos recuperados: " . print_r($datapermisos, true));
            if (is_array($datapermisos) && count($datapermisos) > 0) {
                $_SESSION['Permisos'] = $datapermisos;

                // Verificar si el usuario tiene permisos para acceder
                $tienePermisos = false;
                foreach ($datapermisos as $permiso) {
                    if ($permiso['Permiso'] == 1) {
                        $tienePermisos = true;
                        break;
                    }
                }

                if ($tienePermisos) {
                    if (empty($row["UrlUltimaSession"])) {
                        $result = array('status' => true, 'msg' => '/app/views/Inicio/');
                    } else {
                        $result = array('status' => true, 'msg' => $row["UrlUltimaSession"]);
                    }
                } else {
                    $result = array('status' => false, 'msg' => 'No tiene permisos para acceder al sistema');
                }
            } else {
                $result = array('status' => false, 'msg' => 'No se encontraron permisos para el usuario');
            }
        } else {
            $result = array('status' => false, 'msg' => 'Usuario o contraseña incorrectos');
        }
        echo json_encode($result);
        exit();
        break;

    default:
        $result = array('status' => false, 'msg' => 'No se encontraron permisos para el usuario');
        echo json_encode($result);
        break;
}
