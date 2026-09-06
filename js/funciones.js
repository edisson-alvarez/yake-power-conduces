function validarRncCedula(valor) {
    const limpio = valor.replace(/\D/g, "");
    return limpio.length === 9 || limpio.length === 11;
}

function validarTelefono(telefono) {
    const limpio = telefono.replace(/\D/g, "");
    return limpio.length >= 10;
}

function calcularCantidadTotal(productos) {
    return productos.reduce((total, producto) => {
        return total + Number(producto.cantidad || 0);
    }, 0);
}

function filtrarProductos(productos, termino) {
    const texto = termino.trim().toLowerCase();

    return productos.filter((producto) => {
        return (
            producto.codigo.toLowerCase().includes(texto) ||
            producto.descripcion.toLowerCase().includes(texto)
        );
    });
}

function limpiarFormulario() {
    document.querySelectorAll(
        "#formConduce input, #seccionProductos input, #seccionObservaciones textarea"
    ).forEach((campo) => {
        campo.value = "";
    });

    document.querySelectorAll(".error-mensaje").forEach((mensaje) => {
        mensaje.textContent = "";
    });

    const mensajeGlobal = document.getElementById("mensajeGlobal");
    if (mensajeGlobal) {
        mensajeGlobal.textContent = "";
    }

    const cuerpoProductos = document.getElementById("cuerpoProductos");

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

    const buscador = document.getElementById("buscadorProductos");
    if (buscador) {
        buscador.value = "";
    }

    const resultado = document.getElementById("resultadoBusqueda");
    if (resultado) {
        resultado.textContent = "";
    }

    const total = document.getElementById("totalProductos");
    if (total) {
        total.textContent = "Cantidad total de productos: 0";
    }
}