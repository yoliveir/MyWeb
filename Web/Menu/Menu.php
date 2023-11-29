<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            transition: background-color 0.3s ease; /* Agregamos una transición suave */
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 1em;
            margin: 0 1em;
        }

        .login-button {
            background-color: #28a745;
            color: #fff;
            padding: 0.5em 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        section {
            padding: 2em;
            margin-top: 80px; /* Ajusta el margen superior para evitar que el contenido se solape con la barra de navegación */
        }
    </style>
</head>
<body>
    <header>
        <h1>Mi Página Principal</h1>
    </header>
    
    <nav id="navbar">
        <div>
            <a href="#">Inicio</a>
            <a href="#">Sobre Nosotros</a>
            <a href="#">Servicios</a>
            <a href="#">Contacto</a>
        </div>
        <button class="login-button">Iniciar sesión</button>
    </nav>

    <section>
        <h2>Bienvenido a nuestra página principal</h2>
        <p>Este es el contenido principal de la página.</p>

    </section>

    <script>
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            var navbar = document.getElementById("navbar");
            if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
                navbar.style.position = "fixed";
                navbar.style.top = "0";
                navbar.style.width = "100%";
                navbar.style.backgroundColor = "#333"; // Puedes cambiar el color de fondo cuando la barra se vuelve fija
            } else {
                navbar.style.position = "relative";
                navbar.style.backgroundColor = "#444"; // Restaura el color de fondo original
            }
        }
    </script>
</body>
</html>
