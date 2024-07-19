<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include 'headers.php'; ?>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container" id="app">
		<p class="fs-4">Registro de cotización Show Musical</p>
		<p>Rellene cuidadosamente los siguientes datos para crear una nueva cotización:</p>
		<div class="row">
			<div class="col-12 col-lg-6 mx-auto">
				<p class="fw-bold">Datos del Cliente</p>
				<div class="card">
					<div class="card-body">
						<label for="">DNI/RUC <span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="cliente.dni">
						<label for="">Apellidos y nombres o Razón Social <span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="cliente.nombre">
						<label for="">Celular <span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="cliente.celular">
						<label for="">E-mail</label>
						<input type="text" class="form-control" v-model="cliente.email">
					</div>
				</div>
				<p class="fw-bold mt-3">Datos del Evento</p>
				<div class="card">
					<div class="card-body">
						<label for="">Fecha del evento <span class="text-danger">*</span></label>
						<input type="date" class="form-control" v-model="evento.fecha">
						<label for="">Agrupación <span class="text-danger">*</span></label>
						<select class="form-select" id="sltArtisata" v-model="evento.agrupacion">
							<option value="-1">Seleccione una agrupación</option>
							<option value="1">Sentimiento del Ande - SDA</option>
							<option value="2">Lobelia - LBLA</option>
						</select>
						<label for="">Lugar del evento <span class="text-danger">*</span></label>
						<textarea name="" rows="2" class="form-control" v-model="evento.lugar"></textarea>
						<label for="">Dirección del local <span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="evento.local">
						<label for="">Duración del evento</label>
						<input type="number" class="form-control" min=1 v-model="evento.duracion">
						<label for="">Horario</label>
						<select class="form-select" id="sltHoraInicio" v-model="evento.horario">
							<option value="0">Por confirmar</option>
							<option value="1">Confirmado</option>
						</select>
						<div v-if="evento.horario==1">
							<label for="">Hora de inicio</label>
							<input type="time" class="form-control" v-model="evento.hora">
						</div>
						<label for="">Tipo</label>
						<select class="form-select" id="sltHoraInicio" v-model="evento.tipo">
							<option value="0">Público</option>
							<option value="1">Privado</option>
						</select>
						<label for="">N° de personas involucradas <span class="text-danger">*</span></label>
						<input type="number" class="form-control" min=1 v-model="evento.personas">
						<label for="">¿Se considerará hospedaje?</label>
						<select class="form-select" id="sltHospedaje" v-model="evento.hospedaje">
							<option value="0">No</option>
							<option value="1">Sí</option>
						</select>
						<!-- <label for="">Se debe incluir</label>
						<textarea class="form-control" rows="3" v-model="evento.incluye.replace(/\n/g, '<br>')"></textarea>
						<label for="">No se incluye incluir</label>
						<textarea class="form-control" rows="3" v-model="evento.noIncluye.replace(/\n/g, '<br>')"></textarea> -->
						<label for="">Observaciones</label>
						<textarea class="form-control" rows="3" v-model="evento.observaciones.replace(/\n/g, '<br>')"></textarea>
					</div>
				</div>

				<p class="fw-bold mt-3">Costos de inversión</p>
				<div class="card">
					<div class="card-body">
						<label for="">Costo del show <span class="fw-bold">Sin IGV</span> (S/) <span class="text-danger">*</span></label>
						<input type="number" class="form-control" v-model="costo.total">
						<label for="">Promoción (S/)</label>
						<input type="number" class="form-control" v-model="costo.promocion">
						<label for="">Adelanto del 50% (S/) <span class="text-danger">*</span></label>
						<input type="number" class="form-control" v-model="costo.adelanto">
						<label for="">Fecha del Adelanto <span class="text-danger">*</span></label>
						<input type="date" class="form-control" v-model="costo.fecha">
					</div>
				</div>

				<div class="d-grid my-5 d-flex justify-content-center">
					<button class="btn btn-outline-primary" @click="confirmar()"><i class="bi bi-floppy"></i> Crear cotización</button>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
<script>
	const { createApp, ref } = Vue

	createApp({
		setup() {
			const cliente = ref({ dni:'', nombre: '', celular: '', email: ''  })
			const evento = ref({ fecha: moment().format('YYYY-MM-DD'), lugar: '', agrupacion: -1, local: '', duracion: 2, horario: 0, hora: '12:00', observaciones: '', hospedaje:0, personas:1, incluye:'', noIncluye:'', tipo:0 })
			const costo = ref({ total:0, promocion: 0, adelanto: 0, fecha: moment().format('YYYY-MM-DD') })
			
			function confirmar(){
				if( !cliente.value.dni || !cliente.value.nombre || !cliente.value.celular ){ alert('Debe rellenar datos del cliente')}
				else if(!evento.value.fecha || !evento.value.lugar || evento.value.agrupacion==-1 || !evento.value.local || !evento.value.personas){ alert('Debe rellenar obligatorios del evento')}
				else if( costo.value.total==0 || !costo.value.adelanto || !costo.value.fecha ){ alert('Debe rellenar datos obligatorios del pago')}
				else crear()
			}
			function crear(){
				var datos = new FormData()
				datos.append('pedir', 'crear')
				datos.append('cliente', JSON.stringify(cliente.value))
				datos.append('evento', JSON.stringify(evento.value))
				datos.append('costo', JSON.stringify(costo.value))

				fetch('./api/Cotizacion.php', {
					method:'POST', body: datos
				})
				.then( serv => serv.text() )
				.then( resp => {
					if( parseInt(resp)>0 ) window.location = 'detalle-cotizacion.php?id='+resp
					else alert('Hubo un error al guardar los datos')
				})
			}

			return {
				cliente, evento, costo,
				crear, confirmar
			}
		}
	}).mount('#app')
</script>
</body>
</html>