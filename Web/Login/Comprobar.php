<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$objetivo = $_POST["recupera"];
	$correo = $_POST["email"];
	$token = gerarNomeAleatorio();
$para = $correo;
$asunto = "Token Para La Recuperacion de $objetivo";
$mensaje = "Este Es Tu TOKEN Para la Recuperacion de tu $objetivo, no lo compartas con nadie.<br>$token";

// Cabeceras
$cabeceras = "MIME-Version: 1.0" . "\r\n";
$cabeceras .= "Content-type: text/html; charset=utf-8" . "\r\n";
$cabeceras .= "From: yuriomacedo10@gmail.com" . "\r\n";

// Enviar el correo
mail($para, $asunto, $mensaje, $cabeceras);

echo "Correo enviado correctamente";

if ($token == $_POST['token']){
	echo "Todo Perfecto";
} else{
	echo "Esta Todo Mal";
}
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
<div><?php echo @$ok; ?></div>
<br><br>
	<?php if (!empty(@$errorToken)) : ?>
        <div style="color: #8C1313;"><?php echo @$errorToken; ?></div>
    <?php endif; ?>
	<br>	
	<label for="token">Introduzca el Token Enviado Por Tu Correo</label>	
	<input <?php echo (@$errorToken) ? 'class="error"' : ''; ?> value = "<?php if(isset($_POST['token']))echo $_POST['token'];?>"
    id = "token" name = "token" type = "text" required>
</fieldset>
	<input type = "submit">
	<p>Equivocaste el Correo?            <a href="recover.php">Clica Aqui</a></p>
</form>
</body>
</html>