<head>
	<title>Contrato Andart Music N°-<?= sprintf('%04d', $numero) ?></title>
</head>
<body>
	<header>
		<img src="https://andartmusic.com/intranet/img/cabecera_logo.png" alt="Mi Imagen" style="width:100%">
	</header>
	<pie>
		<img src="https://andartmusic.com/intranet/img/pie_morado.png" alt="Mi Imagen" style="width:100%">
	</pie>
	<div id="firmaPegada">
		<img src="https://andartmusic.com/intranet/img/firma_gris.jpg"  style="width:180px">
	</div>

	<main style="margin-top:-60px">
		<p>Conste por el presente documento el contrato que suscribe por una parte la <strong>EMPRESA</strong>, ANDART MUSIC SAC representado por, <strong><?= $nombreDueño ?></strong>, identificado con <strong>DNI N° <?= $dniDueño ?></strong> y con domicilio legal en <strong>Av. La Esperanza N° 720 El Tambo - Huancayo</strong>; a quien en adelante se le denominará <strong>LA EMPRESA</strong> y por la otra parte <strong><?= $nombreCliente;?></strong>, identificado con <strong>DNI <?= $dniCliente; ?></strong>, con domicilio en <strong><?= $domicilioCliente;?></strong>, ubicado en <strong><?= $ubigeo; ?></strong>, quién en adelante se le denominará <strong>EL PROMOTOR</strong> en los términos y condiciones siguientes:</p>
		<h4>PRIMERO: DE LAS PARTES</h4>
		<ol type="a">
			<li><strong>LA EMPRESA</strong> tiene por naturaleza, la difusión de música latinoamericana y variada mediante la representación de artistas y agrupaciones musicales</li>
			<li><strong>EL PROMOTOR</strong> tiene por finalidad la organización de un evento musical presencial que se llevará a cabo en el local: <strong><?= $local; ?></strong>, Fecha: <strong><?= $fechaEvento ?></strong></li>
			<p>Teléfono: <?= $celularCliente; ?> <br> E-mail: <?= $correoCliente; ?></p>
		</ol>
		<h4>SEGUNDO: CONTRATO</h4>
		<ol type="a">
			<li>Las partes acuerdan suscribir el presente contrato mediante la cual <strong>LA EMPRESA</strong> se compromete a la prestación de servicios musicales de la agrupación <?= $agrupacion; ?> durante el periodo de <?= $tiempoEvento ?>, en el horario <?= $horarioCompleto ?>, lugar y fecha indicada en el inciso "b" del primer punto.</li>
			<li><strong>EL PROMOTOR</strong> se compromete <strong>a pagar la suma de S/ <?= number_format($total,2); ?> soles,</strong> por la prestación de los servicios musicales, dando como <strong>adelanto la suma de S/ <?= number_format($adelanto,2) ?> soles</strong> el <?= $fechaAdelanto ?> y <strong>completando el restante la suma de S/ <?= number_format($restante,2) ?> soles,</strong> <span class="italic">un día antes del evento o durante la mañana del evento en horario administrativo (9am – 1pm) antes del inicio de la presentación,</span> de no realizarse el abono en la forma señalada, la prestación de servicios musicales <strong class="subrayado">se entiende como cancelada sin obligación a devolución de lo abonado, ni a ningún tipo de indemnización.</strong> </li>
			<li>La fecha de presentación de <strong>la agrupación</strong> es <strong>INAMOVIBLE</strong>.</li>
			<li>Cualquier demora en el plazo de pago establecido exceptúa a <strong>LA EMPRESA</strong> de cualquier obligación contraída.</li>
			<li>Sin perjuicio de lo antes expuesto queda convenido en forma expresa por las partes contratantes que el show artístico programado en el presente contrato podrá ser suspendido solamente en los siguientes casos:
				<ul>
					<li>En el supuesto negado que <strong>EL PROMOTOR</strong> no haya cumplido con el pago correspondiente a <strong>LA EMPRESA</strong>.</li>
					<li>En el supuesto negado que EL <strong>PROMOTOR</strong> no haya cumplido con el <strong>RIDER TÉCNICO</strong>.</li>
					<li>Por daños en el lugar del evento, y de no haber un estrado seguro para la presentación de la agrupación.</li>
					<li>En caso la agrupación pueda contraer algún daño debido a algún desastre natural, lluvias, huaycos, tormentas, terremotos, etc. Para este caso y los dos anteriores la agrupación puede ofrecer la suspensión del evento, quedando pendiente brindar una nueva fecha para realizar la presentación de <strong>LA AGRUPACIÓN</strong>.</li>
				</ul>
			</li>
		</ol>
		<h4>TERCERO: EL PROMOTOR, se compromete a:</h4>
		<ol type="a">
			<li>Realizar el alquiler de equipo de sonido según <strong>RIDER TÉCNICO</strong>.</li>
			<li>Gestionar un escenario adecuado para la instalación de la agrupación.</li>
			<li><strong>EL PROMOTOR</strong> deberá proporcionar todo aquello que la agrupación requiera durante el show, equipos, luces y todo lo relacionado.</li>
			<li><strong>EL PROMOTOR</strong>, tendrá que acondicionar fluido eléctrico en el local para poder utilizar nuestros equipos y todo lo concerniente al escenario de la orquesta.</li>
			<li>De igual forma, <strong>EL PROMOTOR</strong> asumirá el integro de los gastos de producción del evento (lo cual incluirá la publicidad, permisos, licencias y en general todo lo que sea necesario para el desarrollo del show artístico).</li>
			<li><strong>EL PROMOTOR</strong> podrá hacer uso de la marca propiedad de <strong>LA EMPRESA</strong> registrada ante INDECOPI con Certificado N° 00148286 denominada <strong>"<?= strtoupper($agrupacion) ?>"</strong>, para la publicidad y promoción del evento, no podrá hacer modificaciones que alteren la reputación de la empresa, no deberá variar dicho nombre en caso haya nuevo personal dentro de la agrupación.</li>
			<li><strong>EL PROMOTOR</strong> deberá respetar la hora pactada y duración del evento señalada en la cláusula segunda del presente documento. En ese sentido, <strong>LA EMPRESA</strong> solo podrá hacer una variación del horario de presentación de 30 minutos (tiempo de tolerancia). En caso se requiera una variación de tiempo mayor, se deberá coordinar previamente con <strong>LA EMPRESA</strong> con un mínimo de 24 horas de anticipación, y dependiendo de la disponibilidad de <strong>LA EMPRESA</strong> esta evaluará su aceptación previa coordinación en caso conlleve gastos adicionales para <strong>LA EMPRESA</strong> (no es obligatorio que <strong>LA EMPRESA</strong> acepte).</li>
			<li><strong>EL PROMOTOR</strong> tiene la obligación de velar por la seguridad de los integrantes de la agrupación, en la ciudad de destino desde su arribo hasta la fecha de retorno de los integrantes.</li>
			<li>Cumplir con todos los protocolos de bioseguridad, incluye la capacidad limitada de personas en el día del evento.</li>
			<li><strong>EL PROMOTOR</strong> es el único responsable por la seguridad de los integrantes y todo equipo que la agrupación posea, en el lugar del evento.</li>
			<li><strong>EL PROMOTOR</strong> deberá ofrecer un <strong>almuerzo o cena</strong> dependiendo del horario del contrato y <strong>bebidas</strong> para todo el personal, y agua para el escenario (Aprox. <?= $personas ?> personas). Asimismo, se prohíbe brindar a los miembros de la agrupación bebidas alcohólicas antes, durante y después del show artístico, salvo autorización expresa del manager por escrito.</li>
			<li>Finalmente, <strong>EL PROMOTOR</strong> deberá realizar los eventos en las fechas indicada en EL CONTRATO, caso contrario por culpa justificable o no justificable de <strong>EL PROMOTOR</strong>, no será de responsabilidad de <strong>LA EMPRESA</strong>, así mismo la agrupación no se encuentra obligada a brindar una nueva fecha por esta cancelación del evento, no viéndose obligada tampoco a devolver el adelanto entregado previamente.</li>

		</ol>
		<h4>CUARTO: Por su parte <strong>LA EMPRESA</strong>, se compromete a:</h4>
		<ol type="a">
			<li>Llevar a cabo la presentación artística musical en la duración acordada, comprometiéndose a que la misma será desarrollada de acuerdo a los más altos estándares de calidad, utilizando todos los instrumentos musicales que tocan en todas sus presentaciones y los integrantes completos (debidamente uniformados).</li>
			<li>Cumplir con el horario establecido.</li>
			<li>Cuidar la imagen, presentación con el vestuario correspondiente.</li>
			<li>Asistir con los instrumentos requeridos para la actividad.</li>
		</ol>
		<h4>QUINTO: CORRESPONSABILIDAD</h4>
		<ol type="a">
			<li>Los asuntos no previstos en el presente contrato podrán ser resueltos de común acuerdo entre las partes sin desnaturalizar los objetivos de los mismos.</li>
		</ol>
		<p>En señal de conformidad firman el presente acuerdo.</p>
		<table>
			<tr>
					<td>
						<div><img src="https://andartmusic.com/intranet/img/firma_color.jpg"  style="width:180px"></div>
						<p><strong>______________________________<br>
							<?= $nombreDueño ?><br><?= $dniDueño ?><br>LA EMPRESA
						</strong></p>
				</td>
					<td>
						<p><br><br><br></p>
						<p><strong>______________________________<br>
							<?= $nombreCliente ?><br><?= $dniCliente ?><br>EL PROMOTOR
						</strong></p>
				</td>
			</tr>
	</table>
	</main>
	<footer>
		<img src="https://andartmusic.com/intranet/img/pie_morado.png" alt="Mi Imagen" style="width:100%">
	</footer>
	
	

</body>

<style>
	
body {
	font-family: 'Calibri', sans-serif;
	font-size: 0.9em;
	text-align: justify;
}
#firmaPegada { position: fixed; top: 300px; left: -136px;transform: rotate(-90deg);}
header { position: fixed; top: -120px; left: 0px; right: 0px; 
	height: 50px;
}
pie { position:absolute; bottom: -60px; left: 0px; right: 0px; height: 50px; }
footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }

p:last-child { page-break-after: never; }
main{margin-top:30px;}

h4,h5{color: #2f5496; }
.italic{font-style: italic;}
.subrayado{text-decoration: underline;}

p,li{line-height: 1.3rem;}
table {
	width: 100%;
	border-collapse: collapse;
}
table td {
	padding: 10px;
	border: none;
	text-align: center;
}
@page{
	margin: 140px 95px 100px 95px;
}

</style>