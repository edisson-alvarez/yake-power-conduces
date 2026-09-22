document.addEventListener("DOMContentLoaded", () => {

    const params = new URLSearchParams(window.location.search);
    const idConduce = params.get("id");

    // Si no viene ?id= en la URL, el formulario sigue funcionando
    // exactamente igual que en modo "Crear conduce". No se toca nada más.
    if (!idConduce) {
        return;
    }

    window.modoEdicion = true;

    const tituloFormulario = document.getElementById("tituloFormulario");
    const btnGuardar = document.getElementById("btnGuardarConduce");
    const mensajeGlobal = document.getElementById("mensajeGlobal");
    const cuerpoProductos = document.getElementById("cuerpoProductos");

    if (tituloFormulario) {
        tituloFormulario.textContent = "Editar conduce";
    }

    if (btnGuardar) {
        btnGuardar.textContent = "Actualizar conduce";
    }

    // ---------- Tarea: cargar en el formulario los datos existentes ----------

    function cargarConduce() {
        fetch(`api/obtener_conduce.php?id=${idConduce}`)
            .then((respuesta) => respuesta.json())
            .then((datos) => {
                if (!datos.exito) {
                    mostrarMensajeGlobal(
                        datos.mensaje || "No se pudo cargar el conduce.",
                        true
                    );
                    return;
                }

                const conduce = datos.conduce;

                document.getElementById("idConduce").value = conduce.id_conduce;
                document.getElementById("idCliente").value = conduce.id_cliente;
                document.getElementById("numeroConduce").value = conduce.numero_conduce;
                document.getElementById("fecha").value = conduce.fecha;
                document.getElementById("cliente").value = conduce.cliente;
                document.getElementById("rnccedula").value = conduce.rnc_cedula;
                document.getElementById("direccion").value = conduce.direccion || "";
                document.getElementById("atencion").value = conduce.atencion || "";
                document.getElementById("telefono").value = conduce.telefono || "";
                document.getElementById("observaciones").value = conduce.observaciones || "";

                cargarProductos(conduce.productos || []);
            })
            .catch(() => {
                mostrarMensajeGlobal("Ocurrió un error al conectar con el servidor.", true);
            });
    }

    function cargarProductos(productos) {
        if (!cuerpoProductos) {
            return;
        }

        const filaModelo = cuerpoProductos.querySelector(".filaProducto");

        cuerpoProductos.querySelectorAll(".filaProducto").forEach((fila) => fila.remove());

        if (productos.length === 0) {
            cuerpoProductos.appendChild(filaModelo);
            return;
        }

        productos.forEach((producto) => {
            const fila = filaModelo.cloneNode(true);

            fila.querySelector(".input-codigo").value = producto.codigo || "";
            fila.querySelector(".input-serial").value = producto.serial || "";
            fila.querySelector(".input-descripcion").value = producto.descripcion || "";
            fila.querySelector(".input-cantidad").value = producto.cantidad || "";

            cuerpoProductos.appendChild(fila);
        });

        // Reutiliza la lógica de funciones.js para recalcular el total
        document.dispatchEvent(new Event("input"));
    }

    // ---------- Tarea: permitir modificar los datos + validar ----------

    function recolectarProductos() {
        const filas = document.querySelectorAll(".filaProducto");

        return Array.from(filas).map((fila) => ({
            codigo: fila.querySelector(".input-codigo").value.trim(),
            serial: fila.querySelector(".input-serial").value.trim(),
            descripcion: fila.querySelector(".input-descripcion").value.trim(),
            cantidad: fila.querySelector(".input-cantidad").value
        }));
    }

    function limpiarErrores() {
        document.querySelectorAll(".error-mensaje").forEach((span) => {
            span.textContent = "";
        });
    }

    function validarAntesDeActualizar() {
        let esValido = true;
        limpiarErrores();

        const numeroConduce = document.getElementById("numeroConduce").value.trim();
        if (numeroConduce === "") {
            document.getElementById("error-NumeroConduce").textContent =
                "El número de conduce es obligatorio.";
            esValido = false;
        }

        const fecha = document.getElementById("fecha").value;
        if (fecha === "") {
            document.getElementById("error-Fecha").textContent = "Debe seleccionar una fecha.";
            esValido = false;
        }

        const cliente = document.getElementById("cliente").value.trim();
        if (cliente === "") {
            document.getElementById("error-Cliente").textContent =
                "El nombre del cliente es obligatorio.";
            esValido = false;
        }

        const rnccedula = document.getElementById("rnccedula").value.trim();
        if (rnccedula === "" || !validarRncCedula(rnccedula)) {
            document.getElementById("error-Rnccedula").textContent =
                "Ingrese un RNC (9 dígitos) o cédula (11 dígitos) válidos.";
            esValido = false;
        }

        const direccion = document.getElementById("direccion").value.trim();
        if (direccion === "") {
            document.getElementById("error-Direccion").textContent =
                "La dirección es obligatoria.";
            esValido = false;
        }

        const telefono = document.getElementById("telefono").value.trim();
        if (telefono === "" || !validarTelefono(telefono)) {
            document.getElementById("error-Telefono").textContent =
                "Ingrese un teléfono válido de al menos 10 dígitos.";
            esValido = false;
        }

        const productos = recolectarProductos();
        const productosValidos =
            productos.length > 0 &&
            productos.every((p) => p.descripcion !== "" && Number(p.cantidad) > 0);

        if (!productosValidos) {
            document.getElementById("error-Productos").textContent =
                "Todos los productos deben tener descripción y cantidad mayor a 0.";
            esValido = false;
        }

        return esValido;
    }

    function mostrarMensajeGlobal(texto, esError) {
        if (!mensajeGlobal) {
            return;
        }

        mensajeGlobal.textContent = texto;
        mensajeGlobal.style.color = esError ? "#d9534f" : "#3c763d";
    }

    // ---------- Tareas: actualizar en BD + mensaje de confirmación ----------

    function actualizarConduce() {
        if (!validarAntesDeActualizar()) {
            mostrarMensajeGlobal("Por favor, corrija los errores marcados en el formulario.", true);
            return;
        }

        const cuerpo = {
            idConduce: document.getElementById("idConduce").value,
            idCliente: document.getElementById("idCliente").value,
            numeroConduce: document.getElementById("numeroConduce").value.trim(),
            fecha: document.getElementById("fecha").value,
            observaciones: document.getElementById("observaciones").value.trim(),
            cliente: document.getElementById("cliente").value.trim(),
            rnccedula: document.getElementById("rnccedula").value.trim(),
            direccion: document.getElementById("direccion").value.trim(),
            atencion: document.getElementById("atencion").value.trim(),
            telefono: document.getElementById("telefono").value.trim(),
            productos: recolectarProductos()
        };

        fetch("api/actualizar_conduce.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(cuerpo)
        })
            .then((respuesta) => respuesta.json())
            .then((datos) => {
                mostrarMensajeGlobal(
                    datos.mensaje ||
                        (datos.exito
                            ? "El conduce se actualizó correctamente."
                            : "No se pudo actualizar el conduce."),
                    !datos.exito
                );
            })
            .catch(() => {
                mostrarMensajeGlobal("Ocurrió un error al conectar con el servidor.", true);
            });
    }

    if (btnGuardar) {
        btnGuardar.addEventListener("click", (e) => {
            e.preventDefault();
            actualizarConduce();
        });
    }

    cargarConduce();
});
