<?php
@session_start();
include_once './includes.php';
include_once './security/control.php';
include_once './app/api/callapi.php';


// $filters = [
//     "page" => 1,
//     "per_page" => 10,
//     "descricao" => "",
//     "frm_aluno" => "1"
// ];
$departamento = callapi($mainUrl . "departamento", "GET");
$provincia = callapi($mainUrl . "provincia", "GET");
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
                    <h1 class="font-weight-bold">Controle de presenças</h1>
                    <!-- <ul>
                        <li><a href="#">Home</a></li>
                        <li>Buttons</li>
                    </ul> -->
                </div>
                <div class="separator-breadcrumb border-top"></div>
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <!-- <h1 class="font-weight-bold">Multas</h1><br> -->
                                <div class="row">
                                    <!-- <div class="col-md-12 text-right ">
                                        
                                        <a href="rg_funcionario.php" class="btn btn-success btn-lg">Registar</a>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mt-4">
                                        <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Nome do funcionario</label>
                                        <input type="text" class="form-control" name="nome" id="nome" />
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Data <span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold"></span></label>
                                        <input type="date" name="data_presenca" id="data_presenca" class="form-control start_date" value="<?= date("Y-m-d") ?>">
                                    </div>
                                    <div class="col-md-4 mt-5">
                                        <button id="pesquisar" class="btn btn-secondary btn-lg search pesquisar">Pesquisar</button>
                                    </div>
                                </div>
                                <br><br>

                                <div class="table-responsive">
                                    <div class="list_funcionarios"></div>
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
    scri
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

            $("#presenca_li").addClass("nav-item-active")
            $("#presenca_link").addClass("nav-item-active-text")

            $(".pesquisar").click(function() {
                list("")
            })
        });


        hideLoader();

        function list(page) {
            // alert(page)

            showLoader();
            $.ajax({
                url: './app/ajax/presencas/list.php',
                method: 'GET',
                data: {
                    //"estado": "",
                    "nome": $("#nome").val(),
                    "data_presenca": $("#data_presenca").val(),
                    
                },
                dataType: 'html',
                success: function(data) {
                    // console.log(data);
                    $(".list_funcionarios").html(data)
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
                title: "Deseja marcar a chegada?",
                text: "Está acção é confirmada somente com a chegada do funcionário!",
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
                title: "Deseja marcar a saída?",
                text: "Está acção é confirmada somente com a saída do funcionário!",
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
        

        //Terminar o controle de presenças!

        $(document).on("click","#marcar_ausencia",function(){
            // alert("ausencia")
            swal({
                title: "Deseja encerrar o controle de presenças?",
                text: "Preste muita atenção, apos a confirmação os que não tiverem marcado a saida serão considerados ausentes!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Sim, desejo!',
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