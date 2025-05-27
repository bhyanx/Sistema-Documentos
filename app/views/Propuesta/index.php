<?php
session_start();

// ? VISTA PARA GESTIONAR LAS PROPUESTAS DE TRABAJO

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../Layouts/Head.php"); ?>
    <title>Propuestas - Sistema Documentación</title>
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }

        .dropdown-menu .show {
            position: fixed !important;
        }
    </style>
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
                            <h1>Gestión de Propuestas de Trabajo</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Propuestas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-4" id="divlistadopropuestas">
                            <form action="#" method="post" id="frmbusqueda">
                                <div class="row">
                                    <div class="col-md-12" id="divfiltros">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="filtroTipoPropuesta">Tipo Propuesta:</label>
                                                    <select class="form-control" name="filtroTipoPropuesta" id="filtroTipoPropuesta">
                                                        <option value="0">Institucional</option>
                                                        <option value="1">Abierta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="filtroFecha">Fecha:</label>
                                                    <input type="date" class="form-control" name="filtroFecha" id="filtroFecha" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 offset-md-8">
                                                <div class="form-group mb-0">
                                                    <label for="">&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary btn-sm btn-block" id="btnlistar">
                                                        <i class="fa fa-search"></i> Buscar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label for="">&nbsp;</label>
                                                    <button type="button" class="btn btn-success btn-sm btn-block" id="btnnuevo">
                                                        <i class="fa fa-plus"></i> Nueva Propuesta
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12" id="divtblpropuestas" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-list"></i> Lista de Propuestas</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Aquí se mostrará la lista de propuestas en cards -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="divregistroPropuesta">
                            <div class=" alert alert-info alert-dismissible">
                                <span id="lbldatospropuesta"></span>
                                <button type="button" class="close btn" id="btnchangedatospropuesta"><i class="fas fa-undo-alt"></i></button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-file-alt"></i> Datos de la Propuesta:</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="TituloPropuesta">Título de la Propuesta:</label>
                                                                <input type="text" class="form-control" name="TituloPropuesta" id="TituloPropuesta" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="Descripcion">Descripción:</label>
                                                                <textarea class="form-control" name="Descripcion" id="Descripcion" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="EsAbierta">Es Abierta:</label>
                                                                <select class="form-control" name="EsAbierta" id="EsAbierta" required>
                                                                    <option value="0">No</option>
                                                                    <option value="1">Sí</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="FechaInicio">Fecha de Inicio:</label>
                                                                <input type="date" class="form-control" name="FechaInicio" id="FechaInicio" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="FechaFin">Fecha de Fin:</label>
                                                                <input type="date" class="form-control" name="FechaFin" id="FechaFin" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-success" id="btnGuardarCabecera">Guardar Cabecera</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overlay dark" id="overlay" style="display: none;">
                                            <i class="fas fa-2x fa-sync-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="divInstituciones" style="display: none;">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-file-alt"></i> Instituciones:</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="Instituciones">Instituciones:</label>
                                                        <select class="form-control" name="Instituciones" id="Instituciones" multiple required>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overlay dark" id="overlay" style="display: none;">
                                            <i class="fas fa-2x fa-sync-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divActividades" style="display: none;">
                                <div class="card card-warning">
                                    <!-- /.card-header -->
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Detalle de Actividades</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="DescripcionActividad">Descripción de la Actividad:</label>
                                                            <textarea class="form-control" name="DescripcionActividad" id="DescripcionActividad" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="DuracionDias">Duración en Días:</label>
                                                            <input type="number" class="form-control" name="DuracionDias" id="DuracionDias" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="RequiereTitulo">Requiere Título:</label>
                                                                <select class="form-control" name="RequiereTitulo" id="RequiereTitulo" required>
                                                                <option value="0">No</option>
                                                                <option value="1">Sí</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CodTitulo">Título:</label>
                                                                <select class="form-control" name="CodTitulo" id="CodTitulo">
                                                                    <!-- Aquí se cargarán los títulos desde la base de datos -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="RangoExperiencia">Rango de Experiencia:</label>
                                                                <select class="form-control" name="RangoExperiencia" id="RangoExperiencia">
                                                                    <!-- Aquí se cargarán los rangos de experiencia desde la base de datos -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary" id="btnAgregarActividad">Agregar Actividad</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="divUsuarios" style="display: none;">
                                    <div class="card card-info">
                                        <!-- /.card-header -->
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-users"></i> Usuarios Asignados</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CodUsuario">Código de Usuario:</label>
                                                                <input type="text" class="form-control" name="CodUsuario" id="CodUsuario" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="RolAsignado">Rol Asignado:</label>
                                                                <input type="text" class="form-control" name="RolAsignado" id="RolAsignado" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary" id="btnAgregarUsuario">Agregar Usuario</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success" id="btnGuardarPropuesta">Guardar Propuesta</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php require_once("../Layouts/Footer.php"); ?>
        <script>
            var userMod = "<?php echo isset($_SESSION['CodUsuario']) ? $_SESSION['CodUsuario'] : ''; ?>";
        </script>
        <script src="propuesta.js"></script>
    </div>
</body>

</html>
