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
	<div class="container" id="app">
		<p class="fs-4 text-center">Cotizaciones de Show's Musicales</p>

		<div class="col-12 mx-auto d-grid d-flex justify-content-end">
			<button class="btn btn-outline-primary">
				<i class="bi bi-asterisk"></i> Crear nueva cotización
			</button>
		</div>

		<p>Se muestran las últimas cotizaciones pendientes:</p>

		<!-- ⚡ Bloque dinámico -->
		<div v-if="eventos.length === 0" class="alert alert-warning text-center my-3">
			No se encontraron cotizaciones
		</div>

		<table v-else class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Cliente</th>
					<th>Fecha del evento</th>
					<th>Agrupación</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(item, index) in eventos" :key="item.id">
					<td>{{ item.idFormateado }}</td>
					<td>{{ item.nombre }}</td>
					<td>{{ fechaLatam(item.fechaEvento) }}</td>
					<td>{{ item.agrupacion == 1 ? 'Sentimiento del Ande' : (item.agrupacion == 2 ? 'Lobelia' : '-') }}</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php include 'footer.php'; ?>
	<script>
	const { createApp, ref, onMounted } = Vue

	createApp({
		setup() {			
			// 🔹 eventos debe iniciar como array, no como objeto
			const eventos = ref([])

			onMounted(()=>{ pedirDatos() })

			function fechaLatam(fecha){ if(fecha) return moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') }
			function horaLatam(hora){ if(hora) return moment(hora, 'HH:mm').format('hh:mm a') }
			function salto(linea){ if(linea) return linea.replace(/\r/g, '<br>')}
			function moneda(cantidad){ if(cantidad) return parseFloat(cantidad).toFixed(2); else '0.000'; }

			function pedirDatos(){
				var datos = new FormData()
				datos.append('pedir', 'listarTodo')
			
				fetch('./api/Cotizacion.php', {
					method:'POST', body: datos
				})
				.then( serv => serv.json() )
				.then( resp => {
					eventos.value = resp
				})
			}

			return {
				eventos,
				pedirDatos,
				fechaLatam, horaLatam, salto, moneda
			}
		}
	}).mount('#app')
	</script>
</body>
</html>