<?php
error_reporting(E_ALL); ini_set("display_errors", 1);	

include 'conectkarl.php';

switch ($_POST['pedir']) {
	case 'crear': crear($datab); break;
	case 'listar': listar($datab); break;
	case 'listarTodo': listarTodo($datab); break;
	case 'actualizar': actualizar($datab); break;
	case 'updateCliente': updateCliente($datab); break;
	case 'eliminar': eliminar($datab); break;
	case 'crearContrato': crearContrato($datab); break;
	default: break;
}

function listar($db){
	$sql=$db->prepare("SELECT *, LPAD(id, 3, '0') AS idFormateado, case agrupacion when 1 then 'Sentimiento del Ande' when 2 then 'Lobelia' end as nombreAgrupacion, date_format(registro,'%Y-%m-%d') as diaRegistro
	FROM `cotizacion` where id=? ;"); //and cotizacion=1
	$sql->execute([ $_POST['id']]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);

	$sqlCli = $db->prepare("SELECT * from cliente where id = ?;");
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
	$sql=$db->prepare("SELECT c.*, `dni`, `nombre`, `celular`, `email`, LPAD(c.id, 3, '0') AS idFormateado FROM 
	`cotizacion` c 
	inner join cliente cl on cl.id = c.idCliente
	where c.activo=1 and cotizacion=1;");
	$sql->execute();
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
		$filas [] = $row;

	echo json_encode($filas);
}
function crear($db){
	$cliente = json_decode($_POST['cliente'], true);
	$sqlCliente= $db->prepare("INSERT INTO `cliente`(`dni`, `nombre`, `celular`, `email`, `registro`) VALUES (?,?,?,?,
	 CONVERT_TZ(NOW(), @@session.time_zone, '-05:00') );");
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
		$evento['duracion'], $evento['horario'], $evento['hora'], $evento['observaciones'], $evento['tipo']
		, $costo['total'], $costo['promocion'], $costo['adelanto'], $costo['fecha'],
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
function crearContrato($db){
	$sql=$db->prepare("UPDATE `cotizacion` SET 
	cotizacion=2
	where id = ?; ");
	if($sql->execute([
		$_POST['id']
	])){
		echo 'ok';
	}else echo 'error';
}
function updateCliente($db){
	$cliente = json_decode($_POST['cliente'], true);
	$sql=$db->prepare("UPDATE `cliente` SET 
	domicilio = ?, celular = ?, email = ?
	where id = ?; ");
	if($sql->execute([
		$cliente['domicilio'], $cliente['celular'], $cliente['email'], 
		$cliente['id']
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