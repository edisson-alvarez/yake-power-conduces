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