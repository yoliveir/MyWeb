<h1>Detalhes del Producto</h1>
    <div class="registro">

        <p class="campo">Título:</p>
        <p><?php echo $titulo; ?></p>

        <p class="campo">Correo:</p>
        <p><?php echo $correo; ?></p>

        <p class="campo">Mensaje:</p>
        <p><?php echo $mensaje; ?></p>

        <p class="campo">Preferencia de Contacto:</p>
        <p><?php echo $preferencia; ?></p>

        <p class="campo">Año que compré el Producto:</p>
        <p><?php echo $anyocompra; ?></p>

        <p class="campo">Comunidad:</p>
        <p><?php echo $comunidad; ?></p>

        <p class="campo">Fecha y Hora Disponible para Entrega o Recogida del Producto:</p>
        <p><?php echo $fechaHora; ?></p>

		<h1>Imagens del Producto</h1>

	<div class="imagens-container">
    	<?php foreach ($imagens as $imagem) : ?>
        	<img src="<?php echo $imagem; ?>" alt="Imagem" class="imagem">
    	<?php endforeach; ?>
    </div>
</div>