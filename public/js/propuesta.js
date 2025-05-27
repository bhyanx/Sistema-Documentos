$(document).ready(function() {
    var esAbierta = $('#EsAbierta').val();
    var institucionesSelect = $('#Instituciones');
    var cardSuccess = $('.card-success');

    function cargarInstituciones() {
        $.ajax({
            url: '../controllers/PropuestaController.php?action=getInstituciones',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    institucionesSelect.empty();
                    $.each(response.data, function(key, value) {
                        institucionesSelect.append('<option value="' + value.CodInstitucion + '">' + value.NombreInstitucion + '</option>');
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error al cargar las instituciones.');
            }
        });
    }

    function actualizarVisibilidadInstituciones() {
        if (esAbierta == 1) {
            cardSuccess.hide();
            institucionesSelect.removeAttr('required'); // Permitir no seleccionar instituciones
            institucionesSelect.attr('multiple', 'multiple'); // Permitir seleccionar múltiples instituciones
        } else {
            cardSuccess.show();
            institucionesSelect.attr('required', 'required'); // Requerir seleccionar instituciones
            institucionesSelect.removeAttr('multiple'); // No permitir seleccionar múltiples instituciones
        }
    }

    cargarInstituciones();
    actualizarVisibilidadInstituciones();

    var datosCabecera = {};

    $('#btnGuardarCabecera').click(function() {
        datosCabecera = {
            TituloPropuesta: $('#TituloPropuesta').val(),
            Descripcion: $('#Descripcion').val(),
            EsAbierta: $('#EsAbierta').val(),
            FechaInicio: $('#FechaInicio').val(),
            FechaFin: $('#FechaFin').val()
        };
        console.log(datosCabecera); // Para verificar que los datos se están almacenando correctamente
        $('#divInstituciones').show(); // Mostrar el formulario de instituciones
        $('#divActividades').show(); // Mostrar el formulario de actividades
        $('#divUsuarios').show(); // Mostrar el formulario de usuarios
        actualizarVisibilidadFormularios();
    });

    function actualizarVisibilidadFormularios() {
        if (datosCabecera.EsAbierta == 1) {
            cardSuccess.show(); // Mostrar el formulario de instituciones
        } else {
            cardSuccess.hide(); // Ocultar el formulario de instituciones
        }
    }

    $('#EsAbierta').change(function() {
        datosCabecera.EsAbierta = $(this).val();
        actualizarVisibilidadFormularios();
    });
});
