<?php @session_start();
$_SESSION['html'] = null;
$_SESSION['title'] = null;
$content = null;
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../api/callapi.php";
include('../../../includes.php');
include('../../Extras.php');
include_once "../pagination.php";

$extras = new Extras();

// $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
// $itensPorPagina = !empty($_GET['per_page']) ? (int)$_GET['per_page'] : 10;


$response = callapi($mainUrl . "funcionario/".$_GET['id'], "GET");
echo json_encode($response[0]);