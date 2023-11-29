<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {  	
	
        if($_POST['clave2'] != $_POST['clave1']){
			@$errorClave = "<br>-Las Contraseñas No Coinciden";
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
                @$errorUsu = "<br>-Nombre de Usuario ya Existe";
            }
            //Compruebo Correo
            $result = $mysqli->query("SELECT * FROM users WHERE BINARY correo = '$correo'");

            if($result->num_rows > 0) {
                @$errorEmail = "<br>-Ya Existe una Cuenta Asociada a este Correo";
            }else{
			//Encripto la Contraseña
			$clave_hash = password_hash($clave, PASSWORD_DEFAULT);
			if(!isset($error) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $stmt = $mysqli->prepare("INSERT INTO users (usuario, clave, correo) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $user, $clave_hash, $correo);
                $stmt->execute();
                $ok = "Cuenta Creado Con Exito!";
            }}
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
	<script src="../Scripts/dark_light.js"></script>
		<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
			<p><?php echo @$ok; ?></p>
			<h1><b>Register</b></h1>
			<fieldset>
			<?php if (!empty(@$errorUsu)) : ?>
        		<div style="color: #8C1313;"><?php echo @$errorUsu; ?></div>
    		<?php endif; ?>
            <label for="usuario">Usuario</label>		
			<input <?php echo (@$errorUsu) ? 'class="error"' : ''; ?> value = "<?php if(isset($_POST['usuario']))echo $_POST['usuario'];?>"
				id = "usuario" name = "usuario" type = "text" required>
            <br>
			<?php if (!empty(@$errorEmail)) : ?>
        		<div style="color: #8C1313;"><?php echo @$errorEmail; ?></div>
    		<?php endif; ?>
            <label for="email">Correo Electronico</label>			
			<input <?php echo (@$errorEmail) ? 'class="error"' : ''; ?> value = "<?php if(isset($_POST['email']))echo $_POST['email'];?>"
                id = "email" name = "email" type = "email" required>
            <br>
			<?php if (!empty(@$errorClave)) : ?>
        		<div style="color: #8C1313;"><?php echo @$errorClave; ?></div>
    		<?php endif; ?>
            <label for="clave1">Contraseña</label>			
			<input <?php echo (@$errorClave) ? 'class="error"' : ''; ?> id = "clave1" name = "clave1" type = "password" required>
            <br>
            <label for="clave2">Confirme Contraseña</label>			
			<input <?php echo (@$errorClave) ? 'class="error"' : ''; ?> id = "clave2" name = "clave2" type = "password" required>
			</fieldset>						
			<input type = "submit">
			<p>Ya Tienes una Cuenta?            <a href="Login.php">SignIn</a></p>
		</form>
	</body> 
</html>