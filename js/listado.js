document.addEventListener("DOMContentLoaded", () => {

    const cuerpoConduces = document.getElementById("cuerpoConduces");
    const mensajeListado = document.getElementById("mensajeListado");

    function formatearFecha(fechaISO) {
        if (!fechaISO) {
            return "";
        }

        const [anio, mes, dia] = fechaISO.split("-");
        return `${dia}/${mes}/${anio}`;
    }

    function mostrarMensaje(texto, esError) {
        if (!mensajeListado) {
            return;
        }

        mensajeListado.textContent = texto;
        mensajeListado.style.color = esError ? "#d9534f" : "#3c763d";
    }

    function renderizarFila(conduce) {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${conduce.numero_conduce}</td>
            <td>${formatearFecha(conduce.fecha)}</td>
            <td>${conduce.cliente}</td>
            <td>${conduce.rnc_cedula ?? ""}</td>
            <td>${conduce.telefono ?? ""}</td>
            <td>
                <a
                    href="conduce.html?id=${conduce.id_conduce}"
                    class="btn-editar-conduce">
                    Editar
                </a>
            </td>
        `;

        return fila;
    }

    function cargarConduces() {
        fetch("api/listar_conduces.php")
            .then((respuesta) => respuesta.json())
            .then((datos) => {
                if (!cuerpoConduces) {
                    return;
                }

                cuerpoConduces.innerHTML = "";

                if (!datos.exito) {
                    mostrarMensaje(
                        datos.mensaje || "No se pudo cargar el listado de conduces.",
                        true
                    );
                    return;
                }

                if (datos.conduces.length === 0) {
                    mostrarMensaje("Todavía no hay conduces registrados.", false);
                    return;
                }

                datos.conduces.forEach((conduce) => {
                    cuerpoConduces.appendChild(renderizarFila(conduce));
                });

                mostrarMensaje("", false);
            })
            .catch(() => {
                mostrarMensaje("Ocurrió un error al conectar con el servidor.", true);
            });
    }

    cargarConduces();
});
