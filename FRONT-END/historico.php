<?php
@session_start();
include_once './includes.php';
include_once './security/control.php';
include_once './app/api/callapi.php';
include_once './app/Extras.php';

$extras = new Extras();

$response = callapi($mainUrl . "funcionario/" . $_GET['id'], "GET");

$presencas_historico = callapi($mainUrl . "presenca/". $_GET['id'], "GET");

?>
<!DOCTYPE html>
<html lang="en" dir="">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Portal | INATRO</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="./dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="./dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="./dist-assets/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="dist-assets/select2/css/select22.min.css" />
    <link rel="stylesheet" href="dist-assets/select2-bootstrap4-theme/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="dist-assets/css/toastr.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css">

    <!-- preloader css-->
    <link rel="stylesheet" href="dist-assets/css/preloader.css" />
    <!-- favicon -->
    <link href="./dist-assets/images/logo1.png" rel="shortcut icon">
    <link href="dist-assets/css/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css" />
    <!-- <link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css"> -->
</head>

<body class="text-left">
    <!-- Start preloader -->
    <div class="loader-bg">
        <div class="loader-p"></div>
    </div>
    <!-- End preloader -->
    <div class="app-admin-wrap layout-sidebar-large">
        <?php include_once './sidebar.phtml' ?>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="font-weight-bold">Histórico de presenças</h1>

                </div>
                <div class="separator-breadcrumb border-top"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 mb-3 text-right" style="text-align: right">
                            <button class="btn btn-danger" id="print"> Exportar para PDF</button>
                        </div>
                    <div class="card">
                        <div class="card-body">

                        <div class="row">
                                                <div class="col-md-2 col-sm-3 mb-3">
                                                    <!-- <img id="imagemAluno" <?= $response->foto != null ? 'src="' . $response->foto . '"' : (($response->foto != "") ? 'src="' . $response->foto . '"' : 'src="dist-assets/images/user.png"') ?> alt="Imagem do Aluno" class="img-fluid img-thumbnail rounded-circle avatar-xl mb-3"> -->
                                                    <img src="./dist-assets/images/user.png" alt="Imagem do Funcionario" class="img-fluid img-thumbnail rounded-circle avatar-xl mb-3">
                                                    

                                                </div>
                                                <div class="col-md-10 col-sm-9">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for=""> Código<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold; "></span></label>
                                                            <input  style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" value="<?=$response->data[0]->id ?>" class="form-control" disabled> 

                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for=""> Nome<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold; "></span></label>
                                                            <input style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" value="<?=$response->data[0]->nome; ?>" class="form-control" disabled>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for="">Sexo<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold; "></span></label>
                                                            <select style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" name="sexo" id="sexo" class="form-control select" disabled>
                                                                <option value=""> <?=$response->data[0]->genero == "M" ? "Masculino" : "Femenino"; ?></option>
                                                            </select>
                                                        </div>
                                                      
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for="">Data de Nascimento <span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold; "></span></label>
                                                             <input style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" value="<?=$extras->date_format2($response->data[0]->data_nascimento); ?>" class="form-control" disabled>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for="">Provincia<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold"></span></label>
                                                            <select style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" name="provincia" id="provincia" class="form-control select" disabled>
                                                                <option> <?= $response->data[0]->provincia; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for="">Distrito<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold"></span></label>
                                                            <select style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" name="distrito" id="distrito" class="form-control select" disabled>
                                                                <option> <?= $response->data[0]->distrito; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for="">Departamento<span class="text-danger" style="font-family: 'Tahoma Verda'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold"></span></label>
                                                            <select style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" name="departamento" id="departamento" class="form-control select" disabled>
                                                                <option> <?= $response->data[0]->departamento; ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <label for=""> Contacto<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold"></span></label>
                                                            <input style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;" value="<?=$response->data[0]->contacto; ?>" class="form-control" disabled>
                                                        
                                                        </div>

                                                        <div class="col-md-4 col-sm-6 mb-6">
                                                            <span class="ul-widget__desc text-mute">Estado</span>
                                                        
                                                            <?php 
                                                            if($response->data[0]->estado == 1){?>
                                                                <h3 class="ul-widget1__title" style="font-size: 15px"><span class="badge badge-success mr-1 mb-1"> Activo</span></h3>
                                                                
                                                            <?php
                                                              }else if($response->data[0]->estado == 0){ ?>
                                                                <h3 class="ul-widget1__title" style="font-size: 15px"><span class="badge badge-danger mr-1 mb-1"> Inactivo</span></h3>
                                                            <?php
                                                            }?>
                                                            
                                                        </div>    
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        
                              <div class="row" >
                                <div class="col-md-12">
                                    <div class="card o-hidden mb-4">
                                        <div class="card-header d-flex align-items-center border-0">
                                            
                                        </div>
                                        <div>
                                          <div class="table-responsive">
                                          <div class="list_historico"></div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            <!-- end of main-content -->

            <!-- Footer Start -->
            <?php include_once './copyright.php' ?>
            <!-- fotter end -->
    </div>
</div>

    <script src="./dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="./dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="./dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./dist-assets/js/scripts/script.min.js"></script>
    <script src="./dist-assets/js/scripts/sidebar.large.script.min.js"></script>
    <script src="dist-assets/js/flatpickr.js"></script>
    <script src="./js/imask.js"></script>
    <!-- Script geral -->
    <script src="./js/scripts.js"></script>
    <!-- <script src="dist-assets/js/scripts/sweetalert.script.min.js"></script> -->
    <script src="dist-assets/js/scripts/sweetalert2@11.js"></script>
    <script src="dist-assets/select2/js/lodash.min.js"></script>
    <script src="dist-assets/select2/js/select22.min.js"></script>
    <script src="dist-assets/js/toastr.min.js"></script>
    <script src="dist-assets/js/plugins/sweetalert2.min.js"></script>
    <script src="dist-assets/js/scripts/sweetalert.script.min.js"></script>
    <script src="dist-assets/js/plugins/toastr.min.js"></script>
    <script src="dist-assets/js/scripts/toastr.script.min.js"></script>

    <!-- VentanaCentrada.js -->
    <script src="./reports/pdf/js/VentanaCentrada.js"></script>
    <!-- pdf.js -->
    <script src="./reports/pdf/js/pdf.js"></script>
    <script src="./js/anexo_script.js"></script>
    <script src="dist-assets/js/jquery.inputmask.min.js"></script>
    <script src="./js/api_queries.js"></script>
    <script src="./js/pagination.js"></script>

    <script>
        $(document).ready(function() {
            $(".select2").select2({
                allowClear: true,
            });

            list("");

            $(document).on('click', '.pagination a', paginaClickHandler);

            $("#listagem_funcionarios_li").addClass("nav-item-active")
            $("#listagem_funcionarios_link").addClass("nav-item-active-text")

            $(".pesquisar").click(function() {
                list("")
            })
        });


        hideLoader();

        function list(page) {
            
            showLoader();
            $.ajax({
                url: './app/ajax/historicos/getById.php',
                method: 'GET',
                data: {
                    "id": <?=$_GET['id']?>                    
                },
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    $(".list_historico").html(data)
                },
                error: function(err) {
                    console.log(err);
                }
            }).always(function() {
                hideLoader();
            });
        }



        $(document).on("click", '#pesquisar', function(e) {
            list("")
        })

        function confirmAction(title, text) {

            

        }

        $(document).on('click', '#marcar_chegada', function() {
            // alert("Chegada: "+$(this).val())
            let id_funcionario = $(this).val()

            swal({
                title: "Marcar Chegada?",
                text: "Só confirme esta acção caso tenhas certeza de que o funcionarios ja chegou!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Sim, marcar!',
                cancelButtonText: 'Não, cancelar!',
                confirmButtonClass: 'btn btn-success mr-5',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function() {
                controle_presenca(id_funcionario, 'chegada')
                // swal('Chegada confirmada', 'Presença do funcionario foi confirmada.', 'success');
                // list("")
            }, function(dismiss) {

            });
        })

        $(document).on('click', '#marcar_saida', function() {
            // alert("Saida: "+$(this).val())

            let id_funcionario = $(this).val()
            
            swal({
                title: "Marcar Saida?",
                text: "Só confirme esta acção caso tenhas certeza de que o funcionarios ja ausentou-se!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Sim, marcar!',
                cancelButtonText: 'Não, cancelar!',
                confirmButtonClass: 'btn btn-success mr-5',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function() {
                controle_presenca(id_funcionario, 'saida')
                // swal('Saida confirma', 'Hora de termino do espediente do funcionario marcada.', 'success');
                // list("")
            }, function(dismiss) {
            });
        })
        
        $(document).on("click","#marcar_ausencia",function(){
            // alert("ausencia")
            swal({
                title: "Deseja encerrar o dia?",
                text: "Depois da tua confirmação os que não tiverem a presença marcada serão considerados ausentes!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Sim, encerrar!',
                cancelButtonText: 'Não, cancelar!',
                confirmButtonClass: 'btn btn-success mr-5',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function() {
                controle_presenca(null, 'ausencia')
                // swal('Saida confirma', 'Hora de termino do espediente do funcionario marcada.', 'success');
                // list("")
            }, function(dismiss) {
            });
        })

        function controle_presenca(id, action) {

            $.ajax({
                url: './app/ajax/presencas/marcar.php',
                method: 'POST',
                data: {
                    'id': id,
                    'action': action
                },
                dataType: 'json',
                success: function(data) {
                    
                    if(data.success == true){
                        console.log(data)
                        toastr.success(data.message, {
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        positionClass: "toast-top-center",
                        containerId: "toast-top-center",
                        timeOut: 2e3
                        });
                        list("")
                    }else if(action == "ausencia" && data.success == false){
                        toastr.error(data.message, {
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        positionClass: "toast-top-center",
                        containerId: "toast-top-center",
                        timeOut: 2e3
                        });
                    }
                },
                error: function(err) {
                    alert("Erro")
                    console.log(err);
                }
            }).always(function() {
                hideLoader();
            });

        }
    </script>
</body>

</html>