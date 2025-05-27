<?php

class Usuarios
{

    private $db;

    public function __construct()
    {
        $this->db = (new Conectar())->ConexionBdRailway();
    }

    public function Login($CodUsuario, $ClaveAcceso)
    {
        try {
            $sql = "SELECT * FROM vAccesoLogin WHERE CodUsuario = ? AND ClaveAcceso = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $CodUsuario);
            $stmt->bindParam(2, $ClaveAcceso);
            $stmt->execute();

            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            error_log("Datos retornados por login: " . print_r($resultado, true));

            if (empty($resultado)) {
                error_log("No se encontraron resultados para el usuario: " . $CodUsuario);
                return false;
            }

            // Verificar campos específicos
            $row = $resultado[0];
            error_log("NombreTrabajador: " . ($row['NombreTrabajador'] ?? 'no definido'));
            error_log("PrimerNombre: " . ($row['PrimerNombre'] ?? 'no definido'));
            error_log("ApellidoPaterno: " . ($row['ApellidoPaterno'] ?? 'no definido'));

            return $resultado;
        } catch (\PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            throw $e;
        }
    }

     public function leerMenuRol($idRol)
    {
        try {
            $stmt = $this->db->prepare("SELECT p.CodPermiso, p.CodMenu, p.IdRol, p.Permiso, 
                                       m.NombreMenu, m.MenuRuta, m.MenuIdentificador, 
                                       m.MenuIcono, m.MenuGrupo, m.MenuGrupoIcono, m.Estado as EstadoMenu, 
                                       r.NombreRol 
                                       FROM tPermisos p
                                       INNER JOIN tMenu m ON p.CodMenu = m.CodMenu
                                       INNER JOIN tRoles r ON p.IdRol = r.IdRol
                                       WHERE p.IdRol = ? AND m.Estado = 1 AND p.Permiso = 1
                                       ORDER BY m.MenuGrupo, m.NombreMenu");
            $stmt->execute([$idRol]);
            $menus = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Procesar las rutas
            foreach ($menus as &$menu) {
                if (strpos($menu['MenuRuta'], '../') === 0) {
                    $menu['MenuRuta'] = '/app/views/' . substr($menu['MenuRuta'], 3);
                }
            }

            return $menus;
        } catch (\PDOException $e) {
            error_log("Error in leerMenuRol: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }

     public function leerMenuGrupo($idRol)
    {
        try {
            $stmt = $this->db->prepare("SELECT DISTINCT m.MenuGrupo, m.MenuGrupoIcono 
                                        FROM tMenu m
                                        INNER JOIN tPermisos p ON m.CodMenu = p.CodMenu
                                        WHERE p.IdRol = ? AND m.Estado = 1 AND p.Permiso = 1
                                        ORDER BY m.MenuGrupo");
            $stmt->execute([$idRol]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in leerMenuGrupo: " . $e->getMessage(), 3, __DIR__ . '/../../logs/errors.log');
            throw $e;
        }
    }
}
