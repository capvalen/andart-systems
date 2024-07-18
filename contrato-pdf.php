<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('vendor/autoload.php');

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

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

	$nombreDueño = "ANDERSON GARCIA HUALLULLO";
	$dniDueño = "45148533";
	$nombreCliente = "GERONIMO YAURI JOSE MIGUEL";
	$dniCliente = "44475064";
	$celularCliente = "96000000";
	$correoCliente = "96000000";
	$domicilioCliente= "JR BUENOS AMIGOS 290 – ATE, LIMA";
	$local = "LA CABAÑA DE JERONIMO - SATIPO";
	$fechaEvento = "16/JUNIO/2024";
	$personas="4";
	$agrupacion = "Sentimiento del Ande";
	$tiempoEvento = "2 horas";
	$horarioCompleto = "2PM - 4PM";
	$total = "3500";
	$adelanto = "1800";
	$restante = "1700";
	$fechaAdelanto = "29 de Mayo del 2024";

	ob_start();
	include "plantilla.php";
	$html = ob_get_clean();
	return $html;
}