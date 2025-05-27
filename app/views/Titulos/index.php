<?php
session_start();
// require_once("../../config/configuracion.php");
// if (isset($_SESSION["CodEmpleado"])) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../Layouts/Head.php"); ?>
    <title>Títulos - Sistema Documentación</title>
</head>

<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed sidebar-mini-xs sidebar-mini-md sidebar-collapse">
    <div class="wrapper">
        <?php require_once("../Layouts/Header.php"); ?>
        <?php require_once("../Layouts/SideBar.php"); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Gestión de Títulos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión de Títulos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> Lista de Títulos</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12" id="divfiltros">
                                            <div class="row">
                                                <div class="col-md-3 offset-md-9">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block" id="btnnuevo">
                                                            <i class="fa fa-plus"></i> Nuevo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="tblTitulos" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <i class="fa fa-cogs"></i>
                                                            </th>
                                                            <th>Nombre Título</th>
                                                            <th>Especialidad</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>
                                                                <i class="fa fa-cogs"></i>
                                                            </th>
                                                            <th>Nombre Título</th>
                                                            <th>Especialidad</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="ModalMantenimiento" tabindex="-1" role="dialog" aria-labelledby="ModalMantenimientoLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="tituloModalMantenimiento"><i class="fa fa-plus-circle"></i> Registrar Título</h5>
                                </div>
                                <form id="frmmantenimiento">
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="CodTitulo" id="CodTitulo" value="0">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="NombreTitulo">Nombre Título:</label>
                                                    <input type="text" name="NombreTitulo" id="NombreTitulo" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Especialidad">Especialidad:</label>
                                                    <input type="text" name="Especialidad" id="Especialidad" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Estado">Estado:</label>
                                                    <select name="Estado" id="Estado" class="form-control" required>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                        <button type="submit" class="btn btn-primary" id="btnguardar"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once("../Layouts/Footer.php"); ?>
        <script>
            var userMod = "<?php echo isset($_SESSION['CodEmpleado']) ? $_SESSION['CodEmpleado'] : ''; ?>";
        </script>
        <script src="titulos.js"></script>
    </div>
</body>

</html>
<?php
// } else {
//     header("Location: " . Conectar::ruta());
//     exit();
// }
?>
