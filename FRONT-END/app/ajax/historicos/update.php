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
        "nome"=> isset($_POST['nome']) ? $_POST['nome'] : "",
        "id_departamento"=>isset($_POST['id_departamento']) ? $_POST['id_departamento'] : "",
        "id_provincia"=>isset($_POST['id_provincia']) ? $_POST['id_provincia'] : "",
        "id_distrito"=>isset($_POST['id_distrito']) ? $_POST['id_distrito'] : "",
        "data_nascimento"=>isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : "",
        "contacto"=>isset($_POST['contacto']) ? $_POST['contacto'] : "",
        "genero"=>isset($_POST['genero']) ? $_POST['genero'] : "",
        "status"=>isset($_POST['status']) ? $_POST['status'] : ""  
];



// print_r($data);
// print_r($_POST['status']);

$json = callapi($mainUrl . "funcionario/".$_POST['id'], "PUT", $data);
// print_r($json);

echo json_encode($json);
// print_r($json);
