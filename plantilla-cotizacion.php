<head>
	<title>Contrato Andart Music COT-<?= sprintf('%04d', $numero) ?></title>
</head>
<body>
	<main>
	<center><img src="https://andartmusic.com/intranet/img/cabecera_logo.png" alt="Mi Imagen" style="width: 100%; margin-bottom:0rem;"></center>
	
	<table class="mt-1">
		<tr>
				<td><strong>FECHA DE SOLICITUD</strong></td>
				<td class="sinLinea"></td>
				<td rowspan="2" class="centroTodo" id="divPlomo"><h3>COTIZACIÓN DE SHOW MUSICAL</h3></td>
				<td class="sinLinea"></td>
				<td><strong>CONSECUTIVO</strong></td>
				<td class="sinLinea"></td>
				<td><strong>FECHA DE CONTESTACIÓN</strong></td>
		</tr>
		<tr>
				<td class="text-capitalize"><?= $fechaSolicitud ?></td>
				<td class="sinLinea"></td>
				<td class="sinLinea"></td>
				<td><h2>COT-<?= sprintf('%04d', $numero) ?></h2></td>
				<td class="sinLinea"></td>
				<td><?= $fechaContestacion ?></td>
		</tr>
	</table>
	<br>
	<table>
		<tr id="trDetalle">
			<td class="ceroLinea">
				<p><strong>DNI: </strong> </p>
				<p><strong>NOMBRE DEL CLIENTE: </strong> </p>
				<p><strong>UBICACIÓN: </strong> </p>
				<p><strong>FECHA DEL EVENTO: </strong> </p>
				<p><strong>DURACIÓN DEL SHOW: </strong> </p>
				<p><strong>DIRECCIÓN / LUGAR DEL EVENTO: </strong> </p>
				<p class="centroVertical"><strong class="centroVertical">AGRUPACIÓN: </strong> </p>

			</td>
			<td class="ceroLinea">
				<p><?= $dniCliente ?></p>
				<p><?= $nombreCliente ?></p>
				<p><?= $ubigeo ?></p>
				<p><?= $fechaEvento ?></p>
				<p><?= $tiempoEvento ?></p>
				<p><?= $local ?></p>
				<p class="centroVertical"><span class="text-center" id="cuadrado"><strong>x</span> <?= $agrupacion ?></p>
			</td>
			<td class="ceroLinea">
				<p><strong>RUC: </strong> </p>
				<p><strong>RAZÓN SOCIAL: </strong> </p>
				<p><strong>CELULAR: </strong> </p>
				<p><strong>TIPO DE EVENTO: </strong> </p>
				<p><strong>HORA DE INICIO: </strong> </p>
			</td>
			<td class="ceroLinea">
				<p><?= $rucCliente ?></p>
				<p><?= $razonCliente ?></p>
				<p><?= $celularCliente ?></p>
				<p><?= $tipoEvento ?></p>
				<p><?= $horarioInicio ?></p>
			</td>

		</tr>
		<tr>
			<td class="text-left" colspan="4"><strong>OBSERVACIONES:</strong> <?= $observaciones; ?></td>
		</tr>
		
	</table>
	<table>
		<tr>
			<td class="ceroLinea">
				<p><strong>No incluye:</strong></p>
				<ol>
					<li>Escenario</li>
					<li>Equipo de Sonido</li>
				</ol>
			</td>
			<td class="ceroLinea">
				<p><strong>Requerimientos:</strong></p>
				<ol>
					<li>Permisos y protocolos requeridos</li>
					<li>Aforo permitido</li>
					<li>Hidratación <?= $personas ?> personas en escenario</li>
					<li>Alimentación <?= $personas ?> personas</li>
					<?php if($hospedaje): ?>
					<li>Hospedaje <?= $personas ?> personas</li>
					<?php endif; ?>
				</ol>
			</td>
			<td class="ceroLinea">
				<p><strong>Costo del Show:</strong></p><br>
				<p>Costo del show (Sin IGV): S/ <?= number_format($base,2) ?></p>
				<p>IGV: S/ <?= number_format($igv,2) ?></p>
				<p>Monto total: S/ <?= number_format($total,2) ?></p>
			</td>
		</tr>
	</table>

	<table>
		<tr>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<img src="https://andartmusic.com/intranet/img/firma.png" style="width:60px;">
				<p>_____________________________<br>FIRMA DEL VENDEDOR</p>
			</td>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<img src="https://andartmusic.com/intranet/img/sello.png" style="width:60px;">
				<p>_____________________________<br>AUTORIZACIÓN <br> (JEFE DE ÁREA O UNIDAD)</p>
			</td>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<p><br><br><br><br><br>_____________________________<br>FIRMA DEL CLIENTE</p>
			</td>
		</tr>
	</table>
	
	</main>
	<footer>
		<img src="https://andartmusic.com/intranet/img/pie_morado.png" alt="Pie de página" style="width:100%">
	</footer>
</body>

<style>
	@page{
		margin: 10px 45px 10px 45px;
	}
	body {
	font-family: 'Calibri', sans-serif;
	font-size: 0.7em;
	}
	.text-center{text-align: center;}
	.mt-1{margin-top:10px}
	p,h2, h3{margin:0; }
	table {
		width: 100%;
		/* border:1px solid; */
		border-collapse: collapse;
	}
	 th, td {
		border: 1px solid black;
	}
	td {
		padding: 8px;
		text-align: center;
		vertical-align: top;
	}
	.centroTodo{
		text-align: center;
		vertical-align: middle;
	}
	.centroVertical{
		vertical-align: middle;
	}
	/* Estilo específico para la segunda columna */
	td:nth-child(2), .sinLinea, .ceroLinea {
		border-top: none;
		border-bottom: none;
	}
	.ceroLinea{
		border-right: none;
		border-left: none;
		text-align: left;
	}
	.text-left{text-align: left;}
	footer { position: fixed; bottom: 20px; left: 0px; right: 0px; height: 50px; }
	#divPlomo{
		background-color: #c0c0c0;
	}
	#cuadrado{
		border:1px solid black;
		padding: 1px 4px;
		width: 10px;
		margin-top: 5px;
		display: inline-block;
	}
	#trDetalle p{
		margin-bottom:5px
	}
</style>