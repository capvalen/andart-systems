<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('vendor/autoload.php');

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
$numero = $_GET['id'];

$html = datosContrato();


$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helverica');
$dompdf = new Dompdf($options);

// Registrar la fuente
$fontDir = __DIR__ . '/fonts';
$fontMetrics = $dompdf->getFontMetrics();
$fontMetrics->get_font('Helverica', 'normal', true);

$numero = $_GET['id'];
$numContrato = sprintf('%04d', $numero);


$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("Contrato-Andart-N-{$numContrato}.pdf", ['Attachment' => false]);


function datosContrato(){
	$numero = $_GET['id'];

	ob_start();
	$_POST['pedir'] = 'listar';
	$_POST['id'] = $numero;
	include __DIR__.'/api/Contrato.php';
	$datos = json_decode(ob_get_contents(), true);
	ob_end_clean();

	$nombreDueño = "ANDERSON GARCIA HUALLULLO";
	$dniDueño = "45148533";


	$nombreCliente = ucwords($datos['cliente']['nombre']);
	$dniCliente = $datos['cliente']['dni'];
	$celularCliente = $datos['cliente']['celular'];
	$correoCliente = $datos['cliente']['email'];
	$domicilioCliente= ucwords($datos['cliente']['domicilio']);

	$local = ucwords($datos['evento']['local']);
	$fechaEvento = fechaLatam($datos['evento']['fechaEvento']);
	$personas= $datos['evento']['personas'];
	$agrupacion = $datos['evento']['nombreAgrupacion'];
	$tipoEvento = $datos['evento']['tipo'] ==0 ? 'Público' : 'Privado';
	$tiempoEvento = $datos['evento']['duracion'];
	if($datos['evento']['horario'] ==0 ) $horarioInicio = 'Por confirmar';
	else{
		$dateTime  =  DateTime::createFromFormat('H:i:s', $datos['evento']['hora']);
		$horarioInicio = $dateTime->format('g:i a');
	}
	$observaciones = $datos['evento']['observaciones'];
	$hospedaje = $datos['evento']['hospedaje'] ==1 ? true : false;
	$total = $datos['costo']['total'];
	$promocion = $datos['costo']['promocion'];
	$adelanto = $datos['costo']['adelanto'];
	$restante = $datos['costo']['total'] - $datos['costo']['adelanto'];
	if( $datos['evento']['fechaAdelanto'] ) $fechaAdelanto = fechaLatam($datos['evento']['fechaAdelanto']);
	else $fechaAdelanto = 'Pendiente';

	//Falta
	$horarioCompleto = "2PM - 4PM";

	ob_start();
	include "plantilla-contrato.php";
	$html = ob_get_clean();
	return $html;
}

function fechaLatam($fecha) {
	//echo 'la fecha ' . $fecha;
	// Crea un objeto DateTime con la fecha en formato YYYY-MM-DD
	$dateTime = DateTime::createFromFormat('Y-m-d', $fecha);

	// Array para mapear los meses en español
	$meses = [
			1 => 'enero', 
			2 => 'febrero', 
			3 => 'marzo', 
			4 => 'abril', 
			5 => 'mayo', 
			6 => 'junio', 
			7 => 'julio', 
			8 => 'agosto', 
			9 => 'septiembre', 
			10 => 'octubre', 
			11 => 'noviembre', 
			12 => 'diciembre'
	];

	// Extrae el día, mes y año
	$dia = $dateTime->format('d');
	$mes = $meses[(int)$dateTime->format('m')];
	$año = $dateTime->format('Y');

	// Formatea la fecha en el formato deseado
	return "$dia de $mes de $año";
}