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
							<option value="4">ZOOEY</option>
						</select>
					</div>
                    <div class="col">
						<label><i class="bi bi-person"></i> Cliente</label>
						<input type="text" class="form-control" v-model="filtro.cliente" placeholder="Nombre o DNI">
					</div>
					<div class="col d-grid d-flex align-items-end">
						<button class="btn btn-outline-primary me-2" @click="aplicarFiltro">
							<i class="bi bi-funnel"></i> Filtrar
						</button>
						<button class="btn btn-outline-secondary" @click="limpiarFiltro">
							<i class="bi bi-x-circle"></i> Limpiar
						</button>
					</div>                 
				</div>
			</div>
		</div>
		<p>A continuación se muestran los 50 últimos contratos</p>
		<table class="table table-hover">
			<thead>
				<th>N°</th>
				<th>Cliente</th>
                <th>Celular</th> <!-- Nueva columna -->
				<th>Fecha del evento</th>
                <th>Agrupación</th>
				<th>Total</th>
				<th>@</th>
			</thead>
			<tbody>
				<tr v-for="(evento, index) in eventos" :key="evento.id">
					<td>{{index+1}}</td>
					<td class="text-capitalize">
						<a class="text-decoration-none" :href="'detalle-contrato.php?id='+evento.id">{{evento.nombre}}</a>
					</td>
					<td>{{evento.celular}}</td> <!-- Mostrar celular -->
                    <td>{{fechaLatam(evento.fechaEvento)}}</td>
					<td>
						<span v-if="evento.agrupacion==1">SDA</span>
						<span v-else-if="evento.agrupacion==2">LBLA</span>
						<span v-else-if="evento.agrupacion==3">LUIS O</span>
						<span v-else-if="evento.agrupacion==4">ZOOEY</span>
						<span v-else>Otro</span>
					</td>
					<td>S/ {{moneda(evento.total)}}</td>
					<td>
						<button class="btn btn-sm btn-danger" @click="anular(index)" title="Anular contrato">
							<i class="bi bi-mic-mute"></i>
						</button>
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
    const años = ref([])
    const filtro = ref({
      mes: -1,
      año: -1,
      agrupacion: -1,
      cliente: ''   // 👈 agregado y con coma correcta
    })

    onMounted(() => {
      if (!localStorage.getItem('idUsuario')) {
        window.location = 'index.html'
        return
      }
      // carga inicial
      pedirDatos()

      // rellenar años dinámicamente
      const currentYear = new Date().getFullYear()
      for (let year = 2024; year <= currentYear; year++) {
        años.value.push(year)
      }
    })

    // --- Helpers ---
    function fechaLatam(fecha) { if (fecha) return moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') }
    function horaLatam(hora) { if (hora) return moment(hora, 'HH:mm').format('hh:mm a') }
    function salto(linea) { if (linea) return linea.replace(/\r/g, '<br>') }
    function moneda(cantidad) { if (cantidad) return parseFloat(cantidad).toFixed(2); else return '0.00'; }

    // --- Pedir contratos (últimos 50) ---
    async function pedirDatos() {
      try {
        const datos = new FormData()
        datos.append('pedir', 'listarTodo')

        console.debug('[pedirDatos] Enviando listarTodo...')
        const res = await fetch('./api/Contrato.php', { method: 'POST', body: datos, cache: 'no-store' })
        if (!res.ok) throw new Error('HTTP ' + res.status)
        const json = await res.json()
        console.debug('[pedirDatos] respuesta:', json)
        eventos.value = json
      } catch (err) {
        console.error('Error en pedirDatos():', err)
        eventos.value = []
      }
    }

    // --- Aplicar filtros ---
    async function aplicarFiltro() {
      try {
        // si no hay filtros, mostramos últimos contratos
        if (
          filtro.value.mes == -1 &&
          filtro.value.año == -1 &&
          filtro.value.agrupacion == -1 &&
          filtro.value.cliente.trim() === ''
        ) {
          pedirDatos()
          return
        }

        const datos = new FormData()
        datos.append('pedir', 'filtrar')
        datos.append('mes', String(filtro.value.mes))
        datos.append('anio', String(filtro.value['año']))
        datos.append('año', String(filtro.value['año']))
        datos.append('agrupacion', String(filtro.value.agrupacion))
        datos.append('cliente', String(filtro.value.cliente).trim()) // 👈 nuevo

        console.debug('[aplicarFiltro] payload:', {
          mes: filtro.value.mes,
          anio: filtro.value['año'],
          agrupacion: filtro.value.agrupacion,
          cliente: filtro.value.cliente
        })

        const res = await fetch('./api/Contrato.php', { method: 'POST', body: datos, cache: 'no-store' })
        if (!res.ok) throw new Error('HTTP ' + res.status)

        const json = await res.json()
        console.debug('[aplicarFiltro] respuesta:', json)
        eventos.value = json
      } catch (err) {
        console.error('Error en aplicarFiltro():', err)
      }
    }

    // --- Limpiar filtros ---
    function limpiarFiltro() {
      filtro.value = { mes: -1, año: -1, agrupacion: -1, cliente: '' } // 👈 ahora incluye cliente
      pedirDatos()
    }

    function anular(i) {
      if (confirm('¿Seguro que quieres anular este contrato?')) {
        eventos.value.splice(i, 1)
      }
    }

    return {
      eventos, fechaLatam, horaLatam, salto, moneda,
      años, filtro, aplicarFiltro, limpiarFiltro, anular
    }
  }
}).mount('#app')
</script>
</body>
</html>