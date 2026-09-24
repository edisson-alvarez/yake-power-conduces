document.addEventListener('DOMContentLoaded', () => {
    const cuerpoListado = document.getElementById('cuerpoListado');

    // Función para cargar los conduces al abrir la página
    async function cargarConduces() {
        try {
            const response = await fetch('backend/listar_conduces.php');
            const conduces = await response.json();

            cuerpoListado.innerHTML = '';

            if (conduces.length === 0) {
                cuerpoListado.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay conduces registrados.</td></tr>';
                return;
            }

            conduces.forEach(conduce => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${conduce.numero_conduce}</td>
                    <td>${conduce.fecha}</td>
                    <td>${conduce.cliente}</td>
                    <td>
                        <button type="button" class="btn-eliminar-conduce" data-id="${conduce.id_conduce}" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                            Eliminar
                        </button>
                    </td>
                `;
                cuerpoListado.appendChild(fila);
            });
        } catch (error) {
            console.error("Error al cargar listado:", error);
            cuerpoListado.innerHTML = '<tr><td colspan="4" style="text-align: center; color: red;">Error al cargar los datos.</td></tr>';
        }
    }

    // Delegación de eventos para el botón de eliminar
    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('btn-eliminar-conduce')) {
            const idConduce = e.target.getAttribute('data-id');
            const fila = e.target.closest('tr');

            const confirmacion = confirm("¿Está seguro de que desea eliminar este conduce? Esta acción también eliminará los productos asociados (ON DELETE CASCADE) y no se puede deshacer.");

            if (confirmacion) {
                try {
                    const response = await fetch('backend/eliminar_conduce.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_conduce: idConduce })
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        alert(data.message);
                        fila.remove(); // Actualiza el listado visualmente al instante
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    console.error("Error al eliminar:", error);
                    alert("Error de conexión al intentar eliminar el conduce.");
                }
            }
        }
    });

    // Iniciar carga
    cargarConduces();
});