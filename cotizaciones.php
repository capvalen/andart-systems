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
			<a class="btn btn-outline-primary" href="registro-cotizacion.php"><i class="bi bi-asterisk"></i> Crear nueva cotización</a>
		</div>

		<p>Se muestran las últimas cotizaciones pendientes:</p>
		<table class="table table-hover">
			<thead>
				<th>N°</th>
				<th>Cliente</th>
				<th>Fecha del evento</th>
				<th>Agrupación</th>
				<th>Total</th>
				<th>Contestación</th>
				<th>@</th>
			</thead>
			<tbody>
				<tr v-for="(evento, index) in eventos">
					<td>{{index+1}}</td>
					<td class="text-capitalize"><a class="text-decoration-none" :href="'detalle-cotizacion.php?id='+evento.id">{{evento.nombre}}</a></td>
					<td>{{fechaLatam(evento.fechaEvento)}}</td>
					<td>
						<span v-if="evento.agrupacion==1">SDA</span>
						<span v-if="evento.agrupacion==2">LBLA</span>
					</td>
					<td>S/ {{moneda(evento.total)}}</td>
					<td>
						<span v-if="evento.fechaContestacion">{{fechaLatam(evento.fechaContestacion)}}</span>
						<span v-else>Pendiente</span>
					</td>
					<td>
						<button class="btn btn-sm btn-outline-danger border-0" @click="eliminar(index)"><i class="bi bi-x-circle"></i></button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php include 'footer.php'; ?>
	<script>
	const { createApp, ref, onMounted } = Vue

	createApp({
		setup() {			
			const eventos = ref({})

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

			function eliminar(index){
				if(confirm(`¿Desea eliminar la cotización del cliente ${eventos.value[index].nombre.toUpperCase()}?`)){
					var datos = new FormData()
					datos.append('pedir', 'eliminar')
					datos.append('id', eventos.value[index].id)
				
					fetch('./api/Cotizacion.php', {
						method:'POST', body: datos
					})
					.then( serv => serv.text() )
					.then( resp => {
						if(resp == 'ok') pedirDatos()
						else alert('Hubo un problema al eliminar')
					})
				}
			}

			return {
				eventos,
				pedirDatos, eliminar,
				fechaLatam, horaLatam, salto, moneda
			}
		}
	}).mount('#app')
</script>
</body>
</html>