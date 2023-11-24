<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicacion de Productos</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
		flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin: 20px;
    }

    .imagens-container {
        display: flex;
        flex-direction: row;
    }

    .imagem {
    max-width: 100%;
    margin-right: 10px;
	}

    .registro {
		width: 50%;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
		background-color: #7cd985;
		border: 2px solid #1a5420;
        border-radius: 3px;
		overflow: hidden;
		word-wrap: break-word;
    }

    .campo {
        font-weight: bold;
    }
</style>
</head>
<body>
<?php
// Inicia a sessão
session_start();

// Recupera dados da sessão
if(isset($_SESSION['usuario']) && isset($_SESSION['email'])){
	$usuario = $_SESSION['usuario'];
	$email = $_SESSION['email'];
}

//Conecto con la Base de Datos
// LocalHost, Usuario, Contaseña y Nombre de la Base de Datos
$mysqli = new mysqli("localhost", "adm", "123", "MyWeb");

if($mysqli->connect_errno) {
	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$query = "SELECT correo FROM users";
$result = $mysqli->query($query);

if ($result) {
	while ($row = $result->fetch_assoc()) {
		$correosUsuarios[] = $row['correo'];
	}
}

$cantidadCorreos = count($correosUsuarios);


for($i = 0; $i < $cantidadCorreos; $i++){
//Recupera las Imagenes
$stmt = $mysqli->prepare("SELECT imagen FROM imagens WHERE BINARY correo = ?");
	$stmt->bind_param("s", $correosUsuarios[$i]);
	$stmt->execute();
	$stmt->bind_result($stringima);
	$stmt->fetch();
$stmt->close();

$imagens = explode(",", $stringima);
array_pop($imagens);

//Recupero los datos
$selectStmt = $mysqli->prepare("SELECT titulo, correo, mensaje, preferencia, anyocompra, comunidad, fechaHora FROM datos WHERE BINARY correo = ?");
$selectStmt->bind_param("s", $correosUsuarios[$i]);
$selectStmt->execute();
$selectStmt->bind_result($titulo, $correo, $mensaje, $preferencia, $anyocompra, $comunidad, $fechaHora);
$selectStmt->fetch();
$selectStmt->close();

include('mostrar_info.php');
}
?>
</body>
</html>