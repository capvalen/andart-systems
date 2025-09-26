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
						<label><i class="bi bi-funnel"></i> Mes</label> 
						<select class="form-select" v-model="filtro.mes"> 
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
						<label><i class="bi bi-funnel"></i> Año</label> 
						<select class="form-select" v-model="filtro.año"> 
							<option value="-1">Todos</option> 
							<option v-for="año in años" :value="año">{{año}}</option>
						</select> 
					</div> 

					<div class="col"> 
						<label><i class="bi bi-funnel"></i> Agrupación</label> 
						<select class="form-select" v-model="filtro.agrupacion"> 
							<option value="-1">Todos</option> 
							<option value="1">SDA</option> 
							<option value="2">LBLA</option> 
                            <option value="3">LUIS O</option> 
    						<option value="4">ZOOY</option>
						</select> 
					</div> 

					<div class="col"> 
						<label><i class="bi bi-funnel"></i> Contestación</label> 
						<select class="form-select" v-model="filtro.contestacion"> 
							<option value="-1">Todos</option> 
							<option value="0">Pendiente</option> 
							<option value="1">Contestada</option> 
						</select> 
					</div> 

					<div class="col"> 
						<label><i class="bi bi-funnel"></i> Estado</label> 
						<select class="form-select" v-model="filtro.estado"> 
							<option value="-1">Todos</option> 
							<option value="0">Creado</option> 
							<option value="2">Anulada</option> 
						</select> 
					</div> 

					<div class="col d-grid d-flex align-items-end"> 
						<button class="btn btn-outline-primary" @click="aplicarFiltro"><i class="bi bi-funnel"></i> Filtrar</button> 
                        <button class="btn btn-outline-secondary" @click="limpiarFiltro"><i class="bi bi-x-circle"></i> Limpiar</button> 
					</div> 
				</div> 
			</div> 
		</div>

		<div class="col-12 mx-auto d-grid d-flex justify-content-end my-2">
			<a class="btn btn-outline-primary" href="registro-cotizacion.php"><i class="bi bi-asterisk"></i> Crear nueva cotización</a>
		</div>

		<p>Se muestran las últimas cotizaciones pendientes:</p>

		<!-- mensaje si no hay resultados -->
		<div v-if="eventos.length === 0" class="alert alert-light text-center">
			No se encontraron cotizaciones
		</div>

		<table class="table table-hover"> 
			<thead> 
				<th>N°</th> 
				<th>Cliente</th> 
				<th>Fecha del evento</th> 
				<th>Agrupación</th> 
				<th>Total</th> 
				<th>Contestación</th> 
				<th>Estado</th>
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
                        <span v-if="evento.agrupacion==3">LUIS O</span> 
  						<span v-if="evento.agrupacion==4">ZOOY</span>
					</td> 
					<td>S/ {{moneda(evento.total)}}</td> 
					<td> 
						<span v-if="evento.fechaContestacion">{{fechaLatam(evento.fechaContestacion)}}</span> 
						<span v-else>Pendiente</span> 
					</td> 
					<td>
						<span v-if="evento.estado==0">Creado</span>
						<span v-if="evento.estado==2">Anulada</span>
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
	// Vue 3 setup (composición)
	const { createApp, ref, onMounted } = Vue

	createApp({
	  setup() {
		const eventos = ref([])
		const años = ref([])
		const filtro = ref({
		  mes: -1,
		  año: -1,
		  agrupacion: -1,
		  contestacion: -1,
		  estado: -1
		})

		onMounted(() => {
		  // carga inicial de datos y años
		  pedirDatos()
		  const currentYear = new Date().getFullYear()
		  for (let year = 2024; year <= currentYear; year++) años.value.push(year)
		})

		function fechaLatam(fecha) { if (fecha) return moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') }
		function moneda(cantidad) { if (cantidad) return parseFloat(cantidad).toFixed(2); else return '0.00'; }

		// obtiene últimos 50 cotizaciones
		async function pedirDatos(){
		  try {
			const datos = new FormData()
			datos.append('pedir', 'listarTodo')

			console.debug('[Cotizaciones] pedirDatos -> listarTodo')
			const res = await fetch('./api/Cotizacion.php', { method: 'POST', body: datos, cache: 'no-store' })
			if (!res.ok) throw new Error('HTTP ' + res.status)
			const json = await res.json()
			console.debug('[Cotizaciones] listarTodo respuesta', json)
			eventos.value = json || []
		  } catch (err) {
			console.error('Error en pedirDatos():', err)
			eventos.value = []
		  }
		}

		// aplicar filtros (consulta backend)
		async function aplicarFiltro(){
		  try {
			// si no hay filtros activos, solo recargar últimos
			if (
			  filtro.value.mes == -1 &&
			  filtro.value.año == -1 &&
			  filtro.value.agrupacion == -1 &&
			  filtro.value.contestacion == -1 &&
			  filtro.value.estado == -1
			) {
			  pedirDatos()
			  return
			}

			const datos = new FormData()
			datos.append('pedir', 'filtrar')
			datos.append('mes', String(filtro.value.mes))
			datos.append('anio', String(filtro.value.año))   
			datos.append('año', String(filtro.value.año))    
			datos.append('agrupacion', String(filtro.value.agrupacion))
			datos.append('contestacion', String(filtro.value.contestacion))
			datos.append('estado', String(filtro.value.estado))

			console.debug('[Cotizaciones] aplicarFiltro payload', {
			  mes: filtro.value.mes,
			  año: filtro.value.año,
			  agrupacion: filtro.value.agrupacion,
			  contestacion: filtro.value.contestacion,
			  estado: filtro.value.estado
			})

			const res = await fetch('./api/Cotizacion.php', { method: 'POST', body: datos, cache: 'no-store' })
			if (!res.ok) throw new Error('HTTP ' + res.status)
			const json = await res.json()
			console.debug('[Cotizaciones] filtrar respuesta', json)
			eventos.value = json || []
		  } catch (err) {
			console.error('Error en aplicarFiltro():', err)
		  }
		}

		function limpiarFiltro(){
		  filtro.value = { mes:-1, año:-1, agrupacion:-1, contestacion:-1, estado:-1 }
		  pedirDatos()
		}

		function eliminar(i){
		  if (confirm('¿Seguro que quieres eliminar esta cotización?')) {
			eventos.value.splice(i,1)
		  }
		}

		return {
		  eventos, fechaLatam, moneda,
		  años, filtro, aplicarFiltro, limpiarFiltro, eliminar
		}
	  }
	}).mount('#app')
	</script>
</body>
</html>