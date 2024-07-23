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
		<div class="card my-3">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<label for=""><i class="bi bi-funnel"></i> Mes</label>
						<select class="form-select" id="sltMes" v-model="filtro.mes">
							<option value="-1">Todos</option>
							<option value="1">Enero</option>
							<option value="2">Febrero</option>
							<option value="3">Marzo</option>
							<option value="4">Abril</option>
							<option value="5">Mayo</option>
							<option value="6">Junio</option>
							<option value="7">Julio</option>
							<option value="8">Agosto</option>
							<option value="9">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
					</div>
					<div class="col">
						<label for=""><i class="bi bi-funnel"></i> Año</label>
						<select class="form-select" id="sltAño" v-model="filtro.año">
							<option value="-1">Todos</option>
							<option v-for="año in años" :value="año">{{año}}</option>
						</select>
					</div>
					<div class="col">
						<label for=""><i class="bi bi-funnel"></i> Agrupación</label>
						<select class="form-select" id="sltAgrupacion" v-model="filtro.agrupacion">
							<option value="-1">Todos</option>
							<option value="1">SDA</option>
							<option value="2">LBLA</option>
						</select>
					</div>
					<div class="col">
						<label for=""><i class="bi bi-funnel"></i> Contestación</label>
						<select class="form-select" id="sltAgrupacion" v-model="filtro.agrupacion">
							<option value="-1">Todos</option>
							<option value="1">Pendiente</option>
							<option value="2">Con respuesta</option>
						</select>
					</div>
					<div class="col d-grid d-flex align-items-end">
						<button class="btn btn-outline-primary"><i class="bi bi-funnel"></i> Filtrar</button>
					</div>
				</div>
			</div>
		</div>
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
			const años =ref([])
			const filtro = ref({
				mes:-1, año:-1, agrupacion:-1
			})

			onMounted(()=>{ 
				if(!localStorage.getItem('idUsuario')) window.location = 'index.html'
					else{
						pedirDatos()
					}
			 })

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
				fechaLatam, horaLatam, salto, moneda,
				años, filtro
			}
		}
	}).mount('#app')
</script>
</body>
</html>