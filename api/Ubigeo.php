<?php
error_reporting(E_ALL); ini_set("display_errors", 1);	

include 'conectkarl.php';

switch ($_POST['pedir']) {
	case 'listarDepartamentos': listarDepartamentos($datab); break;
	case 'listarProvincias': listarProvincias($datab); break;
	case 'listarDistritos': listarDistritos($datab); break;
}

function listarDepartamentos($db){
	$filas =[];
	$sql = $db->prepare("SELECT * FROM ubdepartamento;");
	$sql->execute( );
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
		$filas[] = $row;

	echo json_encode($filas);
}
function listarProvincias($db){
	$filas =[];
	$sql = $db->prepare("SELECT * FROM ubprovincia where idDepa = ?;");
	$sql->execute([ $_POST['idDepa'] ]);
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
		$filas[] = $row;

	echo json_encode($filas);
}
function listarDistritos($db){
	$filas =[];
	$sql = $db->prepare("SELECT * FROM ubdistrito where idProv = ?;");
	$sql->execute([ $_POST['idProv'] ]);
	while($row = $sql->fetch(PDO::FETCH_ASSOC))
		$filas[] = $row;

	echo json_encode($filas);
}