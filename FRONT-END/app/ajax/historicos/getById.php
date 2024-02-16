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

$presencas_historico = callapi($mainUrl . "presenca/". $_GET['id'], "GET");



if (!empty($presencas_historico)) :
?>
    <?php ob_start(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header d-flex align-items-center border-0">
                    <h3 class="w-50 float-left card-title m-0"><?=$presencas_historico->data[0]->nome ?? "" ?></h3>
                </div>
    
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">Data</th>
                                                        <th scope="col">Hora de entrada</th>
                                                        <th scope="col">Hora de saida</th>
                                                        <th scope="col">Horas de trabalho(H:m:s)</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php foreach ($presencas_historico->data as $row) :
                                                            $hora_entrada = new DateTime($row->hora_entrada);    
                                                            $hora_saida = new DateTime($row->hora_saida);            
                                                ?>
                                                    <tr>
                                                        <th scope="row"><p class="text-center"><?=$extras->date_format2($row->data_marcacao) ?></p></th>
                                                        <td>
                                                          <span class="ul-widget5__number">
                                                            <span <?=$row->hora_entrada == null ? "hidden" : ""?> class="badge badge-pill badge-success mt-1"><?=$row->hora_entrada?></span>
                                                          </span>
                                                        </td>
                                                        <td>
                                                          <span class="ul-widget5__number">
                                                            <span <?=$row->hora_saida == null ? "hidden" : ""?> class="badge badge-pill badge-danger mt-1"><?=$row->hora_saida?></span>
                                                          </span>
                                                        </td>
                                                        <td>
                                                          <span class="ul-widget5__number"><?=$hora_saida->diff($hora_entrada)->format('%H:%I:%S')?></span><span class="ul-widget5__sales text-mute"></span>
                                                        </td>
                                                        <td>
                                                          <div class="ul-widget5__section">

                                                          <span class="badge badge-pill <?php
                                                          if($row->presente == 1){
                                                            echo "badge-success mt-1";
                                                            $descricao = "Presente";
                                                          } else if($row->presente == 0){
                                                            echo "badge-danger mt-1";
                                                            $descricao = "Ausente";
                                                        }else{
                                                              echo "badge-danger mt-1";
                                                              $descricao = "Ausente";
                                                          }
                                                          
                                                          ?>">
                                                          
                                                           <?=$descricao ?>

                                                          </span>

                                                                   
                                                        </div>
                                                        </td>

                                                    </tr>

                                                <?php
                                                  endforeach; ?>
                                                    
                                                </tbody>
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
$_SESSION['title'] = "Relatório de Presenças";
$_SESSION['dataInicio'] = $_GET['data_inicio'] ?? "";
$_SESSION['dataFim'] = $_GET['data_fim'] ?? "";
// $_SESSION['parametro1'] = "";
// $_SESSION['parametro2'] = "";
// $_SESSION['parametro3'] = "";
// $_SESSION['parametro4'] = "";

// $_SESSION['user'] = $_SESSION['name'];
?>
