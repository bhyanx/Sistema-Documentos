<?php
ob_start();
session_start();
// require_once("../../config/configuracion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../Layouts/Head.php"); ?>
    <title>Inicio | Sistema Documentación</title>
</head>

<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed sidebar-mini-xs sidebar-mini-md sidebar-collapse">

    <div class="wrapper">

        <?php require_once("../Layouts/Header.php") ?>

        <?php require_once("../Layouts/SideBar.php") ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Inicio</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Inicio</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="card shadow">
                            <div class="card-body">
                                <img class='img-fluid w-100' src="/public/img/Logo-Lubriseng.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="small-box bg-success shadow">
                            <div class="inner">
                                <h3 id="lblcantidadpropuestas">0</h3>
                                <p>Total Ofertas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más Detalles <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="small-box bg-warning shadow">
                            <div class="inner">
                                <h3 id="lblcantidadpostulantes">0</h3>
                                <p>Postulaciones</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más Detalles <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="small-box bg-danger shadow">
                            <div class="inner">
                                <h3 id="lblcantidadUsuarios">0</h3>
                                <p>Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-gears"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más Detalles <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="small-box bg-info shadow">
                            <div class="inner">
                                <h3 class="lblvalortotalactivos">0</h3>
                                <p>Valor total de activos</p>
                            </div>
                            <div class="icon">
                               <i class="fas fa-chart-line"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más Detalles <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div> -->
                </div>
                <!-- <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-4 order-last">
                        <div class="card bg-gradient">
                            <div class="card-header border-0">

                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i> Calendar
                                </h3>
                                
                                <div class="card-tools">
                                    
                                    <button type="button" class="btn btn btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                               
                            </div>
                            
                            <div class="card-body pt-0">
                               
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-8 d-none">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Registros</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Fecha Inicio:</label>
                                                    <input type="date" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Fecha Fin:</label>
                                                    <input type="date" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-lg-1">
                                                <div class="form-group">
                                                    <label for="">Buscar</label>
                                                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">First</th>
                                                        <th scope="col">Last</th>
                                                        <th scope="col">Handle</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>@mdo</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Jacob</td>
                                                        <td>Thornton</td>
                                                        <td>@fat</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td colspan="2">Larry the Bird</td>
                                                        <td>@twitter</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </section>
            <!-- /.content -->

        </div>

    </div>

    <?php require_once "../Layouts/Footer.php"; ?>

</body>

</html>