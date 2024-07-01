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
	<div class="container mb-5" id="app">
		<p class="fs-4 text-center">Cotización Show Musical C-{{evento.idFormateado}}</p>
		<div class="row mb-3">
			<div class="col-12 col-lg-9 mx-auto">
				<div class="d-grid d-flex justify-content-between">
					<button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate"><i class="bi bi-printer"></i> Actualizar cotización</button>
					<button class="btn btn-outline-success"><i class="bi bi-printer"></i> Imprimir cotización</button>
					<button class="btn btn-outline-secondary"><i class="bi bi-capslock-fill"></i> Crear contrato</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-lg-6 mx-auto">
				<p class="fw-bold">Datos del Cliente</p>
				<div class="card">
					<div class="card-body">
						<p class="mb-0 fw-bold">DNI / RUC: <span class="fw-normal text-capitalize">{{cliente.dni}}</span> </p>
						<p class="mb-0 fw-bold">Apellidos y nombres / Razón Social: <span class="fw-normal text-capitalize">{{cliente.nombre}}</span> </p>
						<p class="mb-0 fw-bold">Celular: <span class="fw-normal text-capitalize">{{cliente.celular}}</span> </p>
						<p class="mb-0 fw-bold">E-mail: <span class="fw-normal ">{{cliente.email}}</span> </p>
					</div>
				</div>

				<p class="fw-bold mt-3">Datos del costo</p>
				<div class="card">
					<div class="card-body">
						<p class="mb-0 fw-bold">Costo del show sin IGV: <span class="fw-normal text-capitalize">S/ {{moneda(costo.total)}}</span> </p>
						<p class="mb-0 fw-bold">Promoción: <span class="fw-normal text-capitalize">S/ {{moneda(costo.promocion)}}</span> </p>
						<p class="mb-0 fw-bold">Adelanto: <span class="fw-normal text-capitalize">S/ {{moneda(costo.adelanto)}}</span> </p>
						<p class="mb-0 fw-bold">Fecha del Adelanto: <span class="fw-normal text-capitalize">{{fechaLatam(costo.fechaAdelanto)}}</span> </p>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6">
			<p class="fw-bold">Datos del Evento</p>
				<div class="card">
					<div class="card-body">
						<p class="mb-0 fw-bold">Fecha del evento: <span class="fw-normal text-capitalize">{{fechaLatam(evento.fechaEvento)}}</span> </p>
						<p class="mb-0 fw-bold">Lugar del evento: <span class="fw-normal text-capitalize">{{evento.lugar}}</span> </p>
						<p class="mb-0 fw-bold">Agrupacion:
							<span v-if="evento.agrupacion==1" class="fw-normal text-capitalize">Sentimiento del Ande - SDA</span>
							<span v-if="evento.agrupacion==2" class="fw-normal text-capitalize">Lobelia - LBLA</span>
						</p>
						<p class="mb-0 fw-bold">Dirección del local: <span class="fw-normal text-capitalize">{{evento.direccion}}</span> </p>
						<p class="mb-0 fw-bold">Duración del evento: <span class="fw-normal text-capitalize">{{evento.duracion}} horas</span> </p>
						<p class="mb-0 fw-bold">Horario:
							<span v-if="evento.horario==1" class="fw-normal text-capitalize">Confirmado</span>
							<span v-if="evento.horario==0" class="fw-normal text-capitalize">Sin confirmar</span>
						</p>
						<p v-if="evento.horario==1" class="mb-0 fw-bold">Hora de inicio: <span class="fw-normal">{{horaLatam(evento.hora)}} </span> </p>
						<p class="mb-0 fw-bold">Observaciones: <p class="fw-normal mb-0" v-html="salto(evento.observaciones)"></p> </p>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Acualización del contrato</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p class="mb-0">Puede realizar actualizaciones en el contrato en los campos:</p>
						<label for="">Estado</label>
						<select name="" id="" class="form-select" v-else="evento.estado">
							<option value="0">Pendiente de confirmar</option>
							<option value="1">Confirmar cotización</option>
							<option value="2">Anular cotización</option>
						</select>
						<label for="">Horario del show</label>
						<select name="" id="" class="form-select" v-model="evento.horario">
							<option value="0">Pendiente de confirmar</option>
							<option value="1">Horario confirmado</option>
						</select>
						<div v-if="evento.horario==1">
							<label for="">Hora de inicio</label>
							<input type="time" class="form-control" v-model="evento.hora">
						</div>
						<label for="">Duración del show show (horas)</label>
						<input type="number" class="form-control" v-model="evento.duracion">
						<label for="">Dirección del local</label>
						<input type="text" class="form-control" v-model="evento.direccion">
					</div>
					<div class="modal-footer border-0">
						<button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" @click="actualizar()"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>

	<?php include 'footer.php'; ?>
	<script>
	const { createApp, ref, onMounted } = Vue

	createApp({
		setup() {
			const cliente = ref({})
			const evento = ref({})
			const costo = ref({})

			onMounted(()=>{ pedirDatos() })

			function fechaLatam(fecha){ if(fecha) return moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') }
			function horaLatam(hora){ if(hora) return moment(hora, 'HH:mm').format('hh:mm a') }
			function salto(linea){ if(linea) return linea.replace(/\r/g, '<br>')}
			function moneda(cantidad){ if(cantidad) return parseFloat(cantidad).toFixed(2); else '0.000'; }

			function pedirDatos(){
				var datos = new FormData()
				datos.append('pedir', 'listar')
				datos.append('id', '<?= $_GET['id']; ?>')
				
				fetch('./api/Cotizacion.php', {
					method:'POST', body: datos
				})
				.then( serv => serv.json() )
				.then( resp => {
					cliente.value = resp.cliente
					evento.value = resp.evento
					costo.value = resp.costo
				})
			}

			function actualizar(){
				var datos = new FormData()
				datos.append('pedir', 'actualizar')
				datos.append('id', '<?= $_GET['id']; ?>')
				datos.append('evento', JSON.stringify(evento.value))
				
				fetch('./api/Cotizacion.php', {
					method:'POST', body: datos
				})
				.then( serv => serv.text() )
				.then( resp => {
					if( resp == 'ok') alert('Datos actualizados con éxito')
					else alert('Hubo un problema al actualizar')
				})
			}

			return {
				cliente, evento, costo,
				pedirDatos, actualizar,
				fechaLatam, horaLatam, salto, moneda
			}
		}
	}).mount('#app')
</script>
</body>
</html>