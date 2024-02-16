<?php
@session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../includes.php';
include_once '../../api/callapi.php';


$data = [
        "id_funcionario"=>$_POST['id']
        // "action"=> $_POST['action']
];

// print_r($data);
if($_POST['action'] == 'chegada'){
        $json = callapi($mainUrl . "presenca", "POST", $data);
}

if($_POST['action'] == 'saida'){
        $json = callapi($mainUrl . "presenca", "PUT", $data);
}

if($_POST['action'] == 'ausencia'){
        $json = callapi($mainUrl . "ausencia", "POST");
}

// print_r($json);
echo json_encode($json);
// print_r($json);
