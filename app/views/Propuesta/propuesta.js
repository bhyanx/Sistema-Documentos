$(document).ready(function () {
  init();
});

function init() {
  // Ocultar secciones al cargar
  $("#divregistroPropuesta").hide();

  // Botón para abrir el panel de generación de movimiento
  $("#btnnuevo")
    .off("click")
    .on("click", function () {
      $("#divregistroPropuesta").show();
      $("#divtblpropuestas").hide();
      $("#divlistadopropuestas").hide(); // Oculta el formulario de búsqueda
    });

  // Botón cancelar en registro de propuesta
  $("#btnCancelarPropuesta")
    .off("click")
    .on("click", function () {
      $("#divregistroPropuesta").hide();
      $("#divtblpropuestas").show();
      $("#divlistadopropuestas").show();
    });

  // Al buscar, mostrar la tabla y ocultar formularios
  $("#frmbusqueda").on("submit", function (e) {
    e.preventDefault();
    $("#divtblpropuestas").show();
    $("#divregistroPropuesta").hide();
    $("#divlistadopropuestas").show();
    //if (typeof listarPropuestas === "function") listarPropuestas();
  });

    // Cargar combos al cargar la página
    ListarCombos();

    // Función para cargar los combos
    function ListarCombos() {
        $.ajax({
            url: "../../controllers/PropuestaController.php?action=combos",
            type: "POST",
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    $("#Instituciones").html(function() {
                        let options = '<option value="">Seleccione</option>';
                        $.each(res.data.instituciones, function(i, institucion) {
                            options += `<option value="${institucion.CodInstitucion}">${institucion.NombreInstitucion}</option>`;
                        });
                        return options;
                    }).select2({ theme: 'bootstrap4' });

                    $("#CodTitulo").html(function() {
                        let options = '<option value="">Seleccione</option>';
                        $.each(res.data.titulos, function(i, titulo) {
                            options += `<option value="${titulo.CodTitulo}">${titulo.NombreTitulo}</option>`;
                        });
                        return options;
                    }).select2({ theme: 'bootstrap4' });

                    $("#RangoExperiencia").html(function() {
                        let options = '<option value="">Seleccione</option>';
                        $.each(res.data.rangos, function(i, rango) {
                            options += `<option value="${rango.CodRango}">${rango.NombreRango}</option>`;
                        });
                        return options;
                    }).select2({ theme: 'bootstrap4' });
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "No se pudieron cargar los combos: " + error, "error");
            }
        });
    }

    //Botón cancelar en registro de propuesta
    $("#btnCancelarPropuesta")
        .off("click")
        .on("click", function () {
            $("#divregistroPropuesta").hide();
            $("#divtblpropuestas").show();
            $("#divlistadopropuestas").show();
        });

    //Botón guardar propuesta
    $("#btnGuardarPropuesta")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();

            // Obtener los valores de los campos del formulario
            var TituloPropuesta = $("#TituloPropuesta").val();
            var Descripcion = $("#Descripcion").val();
            var EsAbierta = $("#EsAbierta").val();
            var FechaInicio = $("#FechaInicio").val();
            var FechaFin = $("#FechaFin").val();
            var Instituciones = $("#Instituciones").val();
            var DescripcionActividad = $("#DescripcionActividad").val();
            var DuracionDias = $("#DuracionDias").val();
            var RequiereTitulo = $("#RequiereTitulo").val();
            var CodTitulo = $("#CodTitulo").val();
            var RangoExperiencia = $("#RangoExperiencia").val();
            var CodUsuario = $("#CodUsuario").val();
            var RolAsignado = $("#RolAsignado").val();

            // Crear un objeto con los datos del formulario
            var data = {
                TituloPropuesta: TituloPropuesta,
                Descripcion: Descripcion,
                EsAbierta: EsAbierta,
                FechaInicio: FechaInicio,
                FechaFin: FechaFin,
                Instituciones: Instituciones,
                Actividades: [], // TODO: Implementar la lógica para agregar actividades
                Usuarios: [] // TODO: Implementar la lógica para agregar usuarios
            };

            // Enviar los datos al controlador
            $.ajax({
                url: "../../controllers/PropuestaController.php?action=RegistrarPropuesta",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (res) {
                    if (res.status) {
                        Swal.fire("Éxito", res.message, "success");
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire("Error", "No se pudo registrar la propuesta: " + error, "error");
                }
            });
        });
}
