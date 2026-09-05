document.addEventListener('DOMContentLoaded', () => {
    
    const btnGuardar = document.getElementById('btnGuardarConduce');
    const mensajeGlobal = document.getElementById('mensajeGlobal');

    btnGuardar.addEventListener('click', (e) => {
        e.preventDefault(); 
        
        let esValido = true;

        
        document.querySelectorAll('.error-mensaje').forEach(span => {
            span.textContent = '';
            span.style.color = '#d9534f'; 
        });
        mensajeGlobal.textContent = '';

        
        const numeroConduce = document.getElementById('numeroConduce').value.trim();
        if (numeroConduce === '') {
            mostrarError('error-NumeroConduce', 'El número de conduce es obligatorio.');
            esValido = false;
        }

        
        const fecha = document.getElementById('fecha').value;
        if (fecha === '') {
            mostrarError('error-Fecha', 'Debe seleccionar una fecha.');
            esValido = false;
        }

        
        const cliente = document.getElementById('cliente').value.trim();
        if (cliente === '') {
            mostrarError('error-Cliente', 'El nombre del cliente es obligatorio.');
            esValido = false;
        }

        
        const rnccedula = document.getElementById('rnccedula').value.trim();

if (rnccedula === '') {
    mostrarError('error-Rnccedula', 'El RNC o Cédula es obligatorio.');
    esValido = false;
} else if (!validarRncCedula(rnccedula)) {
    mostrarError('error-Rnccedula', 'El RNC debe tener 9 dígitos o la cédula 11 dígitos.');
    esValido = false;
        }

        
        const direccion = document.getElementById('direccion').value.trim();
        if (direccion === '') {
            mostrarError('error-Direccion', 'La dirección es obligatoria.');
            esValido = false;
        }

        
        const telefono = document.getElementById('telefono').value.trim();

if (telefono === '') {
    mostrarError('error-Telefono', 'El teléfono es obligatorio.');
    esValido = false;
} else if (!validarTelefono(telefono)) {
    mostrarError('error-Telefono', 'Ingrese un teléfono válido de al menos 10 dígitos.');
    esValido = false;
        }S

        
        const filasProductos = document.querySelectorAll('.filaProducto');
        let productosValidos = true;
        
        if (filasProductos.length === 0) {
            mostrarError('error-Productos', 'Debe agregar al menos un producto al conduce.');
            esValido = false;
        } else {
            filasProductos.forEach((fila) => {
                const descripcion = fila.querySelector('.input-descripcion').value.trim();
                const cantidad = parseFloat(fila.querySelector('.input-cantidad').value);

                if (descripcion === '' || isNaN(cantidad) || cantidad <= 0) {
                    productosValidos = false;
                }
            });
            
            if (!productosValidos) {
                mostrarError('error-Productos', 'Todos los productos deben tener una descripción y una cantidad numérica mayor a 0.');
                esValido = false;
            }
        }

        
        if (esValido) {
            mensajeGlobal.textContent = '¡Conduce preparado correctamente!';
            mensajeGlobal.style.color = '#3c763d'; 
            
        } else {
            mensajeGlobal.textContent = 'Por favor, corrija los errores marcados en el formulario.';
            mensajeGlobal.style.color = '#d9534f';
        }
    });

    
    function mostrarError(idElemento, mensaje) {
        const elemento = document.getElementById(idElemento);
        if (elemento) {
            elemento.textContent = mensaje;
        }
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
                .map(producto => `${producto.codigo} - ${producto.descripcion}`)
                .join(" | ");
        }
    });
}

});