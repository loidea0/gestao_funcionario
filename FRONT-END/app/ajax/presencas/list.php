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

$descricao = "";

$dataPresenca = [
        "nome"=> $_GET['nome'],
        "data_presenca"=> $_GET['data_presenca']
];

$responsePresenca = callapi($mainUrl . "presenca", "GET", $dataPresenca);



// echo "<pre>";
// print_r($responsePresenca);
// echo "</pre>";


if (!empty($responsePresenca)) :
?>
    <?php ob_start(); ?>
    
    <div class="row">
        <div class="col-6">
            <p class=""><strong>Dia: </strong><?=date("d-m-Y")?></p>
        </div>

        <div class="col-6">
            <button class=" btn btn-danger mb-4 float-right" id="marcar_ausencia" value=""   title="Encerrar o controle de presencas" data-original-title="Fechar o dia"><strong><i class="bi bi-calendar-check mr-2"></i>Terminar o controle</strong></button>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr style="font-weight: bold; color:black">
                <th>#</th>
                <th>Nome do funcionario</th>
                <th>Acções</th>
                <?php $content .= ob_get_contents(); ?>
                <th>Detalhes</th>
                <?php ob_start(); ?>
            </tr>
        </thead>
        <tbody>
            <?php $cont = 1;
            $total_valor = 0;
            $i = 0;
            foreach ($responsePresenca as $row) : ?>
                <?php //if($row->status != false){  ?>
                <tr>
                    <th scope="row"><?= $cont++ ?></th>
                    <td><?= $row->nome ?></td>
                    
                    
                    <td class="text-center">
                        <span <?=$row->hora_entrada == null ? "hidden" : "" ?> class="badge badge-pill badge-success mt-1">Entrada marcada: <?=$row->hora_entrada?></span>
                        <span <?=$row->hora_saida == null ? "hidden" : "" ?>  class="badge badge-pill badge-danger mt-1">Saida marcada: <?=$row->hora_saida ?? ""?></span>  
                        <span <?=$row->presenca == null ? "hidden" : "" ?>  <?=$row->hora_entrada != null ? "hidden" : "" ?>    class="badge badge-pill badge-danger mt-1">Ausente</span>
                        <button <?=$row->hora_entrada == null ? "" : "hidden" ?> <?=$row->presenca == null ? "" : "hidden" ?> class=" btn btn-outline-success mt-1" id="marcar_chegada" value="<?= $row->id ?>"   title="Marcar entrada"><strong><i class="bi bi-card-checklist mr-2"></i>Marcar entrada</strong></button>
                        <button <?=($row->hora_saida == null && $row->hora_entrada != null && $row->presenca == 0) ? "" : "hidden" ?> class="btn btn-outline-danger mt-1" id="marcar_saida" value="<?= $row->id ?>"   title="Marcar saida"><strong><i class="bi bi-card-checklist mr-2"></i>Marcar saida</strong></button>
                        <?php ob_start(); ?>
                    </td>
                        <?php $content .= ob_get_contents(); ?>
                    <td class="text-center">
                        <a href="historico.php?id=<?=$row->id?>" class=" btn btn-success mt-1"  value="<?= $row->id ?>"   title="Ver histórico" data-original-title="Ver histórico"><strong><i class="i-Eye-Visible"></i></strong></a>

                    </td>
                        <?php //echo var_dump($row->presenca); ?>
                    <?php ob_start(); ?>
                </tr>
                <?php //} ?>
            <?php
            $i++;
            endforeach; ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    <?php $content .= ob_get_contents(); ?>
    <div class="row" hidden>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php //if ($_GET['limite'] != "all") { 
            $paginationButtons = paginationButtons($responsePresenca->meta->current_page, $totalPaginas, $maxButtons);
            ?>
            <!-- Exibir links de paginação usando botões do Bootstrap -->
            <div class="pagination justify-content-end">
                <?= $paginationButtons ?>
            </div>

            <?php //} 
            ?>
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
$_SESSION['title'] = "Listagem de Marcações";
$_SESSION['dataInicio'] = $_GET['data_inicio'] ?? "";
$_SESSION['dataFim'] = $_GET['data_fim'] ?? "";
// $_SESSION['parametro1'] = "";
// $_SESSION['parametro2'] = "";
// $_SESSION['parametro3'] = "";
// $_SESSION['parametro4'] = "";

// $_SESSION['user'] = $_SESSION['name'];
?>

<div class="modal fade" id="confirmacao_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmação de Pedido de Marcação</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p>Tem a Certeza que deseja fazer a marcação do aluno(a) </p>
                <form action="#" id="frm_confirm_request_marcac" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success ml-2 ladda-button basic-ladda-button">SIM</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger ml-2 ladda-button basic-ladda-button" type="button">NÃO</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-success ml-2 ladda-button basic-ladda-button" data-style="expand-left" type="button" id="confirmar_pagamento">Submeter</button>
            </div> -->
        </div>
    </div>
</div>