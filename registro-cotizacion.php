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
						<p class="fw-bold">Datos de contacto</p>
						<label for="dni">DNI <span class="text-danger">*</span></label>
						<input type="text" id="dni" class="form-control" v-model="cliente.dni" required>

						<label for="nombre">Apellidos y nombres  <span class="text-danger">*</span></label>
						<input type="text" id="nombre" class="form-control" v-model="cliente.nombre" required>

						<label for="celular">Celular <span class="text-danger">*</span></label>
						<input type="text" id="celular" class="form-control" v-model="cliente.celular" required>

						<label for="email">E-mail</label>
						<input type="email" id="email" class="form-control" v-model="cliente.email">
						<label for="direccion">Dirección</label>
						<input type="direccion" id="direccion" class="form-control" v-model="cliente.domicilio">

						<label for="email">Departamento</label>
						<select class="form-select" id="sltDepartamento" v-model="cliente.idDepa" @change="cambioDepartamento">
							<option v-for="departamento in departamentos" :value="departamento.idDepa">{{departamento.departamento}}</option>
						</select>
						<label for="email">Provincia</label>
						<select class="form-select" id="sltProvincia" v-model="cliente.idProv" @change="cambioProvincia">
							<option v-for="provincia in provincias" :value="provincia.idProv">{{provincia.provincia}}</option>
						</select>
						<label for="email">Distrito</label>
						<select class="form-select" id="sltDistrito" v-model="cliente.idDist" >
							<option v-for="distrito in distritos" :value="distrito.idProv">{{distrito.distrito}}</option>
						</select>

						<p class="fw-bold mt-3">Datos de empresa</p>

						<label for="dni">RUC</label>
						<input type="text" id="dni" class="form-control" v-model="cliente.ruc" >

						<label for="nombre">Razón Social</label>
						<input type="text" id="nombre" class="form-control" v-model="cliente.razon" >
					</div>
				</div>

				<p class="fw-bold mt-3">Datos del Evento</p>
				<div class="card">
					<div class="card-body">
						<label for="fechaEvento">Fecha del evento <span class="text-danger">*</span></label>
						<input type="date" id="fechaEvento" class="form-control" v-model="evento.fecha" required>

						<label for="sltArtista">Agrupación <span class="text-danger">*</span></label>
						<select class="form-select" id="sltArtista" v-model="evento.agrupacion" required>
							<option value="-1">Seleccione una agrupación</option>
							<option value="1">Sentimiento del Ande - SDA</option>
							<option value="2">Lobelia - LBLA</option>
                            <option value="3">Luis O</option>
							<option value="4">Zooy</option>
						</select>

						<label for="lugar">Lugar del evento <span class="text-danger">*</span></label>
						<textarea id="lugar" rows="2" class="form-control" v-model="evento.lugar" required></textarea>

						<label for="local">Dirección del local <span class="text-danger">*</span></label>
						<input type="text" id="local" class="form-control" v-model="evento.local" required>

						<label for="duracion">Duración del evento</label>
						<input type="number" id="duracion" class="form-control" min="1" v-model="evento.duracion">

						<label for="sltHorario">Horario</label>
						<select class="form-select" id="sltHorario" v-model="evento.horario">
							<option value="0">Por confirmar</option>
							<option value="1">Confirmado</option>
						</select>

						<div v-if="evento.horario==1">
							<label for="horaInicio">Hora de inicio</label>
							<input type="time" id="horaInicio" class="form-control" v-model="evento.hora">
						</div>

						<label for="sltTipo">Tipo</label>
						<select class="form-select" id="sltTipo" v-model="evento.tipo">
							<option value="0">Público</option>
							<option value="1">Privado</option>
						</select>

						<label for="personas">N° de personas involucradas <span class="text-danger">*</span></label>
						<input type="number" id="personas" class="form-control" min="1" v-model="evento.personas" required>

						<label for="sltHospedaje">¿Se considerará hospedaje?</label>
						<select class="form-select" id="sltHospedaje" v-model="evento.hospedaje">
							<option value="0">No</option>
							<option value="1">Sí</option>
						</select>

						<label for="observaciones">Observaciones</label>
						<textarea id="observaciones" class="form-control" rows="3" v-model="evento.observaciones"></textarea>
					</div>
				</div>

				<p class="fw-bold mt-3">Costos de inversión</p>
				<div class="card">
					<div class="card-body">
						<label for="costoTotal">Costo del show <span class="fw-bold">Sin IGV</span> (S/) <span class="text-danger">*</span></label>
						<input type="number" id="costoTotal" class="form-control" v-model="costo.total" required>

						<div class="d-none">
							<label for="promocion">Promoción (S/)</label>
							<input type="number" id="promocion" class="form-control" v-model="costo.promocion">
							<label for="adelanto">Adelanto del 50% (S/) <span class="text-danger">*</span></label>
							<input type="number" id="adelanto" class="form-control" v-model="costo.adelanto" >
							<label for="fechaAdelanto">Fecha del Adelanto <span class="text-danger">*</span></label>
							<input type="date" id="fechaAdelanto" class="form-control" v-model="costo.fecha" >
						</div>
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
	const { createApp, ref, onMounted } = Vue

	createApp({
		setup() {
			const cliente = ref({ dni:'', nombre: '', celular: '', email: '', ruc:'', razon:'', idDepa:'', idProv:'', idDist:'' })
			const evento = ref({ 
				fecha: moment().format('YYYY-MM-DD'), 
				lugar: '', agrupacion: -1, local: '', duracion: 2, 
				horario: 0, hora: '12:00', 
				observaciones: '', hospedaje:0, personas:1, 
				incluye:'', noIncluye:'', tipo:0 ,
			})
			const costo = ref({ total:0, promocion: 0, adelanto: 0, fecha: moment().format('YYYY-MM-DD') })
			const departamentos = ref([]);
			const provincias = ref([]);
			const distritos = ref([]);
			
			function validarEmail(email) {
				const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
				return re.test(email)
			}

			function confirmar(){
				if( !cliente.value.dni || !cliente.value.nombre || !cliente.value.celular ){ 
					alert('Debe rellenar datos del cliente')
				}
				else if(cliente.value.email && !validarEmail(cliente.value.email)){
					alert('El correo electrónico no es válido')
				}
				else if(!evento.value.fecha || !evento.value.lugar || evento.value.agrupacion==-1 || !evento.value.local || !evento.value.personas){ 
					alert('Debe rellenar los campos obligatorios del evento')
				}
				else if( costo.value.total==0  ){  //|| !costo.value.adelanto || !costo.value.fecha
					alert('Debe rellenar datos obligatorios del pago')
				}
				else if( parseFloat(costo.value.adelanto) > parseFloat(costo.value.total) ){ 
					alert('El adelanto no puede ser mayor que el costo total')
				}
				else crear()
			}

			function crear(){
				// Reemplazar saltos de línea en observaciones antes de enviar
				evento.value.observaciones = evento.value.observaciones.replace(/\n/g, '<br>')

				var datos = new FormData()
				datos.append('pedir', 'crear')
				datos.append('cliente', JSON.stringify(cliente.value))
				datos.append('evento', JSON.stringify(evento.value))
				datos.append('costo', JSON.stringify(costo.value))

				fetch('./api/Cotizacion.php', { // corregido a minúsculas
					method:'POST', body: datos
				})
				.then( serv => serv.text() )
				.then( resp => {
					if( parseInt(resp)>0 ){ 
						alert('✅ Cotización registrada correctamente')
						window.location = 'detalle-cotizacion.php?id='+resp
					}
					else alert('❌ Hubo un error al guardar los datos')
				})
			}

			async function listarDepartamentos(){
				var datos = new FormData()
				datos.append('pedir', 'listarDepartamentos')
				respuesta = await fetch('./api/Ubigeo.php', {
					method: 'POST', body: datos
				})
				departamentos.value = await respuesta.json()
			}
			async function cambioDepartamento(){
				cliente.value.idProv = ''; cliente.value.idDist = '';
				provincias.value=[]; distritos.value = [];
				if(!cliente.value.idDepa) return false

				var datos = new FormData()
				datos.append('pedir', 'listarProvincias')
				datos.append('idDepa', cliente.value.idDepa)
				respuesta = await fetch('./api/Ubigeo.php', {
					method: 'POST', body: datos
				})
				provincias.value = await respuesta.json()
			}
			
			async function cambioProvincia(){
				cliente.value.idDist = '';
				distritos.value = [];
				if(!cliente.value.idProv) return false

				var datos = new FormData()
				datos.append('pedir', 'listarDistritos')
				datos.append('idProv', cliente.value.idProv)
				respuesta = await fetch('./api/Ubigeo.php', {
					method: 'POST', body: datos
				})
				distritos.value = await respuesta.json()
			}

			onMounted(() => {
				listarDepartamentos();
			})

			return {
				cliente, evento, costo,
				crear, confirmar,
				departamentos, provincias,distritos,
				cambioDepartamento, cambioProvincia
			}
		}
	}).mount('#app')
</script>
</body>
</html>