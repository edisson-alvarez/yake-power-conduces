# Sistema Web para la Gestión y Generación de Conduces

## Descripción

Proyecto académico de la asignatura Desarrollo de Aplicaciones Web (ISW-306), desarrollado para Yake Power Systems SRL.

El sistema permite presentar información de la empresa, preparar conduces, validar los datos introducidos y utilizar componentes dinámicos mediante JavaScript.

## Objetivo

Desarrollar un sitio web interactivo que facilite el registro, validación y preparación de la información necesaria para la gestión y generación de conduces.

## Páginas del sitio

- **Inicio (`index.html`):** presenta la información principal del sistema.
- **Proyecto (`proyecto.html`):** explica el propósito, la importancia y los beneficios del proyecto.
- **Conduce (`conduce.html`):** contiene el formulario para preparar los datos de un conduce.
- **Inicio de sesión (`login.html`):** permite realizar un acceso simulado al sistema.

## Funcionalidades de la Fase 2

- Inicio de sesión simulado con usuario o correo y contraseña.
- Mensajes visibles de error y acceso correcto.
- Validación de los campos obligatorios del formulario de conduce.
- Validación de RNC de 9 dígitos o cédula de 11 dígitos.
- Validación de teléfonos con un mínimo de 10 dígitos.
- Validación de la descripción y cantidad de los productos.
- Manipulación del DOM para mostrar mensajes sin recargar la página.
- Buscador dinámico de productos por código o descripción.
- Uso de un arreglo JavaScript con productos disponibles.
- Función para agregar nuevas filas de productos.
- Función para eliminar filas de productos.
- Cálculo automático de la cantidad total de productos.
- Función para limpiar completamente el formulario.
- Eliminación de filas adicionales al limpiar el formulario.
- Restablecimiento de mensajes y cantidad total al limpiar.
- Ejecución de las funcionalidades mediante JavaScript del lado cliente.

## Funciones JavaScript principales

El archivo `js/funciones.js` incluye funciones reutilizables con parámetros y valores de retorno:

- `validarRncCedula(valor)`: verifica que el RNC tenga 9 dígitos o la cédula 11 dígitos.
- `validarTelefono(telefono)`: valida que el teléfono contenga al menos 10 dígitos.
- `calcularCantidadTotal(productos)`: calcula la suma de las cantidades de los productos.
- `filtrarProductos(productos, termino)`: filtra un arreglo de productos por código o descripción.
- `limpiarFormulario()`: limpia los datos, mensajes y filas adicionales del formulario.

## Componente dinámico de productos

La sección de productos permite:

- Buscar productos mediante texto.
- Mostrar resultados dinámicamente.
- Agregar nuevas filas.
- Eliminar filas.
- Introducir cantidades.
- Calcular automáticamente la cantidad total.

Entre los productos utilizados para las pruebas se encuentran:

- UPS-001 — UPS interactivo.
- BAT-002 — Banco de baterías.
- INV-003 — Inversor de energía.
- GEN-004 — Generador eléctrico.

## Tecnologías utilizadas

- HTML5
- CSS3
- JavaScript
- Git
- GitHub
- ClickUp

## Archivos JavaScript

- `js/login.js`: controla el inicio de sesión simulado.
- `js/validacion.js`: gestiona las validaciones, mensajes y comportamiento dinámico del formulario de conduce.
- `js/funciones.js`: contiene funciones reutilizables para validar datos, filtrar productos, calcular cantidades y limpiar el formulario.

## Pruebas funcionales

Las pruebas realizadas durante la Fase 2 se encuentran documentadas en:

`Pruebas-fase2.md`

Se verificaron:

- Login con campos vacíos.
- Credenciales incorrectas.
- Credenciales correctas.
- Validaciones del formulario.
- RNC y cédula.
- Teléfono.
- Buscador de productos.
- Agregar productos.
- Eliminar productos.
- Cálculo de cantidades.
- Limpieza completa del formulario.

## Fase actual

**Fase 2 — Interactividad del lado cliente con JavaScript.**

Durante esta fase se incorporaron validaciones, funciones reutilizables, manipulación del DOM, arreglos, componentes dinámicos y login simulado.

## Equipo

Grupo 12 — ISW-306
