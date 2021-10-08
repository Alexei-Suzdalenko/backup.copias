<?php
include_once ('Ifsnop/Mysqldump.php');
use Ifsnop\Mysqldump as IMysqldump;

$request = $_GET['data'];
$fecha_actual = date("Y-m-d");
$fecha_request = date("Y-m-d", strtotime($fecha_actual." - 199 days"));

$fileData = date("H-i__d-m-Y");
$filePuth = 'copias/' . $fileData . '__' . $request . '.sql';

switch ($_GET['data']){
    case 'all':                  $query = ['where' => '', 'include' => array(), 'exclude' => array('tarea', 'lineasalidamercancia', 'paletas')]; 
        break;
    case 'lineasalidamercancia': $query = ['where' => "__state != 'completado'", 'include' => array('lineasalidamercancia'),'exclude' => array()];
        break;
    case 'paletas':              $query = ['where' => "__state != 'historico'", 'include' => array('paletas'), 'exclude' => array()];
        break;
    case 'tarea':                $query = ['where' => "created_at > '".$fecha_request."'" , 'include' => array('tarea'), 'exclude' => array()];
        break;
    default: echo 'error url'; die();
} 

if (!file_exists("copias")) { mkdir("copias", 0777, true); }

try {                                      // 
    $dump = new IMysqldump\Mysqldump('mysql:host=;dbname=', '', '', array(), array(), $query);
    $dump->start($filePuth );
} catch (\Exception $e) {
    echo 'ERROR ' . $e->getMessage();
}




// echo '<h1><a href="https://intranet.company_name.net/backup/' . $filePuth . '" target="_blank">' . $filePuth . '</a></h1>';

// https://intranet.company_name.net/backup/?data=all
// https://intranet.company_name.net/backup/?data=lineasalidamercancia
// https://intranet.company_name.net/backup/?data=paletas
// https://intranet.company_name.net/backup/?data=tarea
// https://intranet.company_name.net/backup/createzip.php

// el problema de hora diferente cada vez que, si alguien encuetra la ruta puede crear archivos de backup cada minuto

