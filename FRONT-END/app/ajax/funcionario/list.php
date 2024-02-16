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


$estado = 0;

if($_GET['estado'] == "") {
   $estado = 1;   
}else {
    $estado = $_GET['estado'];
}




$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$itensPorPagina = !empty($_GET['per_page']) ? (int)$_GET['per_page'] : 10;

$data = [
    "nome" => !empty($_GET['nome']) ? $_GET['nome'] : "",
    "genero" => !empty($_GET['genero']) ? $_GET['genero'] : "",
    "id_provincia" => !empty($_GET['id_provincia']) ? $_GET['id_provincia'] : "",
    "id_distrito" => !empty($_GET['id_distrito']) ? $_GET['id_distrito'] : "",
    "estado" => $estado,
];

$response = callapi($mainUrl . "funcionario", "GET", $data);

if (!empty($response->data)) :
?>
                                    
    <div class="col-md-12 mb-3 text-right" style="text-align: right">
        <button id="print" class="btn btn-danger btn- search pesquisar">  <i class="i-File-Download"></i>Exportar PDF</button>
    </div>

    <?php ob_start(); ?>

    <div class="row">
        <div class="col-md-12">
            <h4><strong>Total:</strong><?= count($response->data) ?></h4>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr style="font-weight: bold; color:black">
                <th>#</th>
                <th>Nome</th>
                <th>Genero</th>
                <th>Data de Nascimento</th>
                <th>Provincia</th>
                <th>Distrito</th>
                <th>Contacto</th>
                <th>Departamento</th>
                <?php $content .= ob_get_contents(); ?>
                <th >Accoes</th>
                <?php ob_start(); ?>       
            </tr>
        </thead>
        <tbody>
            <?php $cont = 1;
            $total_valor = 0;
            foreach ($response->data as $row) : ?>
                 <tr>
                        <th scope="row"><?= $cont++ ?></th>
                        <td><?= $row->nome ?></td>
                        <td><?= ($row->genero == 'M') ?  "Masculino" :  "Femenino" ?></td>
                        <td><?= $extras->date_format2($row->data_nascimento) ?></td>
                        <td><?= $row->provincia ?></td>
                        <td><?= $row->distrito ?></td>
                        <td><?= $row->contacto ?></td>
                        <td><?= $row->departamento ?></td>
                        <?php $content .= ob_get_contents(); ?>
                        
                        <td class="text-center">
                            <?php 
                                if($row->estado == 1){ ?>
                                <a class="text-white btn btn-info" href="detalhes_funcionario.php?id=<?= $row->id ?>" data-toggle="tooltip" data-placement="top" title="Detalhes do Funcionario" data-original-title="Detalhes"><i class="nav-icon i-Eye-Visible text-white"></i></a> |
                                <button class="btn btn-primary" id="editar_funcionario" value="<?=$row->id?>" type="button" data-toggle="modal" data-target="#update_funcionario_modal"> <i class="i-Pen-2"></i></button> |
                                <!-- <button title="Desactivar Funcionario" class="btn btn-danger" value="<?= $row->id ?>" type="button" id="desactivar_funcionario"> <i class="fas fa-user-minus"></i></button> -->
                                <button id="desactivar_funcionario" title="Desactivar funcionario" class="btn btn-danger"  type="button" value="<?= $row->id?>"><i class="fas fa-user-minus"></i></button>
                            <?php 
                             }else if($row->estado == 0){ ?>
                                <a class="text-white btn btn-info" href="detalhes_funcionario.php?id=<?= $row->id ?>" data-toggle="tooltip" data-placement="top" title="Detalhes do Funcionario" data-original-title="Detalhes"><i class="nav-icon i-Eye-Visible text-white"></i></a> |
                                <button id="activar_funcionario" title="Activar funcionario" class="btn btn-success"  type="button" value="<?= $row->id?>"><i class="fas fa-user-plus"></i></button>
                                <?php
                            }
                            ?> 
                        </td>

                        <?php ob_start(); ?>
                   </tr>
              <?php
              endforeach; ?>
         </tbody>
        <tfoot>


        </tfoot>
    </table>
    <?php $content .= ob_get_contents(); ?>
    <div class="row" hidden>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php //if ($_GET['limite'] != "all") { 
            $paginationButtons = paginationButtons($response->meta->current_page, $totalPaginas, $maxButtons);
            ?>
            <!-- Exibir links de paginação usando botões do Bootstrap -->
            <div class="pagination justify-content-end">
                <?= $paginationButtons ?>
            </div>
        </div>
    </div>
<?php
    ob_start();
else :
?>
    <div class="alert alert-info" role="alert">
        <strong class="text-capitalize">Alerta!</strong>
        Nenhum registo encontrado.
    </div>
<?php
endif;
?>

<?php
$content .= ob_get_contents();
$_SESSION['html'] = $content;
$_SESSION['title'] = "Listagem de Funcionarios";
$_SESSION['dataInicio'] = $_GET['data_inicio'] ?? "";
$_SESSION['dataFim'] = $_GET['data_fim'] ?? "";
// echo "<pre>";
// echo $content;
// echo "<pre/>";

?>
