<!-- Jquery Min JS -->
<script src="{{ asset('plantilla_admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/metismenu.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/simplebar.min.js') }}"></script>
{{-- <script src="{{ asset('plantilla_admin/js/apexcharts/apexcharts.min.js') }}"></script> --}}
{{-- <script src="{{ asset('plantilla_admin/js/apexcharts/tutor-lms.js') }}"></script> --}}
<script src="{{ asset('plantilla_admin/js/geticons.js') }}"></script>
{{-- <script src="{{ asset('plantilla_admin/js/calendar.js') }}"></script> --}}
{{-- <script src="{{ asset('plantilla_admin/js/calendar.min.js') }}"></script> --}}
<script src="{{ asset('plantilla_admin/js/editor.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/form-validator.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/contact-form-script.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/ajaxchimp.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/custom.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('plantilla_admin/toastr/toastr.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js" ></script> --}}
<script src="{{ asset('plantilla_admin/rodry/repeater/jquery.repeater.js') }}"></script>



<script type="text/javascript" src="{{ asset('plantilla_admin/data_tables/datatables.min.js') }}"></script>

<!-- Scripts -->
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="{{ asset('plantilla_admin/rodry/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plantilla_admin/js/editor.js') }}"></script>
<script>
    //para el separador de miles
    $(".monto_number").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            });
        }
    });

    function monto_validado_enviado(monto) {
        return monto.replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function select2_rodry(valor) {
        $('.select2').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function segundo_select2(valor) {
        $('.select2_segundo').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function tercero_select2(valor) {
        $('.select2_tercero').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function cuarto_select2(valor) {
        $('.select2_cuarto').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function quinto_select2(valor) {
        $('.select2_quinto').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function sexto_select2(valor) {
        $('.select2_sexto').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    $('.select2_partida').select2({
        theme: "bootstrap-5",
        containerCssClass: "select2--small", // For Select2 v4.0
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
        width: '100%'
    });

    function partida_select2(valor) {
        $('.select2_partida').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function fut_select2(valor) {
        $('.select2_fut').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function motDe_select2(valor) {
        $('.select2_mot_de').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }

    function motA_select2(valor) {
        $('.select2_mot_a').select2({
            dropdownParent: $(valor),
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
    }


    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // For Live Projects
    window.addEventListener('load', function() {
        document.querySelector('body').classList.add("loaded")
    });

    function alerta_top(tipo, mensaje) {
        Swal.fire({
            position: 'top-end',
            icon: tipo,
            title: mensaje,
            showConfirmButton: false,
            timer: 1500
        })
    }

    $('.dataTable').dataTable({
        "responsive": true,
    });

    function conSeparadorComas(valor) {
        return valor.toLocaleString("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function formatearConCeros(numero, longitud = 4) {
        return String(numero).padStart(longitud, '0');
    }


    //para repetir algo X
    function repetir_x(valor) {
        $(valor).repeater({
            initEmpty: true,
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },
        });
    }


    $('#btn_cerrar_session').on('click', (e) => {
        e.preventDefault();
        let datos = $('#form_salir').serialize();
        $.ajax({
            type: "POST",
            url: "{{ route('salir') }}",
            data: "data",
            dataType: "JSON",
            success: function(data) {
                if (data.tipo == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(() => {
                        window.location = '';
                    }, 1600);
                }
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function limpiar_campos(form_id) {
        document.getElementById(form_id).reset();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        }))
    });

    //para marcar o desmarcar
    function marcar_desmarcar(source) {
        let checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for (i = 0; i < checkboxes.length; i++) { //recoremos todos los controles
            if (checkboxes[i].type == "checkbox") { //solo si es un checkbox entramos
                checkboxes[i].checked = source
                    .checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            }
        }
    }

    function marcar_desmarcar_e(source) {
        let checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for (i = 0; i < checkboxes.length; i++) { //recoremos todos los controles
            if (checkboxes[i].type == "checkbox") { //solo si es un checkbox entramos
                checkboxes[i].checked = source
                    .checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            }
        }
    }

    //para que solo acepte letras
    function soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }

    //para que solo acepte numeros
    function soloNumeros(e) {
        let key = window.Event ? e.which : e.keyCode
        return ((key >= 48 && key <= 57) || (key == 8))
    }
    //para que solo acepte numeros float
    function filterFloat(evt, input) {
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        if (key >= 48 && key <= 57) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 0) {
                return true;
            } else if (key == 46) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }

    }

    function fecha_literal(fecha, formato) {
        const dias = [
            'Domingo',
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado'
        ];

        const meses = [
            '',
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        ];

        const f = new Date(fecha);

        const dia = f.getDate();
        const mes = f.getMonth() + 1;
        const anio = f.getFullYear();
        const diaSemana = f.getDay();

        switch (formato) {
            case 1: // 05/09/25
                return `${String(dia).padStart(2, '0')}/${String(mes).padStart(2, '0')}/${String(anio).slice(-2)}`;

            case 2: // 05/oct/25
                return `${String(dia).padStart(2, '0')}/${meses[mes].substring(0, 3)}/${String(anio).slice(-2)}`;

            case 3: // octubre 05, 2025
                return `${meses[mes]} ${String(dia).padStart(2, '0')}, ${anio}`;

            case 4: // 5 de octubre de 2025
                return `${dia} de ${meses[mes]} de ${anio}`;

            case 5: // viernes 5 de octubre de 2025
                return `${dias[diaSemana]} ${dia} de ${meses[mes]} de ${anio}`;

            case 6: // 05/10/2025
                return `${String(dia).padStart(2, '0')}/${String(mes).padStart(2, '0')}/${anio}`;

            default: // igual a 6
                return `${String(dia).padStart(2, '0')}/${String(mes).padStart(2, '0')}/${anio}`;
        }
    }



    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
