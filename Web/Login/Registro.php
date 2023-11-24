<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {  	
	
		//Confirmo que el Usuario este Rellenado
		if($_POST['usuario'] == ""){
			@$error = $error . "<br>-Es Obligatorio Rellenar el Campo de usuario";
		}
        if($_POST['email'] == ""){
			@$error = $error . "<br>-Es Obligatorio Rellenar el Campo de Email";
		}
        if($_POST['clave1'] == ""){
			@$error = $error . "<br>-Es Obligatorio Rellenar el Campo de Contraseña";
		}
        if($_POST['clave2'] == ""){
			@$error = $error . "<br>-Las Contraseñas Tienen que Coincidir";
		}
        if($_POST['clave2'] != $_POST['clave1']){
			@$error = $error . "<br>-Las Contraseñas No Coinciden";
		}
	}
		if(isset($error)){
			echo $error;
			$usuario = $_POST['usuario'];
            $email = $_POST['email'];
		} else{
            @$user = $_POST['usuario'];
            @$correo = $_POST['email'];
            @$clave = $_POST['clave1'];

			// LocalHost, Usuario, Contaseña y Nombre de la Base de Datos
			$mysqli = new mysqli("localhost", "adm", "123", "MyWeb");

			if($mysqli->connect_errno) {
    			echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;}

            $result = $mysqli->query("SELECT * FROM users WHERE BINARY usuario = '$user'");
            //Compruebo Usuario
            if ($result->num_rows > 0) {
                echo "<br>-Nombre de Usuario ya Existe";
                @$error = $error . "<br>-Nombre de Usuario ya Existe";
            }
            //Compruebo Correo
            $result = $mysqli->query("SELECT * FROM users WHERE BINARY correo = '$correo'");

            if($result->num_rows > 0) {
                echo "<br>-Ya Existe una Cuenta Asociada a este Correo";
                $error = $error . "<br>-Ya Existe una Cuenta Asociada a este Correo";
            }
			//Encripto la Contraseña
			$clave_hash = password_hash($clave, PASSWORD_DEFAULT);
			if(!isset($error) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $stmt = $mysqli->prepare("INSERT INTO users (usuario, clave, correo) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $user, $clave_hash, $correo);
                $stmt->execute();
                echo "Cuenta Creado Con Exito!";
            }
        }

?>
<html>
	<head>
		<title>Formulario de Registro</title>	
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="Styles\RegStyles.css">
	</head>
	<body>
	<div class="toggle-switch">
  		<label class="switch-label">
    	<input type="checkbox" class="checkbox" id="themeToggle">
		<span class="slider"></span>
  		</label>
	</div>
	<script src="script.js"></script>
		<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
			<h1><b>Register</b></h1>
			<fieldset>
            <label for="usuario">Usuario</label>		
			<input value = "<?php if(isset($_POST['usuario']))echo $_POST['usuario'];?>"
				id = "usuario" name = "usuario" type = "text">
            <br>
            <label for="email">Correo Electronico</label>			
			<input value = "<?php if(isset($_POST['email']))echo $_POST['email'];?>"
                id = "email" name = "email" type = "email">
            <br>
            <label for="clave1">Contraseña</label>			
			<input id = "clave1" name = "clave1" type = "password">
            <br>
            <label for="clave2">Confirme Contraseña</label>			
			<input id = "clave2" name = "clave2" type = "password">
			</fieldset>						
			<input type = "submit">
			<p>Ya Tienes una Cuenta?            <a href="Login.php">SignIn</a></p>
		</form>
	</body> 
</html>