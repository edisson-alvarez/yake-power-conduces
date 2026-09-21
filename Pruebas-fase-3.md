# Pruebas funcionales - Fase 3

# Sistema Web para la Gestión y Generación de Conduce

# Yake Power Systems SRL

 # 1. Pruebas del login

 # Prueba 1: Campos vacíos

- Acción: Se intentó iniciar sesión sin completar los campos.

- Resultado esperado: Mostrar mensajes de validación.

- Resultado obtenido: Correcto.

- Estado: Aprobado.

# Prueba 2: Credenciales incorrectas

- Acción: Se ingresaron credenciales no válidas.

- Resultado esperado: Mostrar mensaje de error.

- Resultado obtenido: Se muestra el mensaje indicando que el usuario/correo o la contraseña son incorrectos.

- Estado: Aprobado.

# Prueba 3: Credenciales correctas

- Acción: Se ingresaron credenciales válidas.

- Resultado esperado: Mostrar mensaje de acceso correcto y redirigir al sistema.

- Resultado obtenido: Se muestra el mensaje "¡Acceso concedido! Redirigiendo..." y se realiza la redirección.

- Estado: Aprobado.

# 2. Pruebas del formulario de conducción

# Prueba 4: Formulario vacío

- Acción: Se presionó el botón "Guardar conducir" sin completar los campos.

- Resultado esperado: Mostrar mensajes de validación.

- Resultado obtenido: Se muestran los errores correspondientes.

- Estado: Aprobado.

# Prueba 5: Validación de RNC y cédula

- Acción: Se probaron valores válidos e inválidos.

- Resultado esperado: Aceptar RNC de 9 dígitos y cédula de 11 dígitos.

- Resultado obtenido: La validación funciona correctamente.

- Estado: Aprobado.

# Prueba 6: Validación de teléfono

- Acción: Se probaron números de teléfonos válidos e inválidos.

- Resultado esperado: Rechazar teléfonos con menos de 10 dígitos.

- Resultado obtenido: La validación funciona correctamente.

- Estado: Aprobado.

# 3. Pruebas del componente dinámico de productos

# Prueba 7: Buscador de productos

- Acción: Se escribieron términos como "up", "b" y "xyz".

- Resultado esperado: Filtrar los productos según código o descripción.

- Resultado obtenido:

- "g" muestra INV-003 - Inversor de energía | GEN-004 - Generador eléctrico.

- "l" muestra GEN-004 - Generador eléctrico.

- "s" muestra UPS-001 - UPS interactivo | BAT-002 - Banco de baterías | INV-003 - Inversor de energía.

-  "bb"  muestra mensaje de error  "No se encontraron productos."

- Estado: Aprobado.

# Prueba 8: Agregar producto

- Acción: Se presionó el botón "Agregar producto".

- Resultado esperado: Crear una nueva fila de producto.

- Resultado obtenido: Se agrega correctamente una nueva fila vacía.

- Estado: Aprobado.

# Prueba 9: Eliminar producto

- Acción: Se agregó una segunda fila y luego se presionó "Eliminar".

- Resultado esperado: Eliminar la fila seleccionada.

- Resultado obtenido: La fila se elimina correctamente.

- Estado: Aprobado.

# Prueba 10: Cálculo de cantidad total

- Acción: Se colocaron cantidades 1 y 3 en dos productos.

- Resultado esperado: Mostrar un total de 4.

- Resultado obtenido: Se muestra "Cantidad total de productos: 4".

- Estado: Aprobado.

# Prueba 11: Limpiar formulario

- Acción: Se completaron varios campos, se agregaron productos y luego se presionó "Limpiar formulario".

- Resultado esperado: Vaciar todos los campos, eliminar filas adicionales, limpiar mensajes y restablecer el total a 0.

- Resultado obtenido: El formulario se limpia correctamente.

- # Evidencias

<img width="1366" height="768" alt="Captura de pantalla (23)" src="https://github.com/user-attachments/assets/ada98317-0201-4df1-b1ae-efcfd2bff3e5" />

<img width="1366" height="728" alt="Iniciar Sesión _ Yake Power Systems - Google Chrome 01_09_2026 15_07_11" src="https://github.com/user-attachments/assets/19bbd4dd-bc1e-4335-be03-e0642778d314" />

<img width="1366" height="728" alt="Iniciar Sesión _ Yake Power Systems - Google Chrome 01_09_2026 15_36_35" src="https://github.com/user-attachments/assets/bfec3eb1-2431-454a-a34f-9f37516beb14" />

<img width="1366" height="728" alt="Iniciar Sesión _ Yake Power Systems - Google Chrome 01_09_2026 15_44_06" src="https://github.com/user-attachments/assets/283b7862-e41e-480a-aa6d-17c7181ffff2" />

# Resultado general

El sistema web de **Yake Power Systems SRL** es funcional en todos sus campos seleccionados.

