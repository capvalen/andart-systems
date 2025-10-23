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
    case 'filtrar': filtrar($datab); break;
	default: break;
}

function listar($db){
	$sql=$db->prepare("SELECT *, LPAD(id, 3, '0') AS idFormateado, case agrupacion when 1 then 'Sentimiento del Ande' when 2 then 'Lobelia' end as nombreAgrupacion, date_format(registro,'%Y-%m-%d') as diaRegistro
	FROM `cotizacion` where id=? ;"); //and cotizacion=1
	$sql->execute([ $_POST['id']]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);

	$sqlCli = $db->prepare("SELECT c.*, d.departamento, p.provincia, di.distrito from cliente c
		left join ubdepartamento d on d.idDepa = c.idDepa
		left join ubprovincia p on p.idProv = c.idProv
		left join ubdistrito di on di.idDist = c.idDist
		where c.id = ?;");

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

	$sql = $db->prepare("SELECT c.*, cl.dni, cl.nombre, cl.celular, cl.email, cl.ruc, cl.razon,
							LPAD(c.id, 3, '0') AS idFormateado,
							CASE c.agrupacion
									WHEN 1 THEN 'Sentimiento del Ande'
									WHEN 2 THEN 'Lobelia'
									WHEN 3 THEN 'LUIS O'
									WHEN 4 THEN 'ZOOY'
							END AS nombreAgrupacion
			FROM cotizacion c
			INNER JOIN cliente cl ON cl.id = c.idCliente
			WHERE c.activo = 1 AND c.cotizacion = 1
			ORDER BY c.fechaEvento DESC
			LIMIT 50
	");
	$sql->execute();

	while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
			$filas[] = $row;
	}

	echo json_encode($filas);
   
}

function filtrar($db){
    try {
        $condiciones = ["c.activo = 1", "c.cotizacion = 1"];
        $params = [];

        // mes
        if (isset($_POST['mes']) && $_POST['mes'] != -1) {
            $condiciones[] = "MONTH(c.fechaEvento) = ?";
            $params[] = intval($_POST['mes']);
        }

        // año (apoya 'anio' o 'año')
        $anio = null;
        if (isset($_POST['anio']) && $_POST['anio'] != -1) $anio = intval($_POST['anio']);
        if ((isset($_POST['año']) && $_POST['año'] != -1)) $anio = intval($_POST['año']);
        if ($anio !== null) {
            $condiciones[] = "YEAR(c.fechaEvento) = ?";
            $params[] = $anio;
        }

        // agrupacion
        if (isset($_POST['agrupacion']) && $_POST['agrupacion'] != -1) {
            $condiciones[] = "c.agrupacion = ?";
            $params[] = intval($_POST['agrupacion']);
        }

        // contestacion: 0 = pendiente (fechaContestacion NULL/''), 1 = contestada (tiene fecha)
        if (isset($_POST['contestacion']) && $_POST['contestacion'] != -1) {
            if (intval($_POST['contestacion']) === 0) {
                $condiciones[] = "(c.fechaContestacion IS NULL OR c.fechaContestacion = '')";
            } else {
                $condiciones[] = "(c.fechaContestacion IS NOT NULL AND c.fechaContestacion <> '')";
            }
        }

        // estado (0 = Creado, 2 = Anulada)
        if (isset($_POST['estado']) && $_POST['estado'] != -1) {
            $condiciones[] = "c.estado = ?";
            $params[] = intval($_POST['estado']);
        }

        // cliente (opcional, búsqueda por nombre o dni)
        if (isset($_POST['cliente']) && trim($_POST['cliente']) !== '') {
            $cliente = '%' . trim($_POST['cliente']) . '%';
            $condiciones[] = "(cl.nombre LIKE ? OR cl.dni LIKE ?)";
            $params[] = $cliente;
            $params[] = $cliente;
        }

        $where = implode(" AND ", $condiciones);

        $sql = $db->prepare("
            SELECT c.*, cl.dni, cl.nombre, cl.celular, cl.email,
                   LPAD(c.id, 3, '0') AS idFormateado,
                   CASE c.agrupacion
                       WHEN 1 THEN 'Sentimiento del Ande'
                       WHEN 2 THEN 'Lobelia'
                       WHEN 3 THEN 'LUIS O'
                       WHEN 4 THEN 'ZOOY'
                   END AS nombreAgrupacion
            FROM cotizacion c
            INNER JOIN cliente cl ON cl.id = c.idCliente
            WHERE $where
            ORDER BY c.fechaEvento DESC
            LIMIT 100
        ");

        $sql->execute($params);

        $filas = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filas[] = $row;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($filas);
    } catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'filtrar error: ' . $e->getMessage()]);
    }
}

function crear($db){
	$cliente = json_decode($_POST['cliente'], true);
	$sqlCliente= $db->prepare("INSERT INTO `cliente`(`dni`, `nombre`, `celular`, `email`, `registro`,
	ruc, razon, idDepa, idProv, idDist,
	domicilio
	) VALUES (?,?,?,?,CONVERT_TZ(NOW(), @@session.time_zone, '-05:00'),
	?,?,?,?,?,
	?);");
	$sqlCliente->execute([
		$cliente['dni'],$cliente['nombre'],$cliente['celular'],$cliente['email'],
		$cliente['ruc'], $cliente['razon'], $cliente['idDepa'], $cliente['idProv'], $cliente['idDist'],
		$cliente['domicilio']
	]);
	$idCliente = $db->lastInsertId();
	
	$evento = json_decode($_POST['evento'], true);
	$costo = json_decode($_POST['costo'], true);
	$sql = $db->prepare("INSERT INTO `cotizacion`(`idCliente`, `fechaEvento`, `lugar`, `agrupacion`, `local`,
	`duracion`, `horario`, `hora`, `observaciones`, `tipo`,
	`total`,`promocion`, `adelanto`,  registro,
	`personas`, `hospedaje`
	) VALUES (
		?,?,?,?,?,
		?,?,?,?,?,
		?,?,?, CONVERT_TZ(NOW(), @@session.time_zone, '-05:00'),
		?,?
	)");
	$sql->execute([
		$idCliente, $evento['fecha'], $evento['lugar'], $evento['agrupacion'], $evento['local'], 
		$evento['duracion'], $evento['horario'], $evento['hora'], $evento['observaciones'], $evento['tipo']
		, $costo['total'], $costo['promocion'], $costo['adelanto'],
		$evento['personas'], $evento['hospedaje']
	]);

	$idEvento = $db->lastInsertId();
	echo $idEvento;
}
function actualizar($db){
	$evento = json_decode($_POST['evento'], true);
	$sql=$db->prepare("UPDATE `cotizacion` SET 
	estado = ?, horario = ?, hora = ?, duracion = ?, lugar=?,
	`local`=?, personas=?, fechaContestacion=?, promocion = ?, adelanto = ?,
	fechaAdelanto = ?, total = ?, igv=?
	where id = ?; ");
	if($sql->execute([
		$evento['estado'], $evento['horario'], $evento['hora'], $evento['duracion'], $evento['lugar'],
		$evento['local'], $evento['personas'], $evento['fechaContestacion'], $evento['promocion'], $evento['adelanto'],
		$evento['fechaAdelanto'], $evento['total'],$evento['igv'],
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
	domicilio = ?, celular = ?, email = ?,
	ruc = ?, razon = ?, idDepa = ?, idProv = ?, idDist = ?
	where id = ?; ");
	if($sql->execute([
		$cliente['domicilio'], $cliente['celular'], $cliente['email'], 
		$cliente['ruc'], $cliente['razon'], $cliente['idDepa'], $cliente['idProv'], $cliente['idDist'],
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