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



$response = callapi($mainUrl . "distrito", "GET");



if (!empty($response->data)) :
    ?>
        <?php ob_start(); ?>
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Total:</strong><?= count($response->data) ?></h4>
            </div>
        </div>
        <table class="col-md-6 table table-striped table-bordered">
            <thead>
                <tr style="font-weight: bold; color:black">
                    <th class="col-1">#</th>
                    <th class="col-2">Nome</th>
                    <th class="col-2">Provincia</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $cont = 1;
                $total_valor = 0;
                foreach ($response->data as $distrito) : ?>
                    <tr>
                        <th scope="row"><?= $cont++ ?></th>
                        <td><?= $distrito->nome ?></td>
                        <td><?= $distrito->provincia ?></td>
                       
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
    
