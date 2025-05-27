// Cambia el evento submit para decidir si es guardar o editar
function init() {
  $("#frmmantenimiento").on("submit", (e) => {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    let action =
      $("#CodTitulo").val() == "0" || $("#CodTitulo").val() == ""
        ? "RegistrarTitulo"
        : "ActualizarTitulo";
    if (action === "RegistrarTitulo") {
      guardarTitulo(e);
    } else {
      editarTitulo(e);
    }
  });
}

$(document).ready(() => {
  listarTitulos();
});

function listarTitulos() {
  $("#tblTitulos").DataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    colReorder: true,
    autoWidth: false,
    buttons: [
      {
        extend: "excelHtml5",
        title: "Listado Títulos",
        text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
        autoFilter: true,
        sheetName: "Data",
        exportOptions: {
          columns: [1, 2],
        },
      },
      "pageLength",
    ],
    ajax: {
      url: "../../controllers/TitulosController.php?action=ListarTitulos",
      type: "POST",
      dataType: "json",
      data: {
        NombreTitulo: "",
        Especialidad: "",
        Estado: "",
      },
      dataSrc: function (json) {
        console.log("Consultar response:", json); // Para depuración
        return json || [];
      },
      error: function (xhr, status, error) {
        console.log("Error en AJAX:", xhr.responseText, status, error);
        Swal.fire(
          "Gestionar Títulos",
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
            row.CodTitulo +
            ')"><i class="fa fa-edit"></i></button>'
          );
        },
      },
      { targets: 1, data: "NombreTitulo" },
      { targets: 2, data: "Especialidad" },
      {
        targets: 3,
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
              texto = "Inactivo"
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

function guardarTitulo(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "RegistrarTitulo");

  $.ajax({
    url: "../../controllers/TitulosController.php?action=RegistrarTitulo",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Guardar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblTitulos").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Títulos", res.message, "success");
      } else {
        Swal.fire("Gestionar Títulos", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en guardar:", xhr.responseText, status, error);
      Swal.fire("Gestionar Títulos", "Error al guardar: " + error, "error");
    },
  });
}

function editarTitulo(e) {
  e.preventDefault();
  let frmmantenimiento = new FormData($("#frmmantenimiento")[0]);
  frmmantenimiento.append("UserUpdate", userMod);
  frmmantenimiento.append("action", "ActualizarTitulo");

  $.ajax({
    url: "../../controllers/TitulosController.php?action=ActualizarTitulo",
    type: "POST",
    data: frmmantenimiento,
    contentType: false,
    processData: false,
    success: (res) => {
      console.log("Editar response:", res);
      if (res.status) {
        $("#frmmantenimiento")[0].reset();
        $("#tblTitulos").DataTable().ajax.reload();
        $("#ModalMantenimiento").modal("hide");
        Swal.fire("Gestionar Títulos", res.message, "success");
      } else {
        Swal.fire("Gestionar Títulos", res.message, "error");
      }
    },
    error: (xhr, status, error) => {
      console.log("Error en editar:", xhr.responseText, status, error);
      Swal.fire("Gestionar Títulos", "Error al editar: " + error, "error");
    },
  });
}

$("#btnnuevo").click(() => {
  $("#tituloModalMantenimiento").html(
    '<i class="fa fa-plus-circle"></i> Registrar Título'
  );
  $("#frmmantenimiento")[0].reset();
  $("#CodTitulo").val("0");
  $("#ModalMantenimiento").modal("show");
});

function editar(event, CodTitulo) {
  event.preventDefault();
  // Carga los combos y luego los datos del activo
  $.ajax({
    url: "../../controllers/TitulosController.php?action=get_titulo",
    type: "POST",
    data: { CodTitulo: CodTitulo },
    dataType: "json",
    success: (res) => {
      if (res.status) {
        let data = res.data;
        console.log("Datos del titulo:", data);
        $("#CodTitulo").val(data.CodTitulo);
        $("#NombreTitulo").val(data.NombreTitulo);
        $("#Especialidad").val(data.Especialidad);
        $("#Estado").val(data.Estado);

        $("#ModalMantenimiento").modal("show");
      } else {
        Swal.fire(
          "Gestionar Títulos",
          "No se pudo obtener el titulo: " + res.message,
          "warning"
        );
      }
    },
    error: (xhr, status, error) => {
      Swal.fire(
        "Gestionar Títulos",
        "Error al obtener el titulo: " + error,
        "error"
      );
    },
  });
}

// Hacer global la función para el onclick
window.editar = editar;

init();
