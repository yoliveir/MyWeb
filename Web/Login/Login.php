<?php
// LocalHost, Usuario, Contaseña y Nombre de la Base de Datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($error)) {
        echo $error;
        $usuario = $_POST['usuario'];
    } else {
        // LocalHost, Usuario, Contraseña y Nombre de la Base de Datos
        $mysqli = new mysqli("localhost", "adm", "123", "MyWeb");

        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $user = $_POST['usuario'];
        $clave = $_POST['clave'];

        $stmt = $mysqli->prepare("SELECT clave FROM users WHERE BINARY usuario = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($hash);
        $stmt->fetch();
		$stmt->close();

		$stmt = $mysqli->prepare("SELECT correo FROM users WHERE BINARY usuario = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($correo);
        $stmt->fetch();
		$stmt->close();
		echo $correo;

        // Verifica la contraseña utilizando password_verify
        if (password_verify($clave, $hash)) {
            session_start();
			$_SESSION["user"] = $user;
			$_SESSION["correo"] = $correo;
			header('Location: http://localhost/MyWeb/Web/Formulario.php');
        } else {
            $error = "Usuario o Contraseña incorrectos.";
			$i += 1;
        }
		$i = 0;

        $mysqli->close();
    }
}
?>

<html>
	<head>
		<title>Formulario de login</title>		
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="Styles\LoginStyles.css">
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
			<h1><b>Login</b></h1>
		<fieldset>
		<?php if (!empty(@$error)) : ?>
        	<div style="color: #8C1313;"><?php echo @$error; ?></div>
    	<?php endif; ?>
            <label for="usuario">Introduzca Su Usuario</label>		
			<input <?php echo (@$error) ? 'class="error"' : ''; ?> value = "<?php if(isset($_POST['usuario']))echo $_POST['usuario'];?>"
				id = "usuario" name = "usuario" type = "text" required>
            <br><br>
            <label for="clave">Introduzca Su Contraseña</label>			
			<input <?php echo (@$error) ? 'class="error"' : ''; ?> id = "clave" name = "clave" type = "password" required>
		</fieldset>						
			<input type = "submit">
			<p>No Tienes una Cuenta?            <a href="Registro.php">SignUp</a></p>
			<?php if($i = 4){echo "<p>Olvidaste Su Contraseña o Usuario?            <a href=\"recover.php\">Clica Aqui!</a></p>";}?>
		</form>
	</body> 
</html>