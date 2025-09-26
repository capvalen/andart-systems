<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include 'conectkarl.php';

switch ($_POST['pedir']) {
	case 'crear': crear($datab); break;
	case 'listar': listar($datab); break;
	case 'listarTodo': listarTodo($datab); break;
	case 'filtrar': filtrar($datab); break;
	case 'actualizar': actualizar($datab); break;
	case 'eliminar': eliminar($datab); break;
	default: break;
}

function listar($db){
	$sql=$db->prepare("SELECT *, LPAD(id, 3, '0') AS idFormateado, 
		case agrupacion when 1 then 'Sentimiento del Ande' when 2 then 'Lobelia' end as nombreAgrupacion, 
		date_format(registro,'%Y-%m-%d') as diaRegistro
	FROM `cotizacion` 
	where id=? and cotizacion=2;");
	$sql->execute([ $_POST['id']]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);

	$sqlCli = $db->prepare("SELECT c.*, d.departamento, p.provincia, di.distrito from cliente c
		left join ubdepartamento d on d.idDepa = c.idDepa
		left join ubprovincia p on p.idProv = c.idProv
		left join ubdistrito di on di.idDist = c.idDist
		where c.id =  ?;");
	$sqlCli -> execute([ $row['idCliente'] ]);
	$rowCli = $sqlCli->fetch(PDO::FETCH_ASSOC);
	
	echo json_encode(array(
		'cliente' => $rowCli,
		'evento'=> $row,
		'costo' => $row
	));
}

function listarTodo($db){
	$filas = [];
	$sql=$db->prepare("SELECT c.*, cl.`dni`, cl.`nombre`, cl.`celular`, cl.`email`, 
		LPAD(c.id, 3, '0') AS idFormateado 
	FROM `cotizacion` c 
	inner join cliente cl on cl.id = c.idCliente
	where c.activo=1 and cotizacion=2 
	ORDER BY c.fechaEvento DESC 
	LIMIT 50;");
	$sql->execute();
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
		$filas [] = $row;

	echo json_encode($filas);
}

/**
 * Filtrar contratos por mes, año, agrupación y por cliente (nombre o dni).
 * Retorna hasta 50 resultados.
 */
function filtrar($db){
	// obtener parámetros con tolerancia a nombres 'anio' / 'año'
	$mes = isset($_POST['mes']) ? intval($_POST['mes']) : -1;
	$anio = null;
	if (isset($_POST['anio'])) $anio = intval($_POST['anio']);
	elseif (isset($_POST['año'])) $anio = intval($_POST['año']);
	$agrupacion = isset($_POST['agrupacion']) ? intval($_POST['agrupacion']) : -1;
	$cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';

	$where = ["c.activo=1", "c.cotizacion=2"];
	$params = [];

	if ($mes != -1) {
		$where[] = "MONTH(c.fechaEvento) = ?";
		$params[] = $mes;
	}
	if ($anio !== null && $anio != -1) {
		$where[] = "YEAR(c.fechaEvento) = ?";
		$params[] = $anio;
	}
	if ($agrupacion != -1) {
		$where[] = "c.agrupacion = ?";
		$params[] = $agrupacion;
	}
	if ($cliente !== '') {
		// buscar por nombre parcial o dni parcial
		$where[] = "(cl.nombre LIKE ? OR cl.dni LIKE ?)";
		$params[] = "%$cliente%";
		$params[] = "%$cliente%";
	}

	// construir consulta
	$sql = "SELECT c.*, cl.`dni`, cl.`nombre`, cl.`celular`, cl.`email`,
		LPAD(c.id, 3, '0') AS idFormateado
		FROM `cotizacion` c
		INNER JOIN cliente cl ON cl.id = c.idCliente
		WHERE " . implode(" AND ", $where) . "
		ORDER BY c.fechaEvento DESC
		LIMIT 50";

	$stmt = $db->prepare($sql);
	$stmt->execute($params);

	$filas = [];
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		$filas [] = $row;

	echo json_encode($filas);
}

function crear($db){
	$cliente = json_decode($_POST['cliente'], true);
	$sqlCliente= $db->prepare("INSERT INTO `cliente`(`dni`, `nombre`, `celular`, `email`, `registro`) 
		VALUES (?,?,?,?, CONVERT_TZ(NOW(), @@session.time_zone, '-05:00') );");
	$sqlCliente->execute([
		$cliente['dni'],$cliente['nombre'],$cliente['celular'],$cliente['email']
	]);
	$idCliente = $db->lastInsertId();
	
	$evento = json_decode($_POST['evento'], true);
	$costo = json_decode($_POST['costo'], true);
	$sql = $db->prepare("INSERT INTO `cotizacion`(`idCliente`, `fechaEvento`, `lugar`, `agrupacion`, `local`,
		`duracion`, `horario`, `hora`, `observaciones`, `tipo`,
		`total`,`promocion`, `adelanto`, `fechaAdelanto`, registro,
		`personas`, `hospedaje`
	) VALUES (
		?,?,?,?,?,
		?,?,?,?,?,
		?,?,?,?, CONVERT_TZ(NOW(), @@session.time_zone, '-05:00'),
		?,?
	)");
	$sql->execute([
		$idCliente, $evento['fecha'], $evento['lugar'], $evento['agrupacion'], $evento['local'], 
		$evento['duracion'], $evento['horario'], $evento['hora'], $evento['observaciones'], $evento['tipo'],
		$costo['total'], $costo['promocion'], $costo['adelanto'], $costo['fecha'],
		$evento['personas'], $evento['hospedaje']
	]);

	$idEvento = $db->lastInsertId();
	echo $idEvento;
}

function actualizar($db){
	$evento = json_decode($_POST['evento'], true);
	$sql=$db->prepare("UPDATE `cotizacion` SET 
		estado = ?, horario = ?, hora = ?, duracion = ?, lugar=?,
		`local`=?, personas=?, fechaContestacion=?
	where id = ?; ");
	if($sql->execute([
		$evento['estado'], $evento['horario'], $evento['hora'], $evento['duracion'], $evento['lugar'],
		$evento['local'], $evento['personas'], $evento['fechaContestacion'],
		$_POST['id']
	])){
		echo 'ok';
	}else echo 'error';
}

function eliminar($db){
	$sql=$db->prepare("UPDATE `cotizacion` SET activo = 0 where id = ?; ");
	if($sql->execute([ $_POST['id'] ])){
		echo 'ok';
	}else echo 'error';
}
?>