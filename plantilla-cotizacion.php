<head>
	<title>Contrato Andart Music N°-<?= sprintf('%04d', $numero) ?></title>
</head>
<body>
	<main>
	<center><img src="https://andartmusic.com/intranet/img/logo-andart.png" alt="Mi Imagen" style="width: 600px; margin-bottom:0rem;"></center>
	<h3 class="text-center" style="margin-bottom:1rem">COTIZACIÓN DE SHOW  COT -<?= sprintf('%04d', $numero) ?></h3>

	<table>
			<tr>
					<td><strong>FECHA DE SOLICITUD</strong></td>
					<td class="sinLinea"></td>
					<td><strong>FECHA DE CONTESTACIÓN</strong></td>
			</tr>
			<tr>
					<td><?= $fechaSolicitud ?></td>
					<td class="sinLinea"></td>
					<td><?= $fechaContestacion ?></td>
			</tr>
	</table>
	<br>
	<table>
		<tr>
			<td class="ceroLinea">
				<p><strong>Nombre del Cliente: </strong> <?= $nombreCliente ?></p>
				<p><strong>Fecha del evento: </strong> <?= $fechaEvento ?></p>
				<p><strong>Duración del show: </strong> <?= $tiempoEvento ?></p>
				<p><strong>Dirección / Lugar del evento: </strong> <?= $local ?></p>
			</td>
			<td class="ceroLinea"></td>
			<td class="ceroLinea">
				<p><strong>DNI: </strong> <?= $dniCliente ?></p>
				<p><strong>Celular: </strong> <?= $celularCliente ?></p>
				<p><strong>Tipo de evento: </strong> <?= $tipoEvento ?></p>
				<p><strong>Hora de inicio: </strong> <?= $horarioInicio ?></p>
				<p><strong>Agrupación: </strong> <?= $agrupacion ?></p>
			</td>
		</tr>
		<tr>
			<td class="ceroLinea" colspan="4"><strong>Observaciones:</strong> <?= $observaciones; ?></td>
		</tr>
		<tr>
			<td class="ceroLinea">
				<p><strong>No incluye:</strong></p>
				<ol>
					<li>Escenario</li>
					<li>Equipo de Sonido</li>
				</ol>
			</td>
			<td class="ceroLinea">
				<p><strong>Requisitos del Cliente:</strong></p>
				<ol>
					<li>Permisos y protocolos requeridos</li>
					<li>Aforo permitido</li>
					<li>Hidratación <?= $personas ?> personas en escenario</li>
					<li>Almuerzo <?= $personas ?> personas</li>
					<?php if($hospedaje): ?>
					<li>Hospedaje <?= $personas ?> personas</li>
					<?php endif; ?>
				</ol>
			</td>
			<td class="ceroLinea">
				<p><strong>Costo del Show:</strong></p><br>
				<p>Costo total (Sin I.G.V.): S/ <?= number_format($total,2) ?></p>
				<p>Promoción: S/ <?= number_format($promocion,2) ?></p>
				<p>Adelanto: S/ <?= number_format($adelanto,2) ?></p>
				<p>Fecha de adelanto: <?= $fechaAdelanto ?></p>
			</td>
		</tr>
	</table>

	<table>
		<tr>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<p><br><br><br><br><br>_____________________________<br>FIRMA DEL VENDEDOR</p>
			</td>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<p><br><br><br><br><br>_____________________________<br>AUTORIZACIÓN <br> (JEFE DE ÁREA O UNIDAD)</p>
			</td>
			<td style="width:33%; text-align:center;font-size:0.8em;" class="ceroLinea">
				<p><br><br><br><br><br>_____________________________<br>FIRMA DEL CLIENTE</p>
			</td>
		</tr>
	</table>
	
	</main>
	<footer>
		<img src="https://andartmusic.com/intranet/img/pie-largo.png" alt="Mi Imagen" style="width:100%">
	</footer>
</body>

<style>
	@page{
		margin: 10px 45px 10px 45px;
	}
	body {
	font-family: 'Calibri', sans-serif;
	font-size: 0.9em;
	}
	.text-center{text-align: center;}
	p, h3{margin:0; }
	table {
		width: 100%;
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
</style>