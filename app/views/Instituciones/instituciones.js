// Cambia el evento submit para decidir si es guardar o editar
function init() {
  $("#frmmantenimiento").on("submit", (e) => {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    let action =
      $("#CodInstitucion").val() == "0" || $("#CodInstitucion").val() == ""
        ? "RegistrarInstitucion"
        : "ActualizarInstitucion";
    if (action === "RegistrarInstitucion") {
      guardarInstitucion(e);
    } else {
      editarInstitucion(e);
    }
  });
}

$(document).ready(() => {
  listarInstituciones();
});

function listarInstituciones() {
  $("#tblInstituciones").DataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    colReorder: true,
    autoWidth: false,
    buttons: [
      {
        extend: "excelHtml5",
        title: "Listado Instituciones",
        text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
        autoFilter: true,
        sheetName: "Data",
        exportOptions: {
          columns: [1, 2, 3, 4],
        },
      },
      "pageLength",
    ],
    ajax: {
      url: "../../controllers/InstitucionesController.php?action=ListarInstituciones",
      type: "POST",
      dataType: "json",
      data: {
        NombreInstitucion: "",
        TipoInstitucion: "",
        Pais: "",
        Ciudad: "",
        Estado: "",
      },
      dataSrc: function (json) {
        console.log("Consultar response:", json); // Para depuración
        return json || [];
      },
      error: function (xhr, status, error) {
        console.log("Error en AJAX:", xhr.responseText, status, error);
        Swal.fire(
          "Gestionar Instituciones",
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
            row.CodInstitucion +
            ')"><i class="fa fa-edit"></i></button>'
          );
        },
      },
      { targets: 1, data: "NombreInstitucion" },
      { targets: 2, data: "TipoInstitucion" },
      { targets: 3, data: "Pais" },
      { targets: 4, data: "Ciudad" },
      {
        targets: 5,
        data: "Estado",
        render: function (data, type, row) {
          // console.log("Valor de data:", data);
          let clase = "";
          let texto = "";
          switch (data) {
            case 1:
              clase = "badge-success";
              texto = "Activo";
              break;
            case 0:
              clase = "bg-warning text-dark";
              texto = "Inactivo";
              break;

            default:
              clase = "bg-light text-dark";
          }
          return `<span class="badge ${clase}">${texto}</span>`;
        },
      },
    ],
  });
}

function guardarInstitucion(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "RegistrarInstitucion");

  $.ajax({
    url: "../../controllers/InstitucionesController.php?action=RegistrarInstitucion",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Guardar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblInstituciones").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Instituciones", res.message, "success");
      } else {
        Swal.fire("Gestionar Instituciones", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en guardar:", xhr.responseText, status, error);
      Swal.fire(
        "Gestionar Instituciones",
        "Error al guardar: " + error,
        "error"
      );
    },
  });
}

function editarInstitucion(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "ActualizarInstitucion");

  $.ajax({
    url: "../../controllers/InstitucionesController.php?action=ActualizarInstitucion",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Editar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblInstituciones").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Instituciones", res.message, "success");
      } else {
        Swal.fire("Gestionar Instituciones", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en editar:", xhr.responseText, status, error);
      Swal.fire(
        "Gestionar Instituciones",
        "Error al editar: " + error,
        "error"
      );
    },
  });
}

$("#btnnuevo").click(() => {
  $("#tituloModalMantenimiento").html(
    '<i class="fa fa-plus-circle"></i> Registrar Institución'
  );
  $("#frmmantenimiento")[0].reset();
  $("#CodInstitucion").val("0");
  $("#ModalMantenimiento").modal("show");
});

function editar(event, CodInstitucion) {
  event.preventDefault();
  // Carga los combos y luego los datos del activo
  $.ajax({
    url: "../../controllers/InstitucionesController.php?action=get_institucion",
    type: "POST",
    data: { CodInstitucion: CodInstitucion },
    dataType: "json",
    success: (res) => {
      if (res.status) {
        let data = res.data;
        console.log("Datos de la institucion:", data);
        $("#CodInstitucion").val(data.CodInstitucion);
        $("#NombreInstitucion").val(data.NombreInstitucion);
        $("#TipoInstitucion").val(data.TipoInstitucion);
        $("#Pais").val(data.Pais);
        $("#Ciudad").val(data.Ciudad);
        $("#Estado").val(data.Estado);

        $("#ModalMantenimiento").modal("show");
      } else {
        Swal.fire(
          "Gestionar Instituciones",
          "No se pudo obtener la institucion: " + res.message,
          "warning"
        );
      }
    },
    error: (xhr, status, error) => {
      Swal.fire(
        "Gestionar Instituciones",
        "Error al obtener la institucion: " + error,
        "error"
      );
    },
  });
}

// Hacer global la función para el onclick
window.editar = editar;

init();
