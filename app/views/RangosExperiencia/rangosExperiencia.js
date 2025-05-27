// Cambia el evento submit para decidir si es guardar o editar
function init() {
  $("#frmmantenimiento").on("submit", (e) => {
    // e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    let action =
      $("#CodRango").val() == "0" || $("#CodRango").val() == ""
        ? "RegistrarRangoExperiencia"
        : "ActualizarRangoExperiencia";
    if (action === "RegistrarRangoExperiencia") {
      guardarRangoExperiencia(e);
    } else {
      editarRangoExperiencia(e);
    }
  });
}

$(document).ready(() => {
  listarRangosExperiencia();
});

function listarRangosExperiencia() {
  $("#tblRangosExperiencia").DataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    colReorder: true,
    autoWidth: false,
    buttons: [
      {
        extend: "excelHtml5",
        title: "Listado Rangos de Experiencia",
        text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
        autoFilter: true,
        sheetName: "Data",
        exportOptions: {
          columns: [1, 2, 3],
        },
      },
      "pageLength",
    ],
    ajax: {
      url: "../../controllers/RangosExperienciaController.php?action=ListarRangosExperiencia",
      type: "POST",
      dataType: "json",
      data: {
        NombreRango: "",
        AniosMinimo: "",
        AniosMaximo: "",
        Estado: "",
      },
      dataSrc: function (json) {
        console.log("Consultar response:", json); // Para depuración
        return json || [];
      },
      error: function (xhr, status, error) {
        console.log("Error en AJAX:", xhr.responseText, status, error);
        Swal.fire(
          "Gestionar Rangos de Experiencia",
          "Error al cargar datos: " + error,
          "error"
        );
      },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 10,
    autoWidth: false,
    language: {
      processing: "Procesando...",
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      emptyTable: "Ningún dato disponible en esta tabla",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      search: "Buscar:",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    columnDefs: [
      {
        targets: 0,
        data: null,
        render: function (data, type, row) {
          return (
            '<button class="btn btn-sm btn-primary" onclick="editar(event, ' +
            row.CodRango +
            ')"><i class="fa fa-edit"></i></button>'
          );
        },
      },
      { targets: 1, data: "NombreRango" },
      { targets: 2, data: "AniosMinimo" },
      { targets: 3, data: "AniosMaximo" },
      {
        targets: 4,
        data: "Estado",
        render: function (data, type, row) {
          // console.log("Valor de data:", data);
          let clase = "";
          let texto = "";
          switch (data) {
            case 1:
              clase = "badge-success";
              texto = "Activo"
              break;
            case 0:
              clase = "bg-warning text-dark";
              texto = "Inactivo"
              break;

            default:
              clase = "bg-light text-dark";
          }
          return `<span class="badge ${clase}">${texto}</span>`;
        },
      },
    ],
  })
}

function guardarRangoExperiencia(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "RegistrarRangoExperiencia");

  $.ajax({
    url: "../../controllers/RangosExperienciaController.php?action=RegistrarRangoExperiencia",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Guardar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblRangosExperiencia").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Rangos de Experiencia", res.message, "success");
      } else {
        Swal.fire("Gestionar Rangos de Experiencia", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en guardar:", xhr.responseText, status, error);
      Swal.fire(
        "Gestionar Rangos de Experiencia",
        "Error al guardar: " + error,
        "error"
      );
    },
  });
}

function editarRangoExperiencia(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "ActualizarRangoExperiencia");

  $.ajax({
    url: "../../controllers/RangosExperienciaController.php?action=ActualizarRangoExperiencia",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Editar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblRangosExperiencia").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Rangos de Experiencia", res.message, "success");
      } else {
        Swal.fire("Gestionar Rangos de Experiencia", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en editar:", xhr.responseText, status, error);
      Swal.fire(
        "Gestionar Rangos de Experiencia",
        "Error al editar: " + error,
        "error"
      );
    },
  });
}

$("#btnnuevo").click(() => {
  $("#tituloModalMantenimiento").html(
    '<i class="fa fa-plus-circle"></i> Registrar Rango de Experiencia'
  );
  $("#frmmantenimiento")[0].reset();
  $("#CodRango").val("0");
  $("#ModalMantenimiento").modal("show");
});

function editar(event, CodRango) {
  event.preventDefault();
  // Carga los combos y luego los datos del activo
  $.ajax({
    url: "../../controllers/RangosExperienciaController.php?action=get_rango",
    type: "POST",
    data: { CodRango: CodRango },
    dataType: "json",
    success: (res) => {
      if (res.status) {
        let data = res.data;
        console.log("Datos del rango de experiencia:", data);
        $("#CodRango").val(data.CodRango);
        $("#NombreRango").val(data.NombreRango);
        $("#AniosMinimo").val(data.AniosMinimo);
        $("#AniosMaximo").val(data.AniosMaximo);
        $("#Estado").val(data.Estado);

        $("#ModalMantenimiento").modal("show");
      } else {
        Swal.fire(
          "Gestionar Rangos de Experiencia",
          "No se pudo obtener el rango de experiencia: " + res.message,
          "warning"
        );
      }
    },
    error: (xhr, status, error) => {
      Swal.fire(
        "Gestionar Rangos de Experiencia",
        "Error al obtener el rango de experiencia: " + error,
        "error"
      );
    },
  });
}

// Hacer global la función para el onclick
window.editar = editar;

init();
