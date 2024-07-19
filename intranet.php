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
		<p class="fs-4">Bienvenido a Andart Music - Intranet</p>
		<p>A continuación se muestran los 50 últimos contratos</p>
		<table class="table table-hover">
			<thead>
				<th>N°</th>
				<th>Cliente</th>
				<th>Fecha del evento</th>
				<th>Agrupación</th>
				<th>Total</th>
				<th>@</th>
			</thead>
			<tbody>
				<tr v-for="(evento, index) in eventos">
					<td>{{index+1}}</td>
					<td class="text-capitalize"><a class="text-decoration-none" :href="'detalle-contrato.php?id='+evento.id">{{evento.nombre}}</a></td>
					<td>{{fechaLatam(evento.fechaEvento)}}</td>
					<td>
						<span v-if="evento.agrupacion==1">SDA</span>
						<span v-if="evento.agrupacion==2">LBLA</span>
					</td>
					<td>S/ {{moneda(evento.total)}}</td>
					<td>
						<button class="btn btn-sm btn-danger" @click="anular(index)" title="Anular contrato"><i class="bi bi-mic-mute"></i></button>
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
			const eventos = ref([])

			onMounted(()=>{
				/* if(!localStorage.getItem('idUsuario')) window.location = 'index.html'
				else{
				} */
				pedirDatos()
			})

			function fechaLatam(fecha){ if(fecha) return moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') }
			function horaLatam(hora){ if(hora) return moment(hora, 'HH:mm').format('hh:mm a') }
			function salto(linea){ if(linea) return linea.replace(/\r/g, '<br>')}
			function moneda(cantidad){ if(cantidad) return parseFloat(cantidad).toFixed(2); else '0.000'; }

			function pedirDatos(){
				var datos = new FormData()
				datos.append('pedir', 'listarTodo')
			
				fetch('./api/Contrato.php', {
					method:'POST', body: datos
				})
				.then( serv => serv.json() )
				.then( resp => { eventos.value = resp })
			}

			return {
				eventos,fechaLatam, horaLatam, salto, moneda
			}
		}
	}).mount('#app')
</script>
</body>
</html>