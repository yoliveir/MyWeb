<?php
include("Validaciones.php");
// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $titulo = $_POST["titulo"];
    $mensaje = $_POST["mensaje"];
    $year = $_POST["year"];
    $contact = $_POST["contact"];
    @$publi = $_POST['publi'];
    $ciudades = $_POST["ciudades"];
    $fecha = $_POST["fecha"];

    //Comprobaciones
    //Valido el Titulo
    if(ValidarTitulo($titulo) == false){
        @$errorTitulo = "<br>-Titulo mal Formatado, hay que tener: 5 Caracteres MIN; Primera Letras Mayusculas";
    }
    //Compruebo que Mensaje tiene al menos 50 Caracteres
    if(strlen($mensaje) < 50){
        @$errorMensaje = "<br>-El mensaje tiene menos de 50 Caracteres";
    }
	$nombre = $_SESSION['user'];
	$correo = $_SESSION['correo'];
	$id = session_id();
    // Manejar los archivos subidos
    $archivos = $_FILES["archivos"];
    $numArchivos = count($archivos["name"]);

    for ($i = 0; $i < $numArchivos; $i++) {
        $nombreArchivo = $archivos["name"][$i];
        $tipoArchivo = $archivos["type"][$i];
        $nombreTemporal = $archivos["tmp_name"][$i];

        //Compruebo que el Archivo es un PNG
        if ($tipoArchivo === "image/png") {
			$nuevoNombreArchivo = gerarNomeAleatorio() . ".png";
            $rutasArchivos .= "uploads/" . $nuevoNombreArchivo . ",";
            move_uploaded_file($nombreTemporal, "uploads/" . $nuevoNombreArchivo);
        } else {
           @$errorImagen = "<br>-Se permite solo archivos .png";}
    }
    //Comprobacion de Errores
    if($errorImagen || $errorMensaje || $errorTitulo){
        
    } else {

        //Conecto con la Base de Datos
        // LocalHost, Usuario, Contaseña y Nombre de la Base de Datos
        if($_SERVER["REQUEST_METHOD"] == "POST" && !(isset($error)))
		$mysqli = new mysqli("localhost", "adm", "123", "MyWeb");

		if($mysqli->connect_errno) {
    		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {

            $stmt = $mysqli->prepare("INSERT INTO datos (titulo, correo, mensaje, preferencia, anyocompra, comunidad, fechaHora) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $titulo, $correo, $mensaje, $contact, $year, $ciudades, $fecha);
            $stmt->execute();

			$stmt = $mysqli->prepare("INSERT INTO imagens (imagen, correo) VALUES (?, ?)");
            $stmt->bind_param("ss", $rutasArchivos, $correo);
            $stmt->execute();

            echo "Datos Insertados con Exito!";
            header("Location: Publicaciones.php");
        }
        //termino de utilizar la Base de Datos
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario PHP</title>
	<link rel="stylesheet" href="Styles/FormStyles.css">
</head>
<body>
<header>
            <a class="logo" href="/"><img src="images/logo.svg" alt="logo"></a>
            <nav>
                <ul class="nav__links">
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </nav>
            <a class="cta" href="../Login/Login.php">Login</a>
        </header>
	<?php session_start();?>
	<div class="toggle-switch">
  		<label class="switch-label">
    	<input type="checkbox" class="checkbox" id="themeToggle">
		<span class="slider"></span>
  		</label>
	</div>

<h1>Formulario (Venda de Productos)</h1>

<br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<fieldset>
	<div id="datosUsuario">
	<p>User: <b><?php echo isset($_SESSION['user']) ? $_SESSION['user'] : ''; ?></b></p>
    <p>Email: <b><?php echo isset($_SESSION['correo']) ? $_SESSION['correo'] : ''; ?></b></p>
	</div>

</fieldset>
<h1>:Datos Producto:</h1>
<fieldset>
	<?php if (!empty(@$errorTitulo)) : ?>
        <div style="color: #8C1313;"><?php echo @$errorTitulo; ?></div>
    <?php endif; ?>
    <label for="titulo">Titulo:</label>
    <input <?php echo (@$errorTitulo) ? 'class="error"' : ''; ?> value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; ?>"
    id="titulo" name="titulo" type="text" required>

	<?php if (!empty(@$errorMensaje)) : ?>
        <div style="color: #8C1313;"><?php echo @$errorMensaje; ?></div>
    <?php endif; ?>
    <label for="mensaje">Mensaje:</label>
    <textarea <?php echo (@$errorMensaje) ? 'class="error"' : ''; ?> name="mensaje" rows="4" required><?php if(isset($mensaje)) echo $mensaje; ?></textarea>

    <br>

    <label for="year">Año de compra:</label>
    <select id="year" name="year">
        <option value="2023" <?php if(isset($year) && $year === "2023") echo "selected"; ?>>2023</option>
        <option value="2022" <?php if(isset($year) && $year === "2022") echo "selected"; ?>>2022</option>
        <option value="2021" <?php if(isset($year) && $year === "2021") echo "selected"; ?>>2021</option>
        <option value="2020" <?php if(isset($year) && $year === "2020") echo "selected"; ?>>2020</option>
        <option value="2019" <?php if(isset($year) && $year === "2019") echo "selected"; ?>>2019</option>
        <option value="2018" <?php if(isset($year) && $year === "2018") echo "selected"; ?>>2018</option>
        <option value="2017" <?php if(isset($year) && $year === "2017") echo "selected"; ?>>2017</option>
    </select>

    <br>

    <label>Preferencia de Contacto:</label>
        <input type="radio" id="contact" name="contact" value="correo" required <?php if(isset($contact) && $contact === "correo") echo "checked"; ?>>Correo
		<input type="radio" id="contact" name="contact" value="presencial" required <?php if(isset($contact) && $contact === "presencial") echo "checked"; ?>>Presencial

    <br>

    <label for="ciudades">Comunidad:</label>
        <select id="ciudades" name="ciudades" size="4" multiple required>
            <option value="Madrid" <?php if(isset($ciudades) && $ciudades == "Madrid") echo "selected"?>>Madrid</option>
            <option value="Castilla-La Mancha" <?php if(isset($ciudades) && $ciudades == "Castilla-La Mancha") echo "selected"?>>Castilla-La Mancha</option>
            <option value="Extremadura" <?php if(isset($ciudades) && $ciudades == "Extremadura") echo "selected"?>>Extremadura</option>
            <option value="Valencia" <?php if(isset($ciudades) && $ciudades == "Valencia") echo "selected"?>>Valencia</option>
            <option value="La Rioja" <?php if(isset($ciudades) && $ciudades == "La Rioja") echo "selected"?>>La Rioja</option>
            <option value="Pais Vasco" <?php if(isset($ciudades) && $ciudades == "Pais Vasco") echo "selected"?>>Pais Vasco</option>
            <option value="Castilla y Leon" <?php if(isset($ciudades) && $ciudades == "Castilla y Leon") echo "selected"?>>Castilla y Leon</option>
            <option value="Murcia" <?php if(isset($ciudades) && $ciudades == "Murcia") echo "selected"?>>Murcia</option>
            <option value="Andalucia" <?php if(isset($ciudades) && $ciudades == "Andalucia") echo "selected"?>>Andalucia</option>
            <option value="Cataluña" <?php if(isset($ciudades) && $ciudades == "Cataluña") echo "selected"?>>Cataluña</option>
            <option value="Aragon" <?php if(isset($ciudades) && $ciudades == "Aragon") echo "selected"?>>Aragon</option>
            <option value="Galicia" <?php if(isset($ciudades) && $ciudades == "Galicia") echo "selected"?>>Galicia</option>
            <option value="Asturias" <?php if(isset($ciudades) && $ciudades == "Asturias") echo "selected"?>>Asturias</option>
            <option value="Navarra" <?php if(isset($ciudades) && $ciudades == "Navarra") echo "selected"?>>Navarra</option>
            <option value="Islas Baleares" <?php if(isset($ciudades) && $ciudades == "Islas Baleares") echo "selected"?>>Islas Baleares</option>
        </select>
    
    <br>
    <label for="fecha">Fecha y Hora Disponible para Entrega de Producto:</label>
        <input type="datetime-local" id="fecha" name="fecha" min="<?= date('Y-m-d\TH:i'); ?>" value="<?php if(isset($fecha)) echo $fecha; ?>" required>

    <br>

	<?php if (!empty(@$errorImagen)) : ?>
        <div style="color: #8C1313;"><?php echo @$errorImagen; ?></div>
    <?php endif; ?>
    <label for="archivos">Cargar archivos (solo PNG):</label>
    <input <?php echo (@$errorImagen) ? 'class="error"' : ''; ?> type="file" name="archivos[]" accept=".png" multiple>

    <br>

    <label>Quiero Recibir Publicidad:</label>
        <input type="checkbox" id="publi" name="publi" value="si" <?php if(isset($publi) && $publi === "si") echo "checked"; ?>>

    <br>
</fieldset>
    <input type="submit" value="Enviar">
</form>

</body>
</html>