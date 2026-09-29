document.addEventListener("DOMContentLoaded", () => {

    const btnGuardar = document.getElementById("btnGuardarConduce");
    const mensajeGlobal = document.getElementById("mensajeGlobal");
    const btnAgregarProducto = document.getElementById("btnAgregarProducto");
    const cuerpoProductos = document.getElementById("cuerpoProductos");

    function mostrarError(idElemento, mensaje) {
        const elemento = document.getElementById(idElemento);
        if (elemento) {
            elemento.textContent = mensaje;
        }
    }

    function actualizarCantidadTotal() {
        const filas = document.querySelectorAll(".filaProducto");
        const productos = Array.from(filas).map((fila) => {
            const cantidad = fila.querySelector(".input-cantidad");
            return {
                cantidad: cantidad ? cantidad.value : 0
            };
        });

        const total = calcularCantidadTotal(productos);
        const elementoTotal = document.getElementById("totalProductos");

        if (elementoTotal) {
            elementoTotal.textContent = `Cantidad total de productos: ${total}`;
        }
    }

    if (btnGuardar) {
        btnGuardar.addEventListener("click", async (e) => {
            e.preventDefault();

            let esValido = true;

            document.querySelectorAll(".error-mensaje").forEach((span) => {
                span.textContent = "";
                span.style.color = "#d9534f";
            });

            if (mensajeGlobal) {
                mensajeGlobal.textContent = "";
            }

            const numeroConduce = document.getElementById("numeroConduce").value.trim();
            if (numeroConduce === "") {
                mostrarError("error-NumeroConduce", "El número de conduce es obligatorio.");
                esValido = false;
            }

            const fecha = document.getElementById("fecha").value;
            if (fecha === "") {
                mostrarError("error-Fecha", "Debe seleccionar una fecha.");
                esValido = false;
            }

            const cliente = document.getElementById("cliente").value.trim();
            if (cliente === "") {
                mostrarError("error-Cliente", "El nombre del cliente es obligatorio.");
                esValido = false;
            }

            const rnccedula = document.getElementById("rnccedula").value.trim();
            if (rnccedula === "") {
                mostrarError("error-Rnccedula", "El RNC o Cédula es obligatorio.");
                esValido = false;
            } else if (!validarRncCedula(rnccedula)) {
                mostrarError("error-Rnccedula", "El RNC debe tener 9 dígitos o la cédula 11 dígitos.");
                esValido = false;
            }

            const direccion = document.getElementById("direccion").value.trim();
            if (direccion === "") {
                mostrarError("error-Direccion", "La dirección es obligatoria.");
                esValido = false;
            }

            const telefono = document.getElementById("telefono").value.trim();
            if (telefono === "") {
                mostrarError("error-Telefono", "El teléfono es obligatorio.");
                esValido = false;
            } else if (!validarTelefono(telefono)) {
                mostrarError("error-Telefono", "Ingrese un teléfono válido de al menos 10 dígitos.");
                esValido = false;
            }

            const filasProductos = document.querySelectorAll(".filaProducto");
            let productosValidos = true;

            if (filasProductos.length === 0) {
                mostrarError("error-Productos", "Debe agregar al menos un producto al conduce.");
                esValido = false;
            } else {
                filasProductos.forEach((fila) => {
                    const descripcion = fila.querySelector(".input-descripcion").value.trim();
                    const cantidad = parseFloat(fila.querySelector(".input-cantidad").value);

                    if (descripcion === "" || isNaN(cantidad) || cantidad <= 0) {
                        productosValidos = false;
                    }
                });

                if (!productosValidos) {
                    mostrarError("error-Productos", "Todos los productos deben tener una descripción y una cantidad numérica mayor a 0.");
                    esValido = false;
                }
            }

            if (esValido) {
                
                if (mensajeGlobal) {
                    mensajeGlobal.textContent = "Procesando datos, por favor espere...";
                    mensajeGlobal.style.color = "#337ab7";
                }

                try {
                    // Preparar los datos para el envío
                    const formData = new FormData();
                    formData.append('numero_conduce', numeroConduce);
                    formData.append('fecha', fecha);
                    formData.append('cliente_nombre', cliente);
                    formData.append('rnc_cedula', rnccedula);
                    formData.append('direccion', direccion);
                    formData.append('atencion', document.getElementById("atencion").value.trim());
                    formData.append('telefono', telefono);
                    formData.append('observaciones', document.getElementById("observaciones").value.trim());

                    
                    filasProductos.forEach((fila) => {
                        const codigo = fila.querySelector(".input-codigo").value.trim();
                        const serial = fila.querySelector(".input-serial").value.trim();
                        const descripcion = fila.querySelector(".input-descripcion").value.trim();
                        const cantidad = fila.querySelector(".input-cantidad").value;

                        
                        if (descripcion !== "" && cantidad > 0) {
                            formData.append('codigo[]', codigo);
                            formData.append('serial[]', serial);
                            formData.append('descripcion[]', descripcion);
                            formData.append('cantidad[]', cantidad);
                        }
                    });

                    
                    const response = await fetch('backend/procesar_conduce.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        if (mensajeGlobal) {
                            mensajeGlobal.textContent = data.message;
                            mensajeGlobal.style.color = "#3c763d";
                        }
                        
                        
                        setTimeout(() => {
                           
                           const btnLimpiar = document.getElementById("btnLimpiar");
                           if (btnLimpiar) btnLimpiar.click();
                        }, 2000); 

                    } else {
                        
                        if (mensajeGlobal) {
                            mensajeGlobal.textContent = data.message;
                            mensajeGlobal.style.color = "#d9534f";
                        }
                    }

                } catch (error) {
                    console.error("Error al enviar el conduce al servidor:", error);
                    if (mensajeGlobal) {
                        mensajeGlobal.textContent = "Error de conexión con el servidor. Intente más tarde.";
                        mensajeGlobal.style.color = "#d9534f";
                    }
                }
                
            } else {
                if (mensajeGlobal) {
                    mensajeGlobal.textContent = "Por favor, corrija los errores marcados en el formulario.";
                    mensajeGlobal.style.color = "#d9534f";
                }
            }
        });
    }

    const productosDisponibles = [
        { codigo: "UPS-001", descripcion: "UPS interactivo" },
        { codigo: "BAT-002", descripcion: "Banco de baterías" },
        { codigo: "INV-003", descripcion: "Inversor de energía" },
        { codigo: "GEN-004", descripcion: "Generador eléctrico" }
    ];

    const buscadorProductos = document.getElementById("buscadorProductos");
    const resultadoBusqueda = document.getElementById("resultadoBusqueda");

    if (buscadorProductos && resultadoBusqueda) {
        buscadorProductos.addEventListener("input", () => {
            const termino = buscadorProductos.value;

            if (termino.trim() === "") {
                resultadoBusqueda.textContent = "";
                return;
            }

            const resultados = filtrarProductos(productosDisponibles, termino);

            if (resultados.length === 0) {
                resultadoBusqueda.textContent = "No se encontraron productos.";
            } else {
                resultadoBusqueda.textContent = resultados
                    .map((producto) => `${producto.codigo} - ${producto.descripcion}`)
                    .join(" | ");
            }
        });
    }

    document.addEventListener("input", (e) => {
        if (e.target.classList.contains("input-cantidad")) {
            actualizarCantidadTotal();
        }
    });

    if (btnAgregarProducto && cuerpoProductos) {
        btnAgregarProducto.addEventListener("click", () => {
            const primeraFila = cuerpoProductos.querySelector(".filaProducto");

            if (!primeraFila) {
                return;
            }

            const nuevaFila = primeraFila.cloneNode(true);

            nuevaFila.querySelectorAll("input").forEach((input) => {
                input.value = "";
            });

            cuerpoProductos.appendChild(nuevaFila);
            actualizarCantidadTotal();
        });

        cuerpoProductos.addEventListener("click", (e) => {
            if (e.target.classList.contains("btn-eliminar-fila")) {
                const filas = cuerpoProductos.querySelectorAll(".filaProducto");
                if (filas.length > 1) {
                    e.target.closest(".filaProducto").remove();
                    actualizarCantidadTotal();
                }
            }
        });
    }

    document.addEventListener("click", (e) => {
        if (e.target.id !== "btnLimpiar") {
            return;
        }

        document.querySelectorAll(
            "#formConduce input, #seccionProductos input, #seccionObservaciones textarea"
        ).forEach((campo) => {
            campo.value = "";
        });

        document.querySelectorAll(".error-mensaje").forEach((span) => {
            span.textContent = "";
        });

        if (mensajeGlobal) {
            mensajeGlobal.textContent = "";
        }

        if (cuerpoProductos) {
            const filas = cuerpoProductos.querySelectorAll(".filaProducto");
            filas.forEach((fila, index) => {
                if (index > 0) {
                    fila.remove();
                }
            });

            const primeraFila = cuerpoProductos.querySelector(".filaProducto");
            if (primeraFila) {
                primeraFila.querySelectorAll("input").forEach((input) => {
                    input.value = "";
                });
            }
        }

        if (buscadorProductos) {
            buscadorProductos.value = "";
        }

        if (resultadoBusqueda) {
            resultadoBusqueda.textContent = "";
        }

        actualizarCantidadTotal();
    });

    actualizarCantidadTotal();
});