<?php
	include("D:\Code\MyWeb\Web\Validaciones.php");
	if(!ValidarEmail($_POST['email'])){
		$errorEmail = "El Email No es Valido";
	} else{
		header('Location: Comprobar.php');
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="Styles\RecoverStyles.css">
	</head>
<body>
<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
	<h1><b>Recuperar</b></h1>
<fieldset>

	<?php if (!empty(@$errorEmail)) : ?>
        <div style="color: #8C1313;"><?php echo @$errorEmail; ?></div>
    <?php endif; ?>
	<br>	
	<label for="email">Correo De Recuperacion</label>	
	<input <?php echo (@$errorEmail) ? 'class="error"' : ''; ?> value = "<?php if(isset($_POST['email']))echo $_POST['email'];?>"
    id = "email" name = "email" type = "email" required>
	<br><br>
	<label>Cual de Los Dos Quieres Recuperar?:</label>
	<br>
	<input type="radio" id="recupera" name="recupera" value="user" required>Usuario
	<input type="radio" id="recupera" name="recupera" value="clave" required>Contraseña
</fieldset>
	<input type = "submit">
</form>
</body>
</html>