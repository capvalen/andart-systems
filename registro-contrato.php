<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistema Intranet - Andart Music</title>
	<?php include 'headers.php'; ?>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container">
		<p class="fs-4">Registro de cotización</p>
		<p>Rellene cuidadosamente los siguientes datos para crear una nueva cotización:</p>
		<div class="row">
			<div class="col-12 col-lg-6 mx-auto">
				<p class="fw-bold">Datos del Promotor</p>
				<div class="card">
					<div class="card-body">
						<label for="">Apellidos y nombres o Razón Social</label>
						<input type="text" class="form-control">
						<label for="">DNI/RUC</label>
						<input type="text" class="form-control">
						<label for="">Domicilio</label>
						<textarea name="" rows="3" class="form-control"></textarea>
						<label for="">Celular / Teléfono</label>
						<input type="text" class="form-control">
						<label for="">E-mail</label>
						<input type="text" class="form-control">
					</div>
				</div>
				<p class="fw-bold mt-3">Datos del Evento</p>
				<div class="card">
					<div class="card-body">
						<label for="">Grupo artístico</label>
						<select name="" id="sltArtisata">
							<option value="1">Sentimiento del Ande</option>
							<option value="2">Lobelia</option>
						</select>
						<label for="">Fecha del evento</label>
						<input type="date" class="form-control">
						<label for="">Dirección del local</label>
						<input type="text" class="form-control">
						<label for="">Horas de contrato</label>
						<input type="number" class="form-control">
						<div class="row">
							<div class="col-6">
								<label for="">Hora inicio</label>
								<input type="time" class="form-control">
							</div>
							<div class="col-6">
								<label for="">Hora final</label>
								<input type="time" class="form-control">
							</div>
						</div>
					</div>
				</div>

				<p class="fw-bold mt-3">Costos de inversión</p>
				<div class="card">
					<div class="card-body">
						<label for="">Suma total acordada (S/)</label>
						<input type="number" class="form-control">
						<label for="">Adelanto entregado (S/)</label>
						<input type="number" class="form-control">
						<label for="">Monto restante (S/)</label>
						<input type="number" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>