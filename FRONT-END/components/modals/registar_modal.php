<?php
$provincia = callapi($mainUrl. "provincia", "GET");
$departamento = callapi($mainUrl. "departamento", "GET");
?>

<div class="modal fade" id="registar_funcionario_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <input type="hidden" id="id" name="id">
                                <h5 class="modal-title" id="exampleModalLabel">Registar Funcionario</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                            <form action="#">
                                     <div class="row">
                                         <div class="col-md-12">
                                             <div class="row" hidden>
                                                 <div class="col-md-4">
                                                     <div class="kv-avatar">
                                                         <div class="file-loading">
                                                             <input id="foto_perfil" name="foto_perfil" type="file">
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;"> Nome<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                    <input type="text"  name="nome_func" id="nome_func" class="form-control" required>
                                                    </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Data de Nascimento <span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <input type="date" name="data_nascimento" id="data_nascimento_func" class="form-control start_date" required>
                                                 </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Genero <span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <select name="genero_func" id="genero_func" class="form-control select2" required>
                                                         <option value="">selecione uma opção</option>
                                                         <option  value="M">Masculino</option>
                                                         <option  value="F">Feminino</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Departamento<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <select name="id_departamento" id="id_departamento_func" class="form-control select2" required>
                                                         <option value="">--selecione uma opção--</option>
                                                         <?php foreach ($departamento->data as $item) : ?>
                                                             <option  value="<?= $item->id ?>"><?= $item->nome ?></option>
                                                         <?php endforeach ?>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Contacto<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <input type="text"  name="contacto" id="contacto_func" class="form-control" required>
                                                 </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Provincia Residência<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <select name="id_provincia_modal" id="id_provincia_modal" class="form-control select2" required>
                                                         <option value="">--selecione uma opção--</option>
                                                         <?php foreach ($provincia->data as $item) : ?>
                                                             <option  value="<?= $item->id ?>"><?= $item->nome ?></option>
                                                         <?php endforeach ?>
                                                     </select> 
                                                    
                                                    </div>
                                                 <div class="col-md-4 mb-3">
                                                     <label for="" style="font-family: 'Arial narrow'; font-size: 14px; color: #2C304D; font-weight: 600;">Distrito Residência<span class="text-danger" style="font-family: 'Arial narrow'; font-size: 14px; color: #6b6076; line-height: 21px; font-weight: bold">*</span></label>
                                                     <select name="id_distrito_modal" id="id_distrito_modal" class="form-control select2" required>
                                                         <option value="">--selecione uma opção--</option>
                                                         <?php foreach ($distritos->data as $item) : ?>
                                                             <option value="<?= $item->id ?>"><?= $item->nome ?></option>
                                                         <?php endforeach ?>
                                                     </select>
                                                 </div>
                                                 
                                             </div>
                                         </div>
                                     </div>
                                 </form>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                                <button class="btn btn-primary ml-2" data-dismiss="modal" id="registar_funcionario" type="button">Registar</button>
                            </div>
                        </div>
                    </div>
                </div>
                