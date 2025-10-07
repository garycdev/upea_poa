<script>
    $(document).on('click', '.btn-validar-fut', function() {
        let id = $(this).data('id');
        let url = "{{ route('fut.modal', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(html) {
                $('#modalValidar').remove();

                $('body').append(html);

                let modal = new bootstrap.Modal(document.getElementById(
                    'modalValidar'));
                modal.show();
            },
            error: function(xhr) {
                alert('Error al cargar el modal');
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.btn-modal-submit-fut', function(e) {
            e.preventDefault()
            let estado = $(this).data('estado')

            $('#estado').val(estado)

            if (validarErroresModal()) {
                Swal.fire({
                    title: "¿Esta seguro de validar el formulario?",
                    text: "Esta accion no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, validar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formValidar').submit()
                    }
                });
            }
        })
        $(document).on('click', '.btn-modal-ejecutar-fut', function(e) {
            e.preventDefault()

            const id = $(this).data('id')
            console.log(id);

            Swal.fire({
                title: "¿Esta seguro de ejecutar la compra?",
                text: "Una vez ejecutado el monto previsto es irrecuperable",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, validar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('fut.ejecutar') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_fut: id
                        },
                        success: function(response) {
                            location.reload()
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            });
        })
    })

    function validarErroresModal() {
        resetErroresModal()

        let respaldo_tramite = $('#respaldo_tramite').val()
        let fecha_actual = $('#fecha_actual').val()
        let hora_actual = $('#hora_actual').val()

        if (respaldo_tramite != '' && fecha_actual != '' && hora_actual != '') {
            return true
        } else {
            if (respaldo_tramite == '') {
                $('#_respaldo_tramite').html('El respaldo del tramite es requerido')
            }
            if (fecha_actual == '') {
                $('#_fecha_actual').html('La fecha del tramite es requerido')
            }
            if (hora_actual == '') {
                $('#_hora_actual').html('La hora del tramite es requerido')
            }

            return false
        }
    }

    function resetErroresModal() {
        $('#_respaldo_tramite').html('')
        $('#_fecha_actual').html('')
        $('#_hora_actual').html('')
    }
    $(document).on('click', '.btn-validar', function() {
        let id = $(this).data('id');
        let url = "{{ route('fut.modal', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(html) {
                $('#modalValidar').remove();

                $('body').append(html);

                let modal = new bootstrap.Modal(document.getElementById(
                    'modalValidar'));
                modal.show();
            },
            error: function(xhr) {
                alert('Error al cargar el modal');
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.btn-modal-submit', function(e) {
            e.preventDefault()
            let estado = $(this).data('estado')

            $('#estado').val(estado)

            if (validarErroresModal()) {
                Swal.fire({
                    title: "¿Esta seguro de validar el formulario?",
                    text: "Esta accion no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, validar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formValidar').submit()

                        $('body').removeClass('loaded')
                    }
                });
            }
        })
        $(document).on('click', '.btn-modal-ejecutar', function(e) {
            e.preventDefault()

            const id = $(this).data('id')
            console.log(id);

            Swal.fire({
                title: "¿Esta seguro de ejecutar la compra?",
                text: "Una vez ejecutado el monto previsto es irrecuperable",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, validar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('fut.ejecutar') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_fut: id
                        },
                        success: function(response) {
                            location.reload()
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            });
        })
    })

    function validarErroresModal() {
        resetErroresModal()

        let respaldo_tramite = $('#respaldo_tramite').val()
        let fecha_actual = $('#fecha_actual').val()
        let hora_actual = $('#hora_actual').val()

        if (respaldo_tramite != '' && fecha_actual != '' && hora_actual != '') {
            return true
        } else {
            if (respaldo_tramite == '') {
                $('#_respaldo_tramite').html('El respaldo del tramite es requerido')
            }
            if (fecha_actual == '') {
                $('#_fecha_actual').html('La fecha del tramite es requerido')
            }
            if (hora_actual == '') {
                $('#_hora_actual').html('La hora del tramite es requerido')
            }

            return false
        }
    }

    function resetErroresModal() {
        $('#_respaldo_tramite').html('')
        $('#_fecha_actual').html('')
        $('#_hora_actual').html('')
    }


    $(document).on('click', '.btn-validar-mot', function() {
        let id = $(this).data('id');
        let url = "{{ route('mot.modal', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(html) {
                $('#modalValidarMot').remove();

                $('body').append(html);

                let modal = new bootstrap.Modal(document.getElementById(
                    'modalValidarMot'));
                modal.show();
            },
            error: function(xhr) {
                alert('Error al cargar el modal');
            }
        });
    });




    // Modal MOT
    $(document).ready(function() {
        $(document).on('click', '.btn-modal-submit-mot', function(e) {
            e.preventDefault()
            let estado = $(this).data('estado')

            $('#estado').val(estado)

            if (validarErroresModalMot()) {
                Swal.fire({
                    title: "¿Esta seguro de validar el formulario?",
                    text: "Se enviara el formulario a la unidad de presupuestos",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, validar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formValidarMot').submit()

                        $('body').removeClass('loaded')
                    }
                });
            }
        })
        $(document).on('click', '.btn-modal-ejecutar-mot', function(e) {
            e.preventDefault()

            const id = $(this).data('id')
            console.log(id);

            Swal.fire({
                title: "¿Esta seguro de ejecutar la modificación?",
                text: "Una vez ejecutado el monto previsto es irrecuperable",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, validar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('mot.ejecutar') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_mot: id
                        },
                        success: function(response) {
                            location.reload()
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            });
        })
    })

    function validarErroresModalMot() {
        resetErroresModalMot()

        let respaldo_tramite = $('#respaldo_tramite').val()
        let fecha_actual = $('#fecha_actual').val()
        let hora_actual = $('#hora_actual').val()

        if (respaldo_tramite != '' && fecha_actual != '' && hora_actual != '') {
            return true
        } else {
            if (respaldo_tramite == '') {
                $('#_respaldo_tramite').html('El respaldo del tramite es requerido')
            }
            if (fecha_actual == '') {
                $('#_fecha_actual').html('La fecha del tramite es requerido')
            }
            if (hora_actual == '') {
                $('#_hora_actual').html('La hora del tramite es requerido')
            }

            return false
        }
    }

    function resetErroresModalMot() {
        $('#_respaldo_tramite').html('')
        $('#_fecha_actual').html('')
        $('#_hora_actual').html('')
    }
</script>
