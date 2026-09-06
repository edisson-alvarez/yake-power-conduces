\# Pruebas funcionales - Fase 2



\## Sistema Web para la Gestión y Generación de Conduces

\*\*Yake Power Systems SRL\*\*



\## 1. Pruebas del login



\### Prueba 1: Campos vacíos

\- Acción: Se intentó iniciar sesión sin completar los campos.

\- Resultado esperado: Mostrar mensajes de validación.

\- Resultado obtenido: Correcto.

\- Estado: Aprobado.



\### Prueba 2: Credenciales incorrectas

\- Acción: Se ingresaron credenciales no válidas.

\- Resultado esperado: Mostrar mensaje de error.

\- Resultado obtenido: Se muestra el mensaje indicando que el usuario/correo o la contraseña son incorrectos.

\- Estado: Aprobado.



\### Prueba 3: Credenciales correctas

\- Acción: Se ingresaron credenciales válidas.

\- Resultado esperado: Mostrar mensaje de acceso correcto y redirigir al sistema.

\- Resultado obtenido: Se muestra el mensaje "¡Acceso concedido! Redirigiendo..." y se realiza la redirección.

\- Estado: Aprobado.



\## 2. Pruebas del formulario de conduce



\### Prueba 4: Formulario vacío

\- Acción: Se presionó el botón "Guardar conduce" sin completar los campos.

\- Resultado esperado: Mostrar mensajes de validación.

\- Resultado obtenido: Se muestran los errores correspondientes.

\- Estado: Aprobado.



\### Prueba 5: Validación de RNC y cédula

\- Acción: Se probaron valores válidos e inválidos.

\- Resultado esperado: Aceptar RNC de 9 dígitos y cédula de 11 dígitos.

\- Resultado obtenido: La validación funciona correctamente.

\- Estado: Aprobado.



\### Prueba 6: Validación de teléfono

\- Acción: Se probaron números de teléfono válidos e inválidos.

\- Resultado esperado: Rechazar teléfonos con menos de 10 dígitos.

\- Resultado obtenido: La validación funciona correctamente.

\- Estado: Aprobado.



\## 3. Pruebas del componente dinámico de productos



\### Prueba 7: Buscador de productos

\- Acción: Se escribieron términos como "up", "b" y "xyz".

\- Resultado esperado: Filtrar los productos según código o descripción.

\- Resultado obtenido:

&#x20; - "up" muestra UPS-001 - UPS interactivo.

&#x20; - "b" muestra BAT-002 - Banco de baterías.

&#x20; - "xyz" muestra "No se encontraron productos."

\- Estado: Aprobado.



\### Prueba 8: Agregar producto

\- Acción: Se presionó el botón "Agregar producto".

\- Resultado esperado: Crear una nueva fila de producto.

\- Resultado obtenido: Se agrega correctamente una nueva fila vacía.

\- Estado: Aprobado.



\### Prueba 9: Eliminar producto

\- Acción: Se agregó una segunda fila y luego se presionó "Eliminar".

\- Resultado esperado: Eliminar la fila seleccionada.

\- Resultado obtenido: La fila se elimina correctamente.

\- Estado: Aprobado.



\### Prueba 10: Cálculo de cantidad total

\- Acción: Se colocaron cantidades 5 y 3 en dos productos.

\- Resultado esperado: Mostrar un total de 8.

\- Resultado obtenido: Se muestra "Cantidad total de productos: 8".

\- Estado: Aprobado.



\### Prueba 11: Limpiar formulario

\- Acción: Se completaron varios campos, se agregaron productos y luego se presionó "Limpiar formulario".

\- Resultado esperado: Vaciar todos los campos, eliminar filas adicionales, limpiar mensajes y restablecer el total a 0.

\- Resultado obtenido: El formulario se limpia correctamente.

\- Estado: Aprobado.



\## 4. Resultado general



Las pruebas realizadas confirman que las principales funcionalidades implementadas en la Fase 2 funcionan correctamente. Las validaciones, el login simulado, el buscador dinámico, la gestión de filas de productos, el cálculo de cantidades y la limpieza del formulario cumplen con los requisitos establecidos para la interactividad del lado cliente mediante JavaScript.

