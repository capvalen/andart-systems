<head>
	<title>Contrato Andart Music COT-<?= sprintf('%04d', $numero) ?></title>
</head>
<body>
	<main>
	<center><img src="https://andartmusic.com/intranet/img/cabecera_logo.png" alt="Mi Imagen" style="width: 100%; margin-bottom:0rem;"></center>
	
	<table class="mt-1" id="tablaCabeza">
		<tr>
			<td colspan="3"><strong>FECHA DE SOLICITUD</strong></td>
			<td rowspan="3" class="centroTodo" id="divPlomo"><h2>COTIZACIÓN DE SHOW MUSICAL</h2></td>
			<td rowspan="2" style="vertical-align: middle; text-align: center;"><strong>CONSECUTIVO</strong></td>

			<td colspan="3"><strong>FECHA DE CONTESTACIÓN</strong></td>

				
		</tr>
		<tr>
			<th>DIA</th>
			<th>MM</th>
			<th>AA</th>
			<th>DIA</th>
			<th>MM</th>
			<th>AA</th>
		</tr>
		<tr>
				<td class="text-capitalize"><?= $fechaSolicitud['dia'] ?></td>
				<td class="text-capitalize"><?= $fechaSolicitud['mes'] ?></td>
				<td class="text-capitalize"><?= $fechaSolicitud['año'] ?></td>
				
				
				<td class="conLineas"><h2>COT-<?= sprintf('%04d', $numero) ?></h2></td>
				
				<td class="text-capitalize"><?= $fechaContestacion['dia'] ?></td>
				<td class="text-capitalize"><?= $fechaContestacion['mes'] ?></td>
				<td class="text-capitalize"><?= $fechaContestacion['año'] ?></td>
		</tr>
	</table>
	<br>
	<table>
		<tr id="trDetalle">
			<td class="ceroLinea" style="width:auto; white-space: nowrap;">
				<!-- <p><strong>DNI: </strong> </p> -->
				<p><strong>NOMBRE DEL CLIENTE: </strong> </p>
				<!-- <p><strong>UBICACIÓN: </strong> </p> -->
				<p><strong>FECHA DEL EVENTO: </strong> </p>
				<p><strong>DURACIÓN DEL SHOW: </strong> </p>
				<p><strong>DIRECCIÓN / LUGAR DEL EVENTO: </strong> </p>
				<p class="centroVertical" ><strong class="centroVertical">AGRUPACIÓN: </strong> </p>

			</td>
			<td class="ceroLinea tdDatos" style="width:auto; white-space: nowrap;">
				<p class="text-capitalize"><?= strtoupper($nombreCliente) ?></p>
				<p class="text-capitalize"><?= strtoupper($fechaEvento) ?></p>
				<p class="text-capitalize"><?= strtoupper(str_replace('.0','',$tiempoEvento)) ?> HORAS </p>
				<p class="text-capitalize"><?= strtoupper($local) ?></p>
				<p class="centroVertical text-capitalize" style="border-bottom:none!important;"><span class="text-center" id="cuadrado"><strong>x</span> <?= strtoupper($agrupacion) ?></p>
			</td>
			<td id="vacio" class="ceroLinea"></td>
			<td class="ceroLinea" style=" white-space: nowrap;">
				<p><strong>RAZÓN SOCIAL: </strong> </p>
				<p><strong>RUC: </strong> </p>
				<p><strong>CELULAR: </strong> </p>
				<p><strong>TIPO DE EVENTO: </strong> </p>
				<p><strong>HORA DE INICIO: </strong> </p>
			</td>
			<td class="ceroLinea tdDatos" style=" white-space: nowrap;">
				<p class="text-capitalize"><?= strtoupper($razonCliente) ?></p>
				<p class="text-capitalize"><?= strtoupper($rucCliente) ?></p>
				<p class="text-capitalize"><?= strtoupper($celularCliente) ?></p>
				<p class="text-capitalize"><?= strtoupper($tipoEvento) ?></p>
				<p class="text-capitalize"><?= strtoupper($horarioInicio) ?></p>
			</td>

		</tr>
		<tr>
			<td class="text-left" colspan="5"><strong>OBSERVACIONES:</strong> <?= $observaciones; ?></td>
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
				<?php if($tieneIGV=='1'): ?>
					<p>Costo del show (Sin IGV): S/ <?= number_format($base,2) ?></p>
					<p>IGV: S/ <?= number_format($igv,2) ?></p>
				<?php endif;?>
				<p>Monto total: S/ <?= number_format($total,2) ?></p>
				<p><i>* Monto no facturado</i></p>
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
	.sinLinea, .ceroLinea {
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
		border: 1px solid black;
		background-color: #3c0560;
		color:white;
	}
	.conLineas{
		border: 1px solid black!important;
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
	#vacio{
		width:200px;
	}
	.tdDatos p{
		text-align: center;
		width: 100%;
		border-bottom: 1.5px solid black!important;
	}
	#tablaCabeza td{
		vertical-align: middle; text-align: center;
		padding: 0;
	}
	
</style>