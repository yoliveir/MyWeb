document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    // Verifica el tema almacenado en localStorage al cargar la página
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        body.classList.toggle('light-mode', currentTheme === 'light-mode');
        themeToggle.checked = currentTheme === 'light-mode';
    }

    // Agrega un listener al interruptor para cambiar el tema
    themeToggle.addEventListener('change', function () {
        const isLightMode = themeToggle.checked;
        body.classList.toggle('light-mode', isLightMode);

        // Guarda el tema en localStorage
        const theme = isLightMode ? 'light-mode' : '';
        localStorage.setItem('theme', theme);
    });
});