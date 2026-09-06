document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const errorAlert = document.getElementById('error-alert');
    const successAlert = document.getElementById('success-alert');

    // Credenciales simuladas (Quemadas en código para esta fase)
    const VALID_USER = "admin";
    const VALID_EMAIL = "usuario@yakepower.com";
    const VALID_PASSWORD = "123456password";

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Evita que la página se recargue

        // limpiar alertas previas
        errorAlert.style.display = 'none';
        errorAlert.textContent = '';
        successAlert.style.display = 'none';
        successAlert.textContent = '';

        // Capturar los valores de los inputs
        const identifier = document.getElementById('identifier').value.trim();
        const password = document.getElementById('password').value;

        // Validación de campos vacíos 
        if (!identifier || !password) {
            showError('Por favor, complete todos los campos.');
            return;
        }

        // Validación de credenciales (Acepta tanto el usuario como el correo simulado)
        if ((identifier === VALID_USER || identifier === VALID_EMAIL) && password === VALID_PASSWORD) {
            
            // acceso exitoso
            successAlert.textContent = '¡Acceso concedido! Redirigiendo...';
            successAlert.style.display = 'block';
            
            // Simular retraso de red antes de enviar al index.html
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1500);

        } else {
            // Mensaje visible en caso de error
            showError('El usuario/correo o la contraseña son incorrectos.');
        }
    });

    // Función auxiliar para mostrar errores de forma visible
    function showError(message) {
        errorAlert.textContent = message;
        errorAlert.style.display = 'block';
    }
});
