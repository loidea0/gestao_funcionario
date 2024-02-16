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
        "nome"=> $_POST['nome'],
        "id_departamento"=>$_POST['id_departamento'],
        "id_provincia"=>$_POST['id_provincia'],
        "id_distrito"=>$_POST['id_distrito'],
        "data_nascimento"=>$_POST['data_nascimento'],
        "contacto"=>$_POST['contacto'],
        "genero"=>$_POST['genero']  
];


$json = callapi($mainUrl . "funcionario", "POST", $data);
echo json_encode($json);
