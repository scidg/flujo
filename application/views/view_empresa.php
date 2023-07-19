<style>
#logo-empresa{
  width:100px;
  text-align:center;
  padding:1px;
}
</style>

    
    <div class="main-content-inner">
<div class="page-content">
  <div class="page-header">
    <h1>
      <i class="icon-tag"></i> Mantenedor de Empresa
      <small>
        <i class="icon-double-angle-right"></i>
        &nbsp;crea y edita empresas.
      </small>
    </h1>
  </div><!-- /.page-header -->
  <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                  <?php if($es_casa_central == 1){ ?>              
                                <p><button class="btn btn-success" onclick="add_empresa()"><i class="glyphicon glyphicon-plus"></i> Agregar Empresa</button>&nbsp;
                                <button class="btn btn-success" onclick="order_empresa()"><i class="glyphicon glyphicon-tasks"></i> Orden Empresas</button><p>
                              
                  <?php } ?>            
                </div><!-- /.page-content -->
                
                <div class="row">

                  <div class="table-responsive">

                        <table id="table-empresa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Código</th>
                              <th>RUT</th>
                              <th>Casa Central</th>
                              <th>Nombre</th>
                              <th>Logo</th>
                              <!--<th>Orden</th>-->
                              <th>Telefono</th>
                              <th>Direccion</th>
                              <!--<th>Suc.</th>-->
                              <th>Estado</th>
                              <th/th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>

                  </div><!-- /.col -->

                  </div><!-- /.row -->

                  </div><!-- /.row -->

          </div><!-- /.page-content -->

          </div><!-- /.main-content-inner -->



            <!-- inline scripts related to this page -->

            <script type="text/javascript">
            var save_method; //for save method string
            var table;
            var base_url = '<?php echo base_url();?>';

          $(document).ready(function() {
            
            var ocho = $('#cantidad_empresas').val();

            for(var o=0; o<ocho; o++){

              $('#spinner1').ace_spinner({value:0,min:1,max:8,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
            }
            

              $.mask.definitions['~']='[+-]';
      				
              $('#telefono_empresa').mask('999999999');

              table = $('#table-empresa').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [[ 0, 'asc' ]],
                // Load data for the table's content from an Ajax source
                "ajax": {
                  "url": "<?php echo site_url('lista_empresa')?>/" + <?php echo $id_empresa;?>,
                  "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                  {
                    "targets": [ 2 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  },  
                  {
                    "targets": [ 4 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  },    
                  {
                    "targets": [ 5 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  },                  
                {
                    "targets": [ 7 ], //last column
                    "orderable": false, //set not orderable
                    "searchable": false
                },
                {
                  "targets": [ -1 ], //last column
                  "orderable": false //set not orderable
                  
                },
                
                ],

              });

              $("input[type=text]").change(function(){
                  $(this).parent().parent().removeClass('has-error');
                  $(this).next().empty();
              });
              $("textarea").change(function(){
                  $(this).parent().parent().removeClass('has-error');
                  $(this).next().empty();
              });
              $("select").change(function(){
                  $(this).parent().parent().removeClass('has-error');
                  $(this).next().empty();
              });

              consulta_casa_central();

            });

            function consulta_casa_central(){
              
              var idh = $('#id_holding').val();
                  
              $.ajax({
                url : "<?php echo site_url('ajax_consulta_casa_central/')?>" + idh,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                { 
                  if(data){
                    $('[name="casa_central"]').prop('disabled', true);
                    $('.empresa-madre').attr('style','visibility:show');
                    $('.empresa-madre').css("color","#a94442").html('Ya existe la <strong>Casa Central</strong> para este Holding.');
                  }else{
                    $('.empresa-madre').attr('style','visibility:hidden');
                  }
                  
                }

              });

            }
            
            function add_empresa()
            {
              save_method = 'add';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string
              
              $('#modal_form').modal('show'); // show bootstrap modal
              $('.modal-title').text('Agregar Empresa'); // Set Title to Bootstrap modal title
              $('#photo-preview').hide(); // hide photo preview modal
              $('#label-photo').text('Logo'); // label photo upload
              $('.empresa-madre').css("color","#a94442").html('Ya existe la <strong>Casa Central</strong> para este Holding.');
              $("#accion").val("add");
              $("#es_casa_central").val(0);
            }

            function order_empresa()
            {
              save_method = 'order';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form_orden')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string
              
              $('#modal_form_orden').modal('show'); // show bootstrap modal
              $('.modal-title').text('Seleccione posición para reubicar'); // Set Title to Bootstrap modal title
          
            }


            function edit_empresa(id)
            {
              save_method = 'update';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_edit_empresa/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                  $('[name="id_empresa"]').val(data.id_empresa);
                 

                  if(data.casa_central == 1){
                    $('[name="casa_central"]').prop('checked', true);
                    /*$('.mensaje-madre').html('<div class="alert alert-success"><strong>Casa Central</strong>.</span></div>');*/
                  /*}else if(data.casa_central == 0){
                    $('.mensaje-madre').html('<div class="alert alert-warning">Ya existe una <strong>Casa Central</strong> configurada para este Holding.</span></div>');*/
                  }
                  $("#accion").val("edit");
                  $('[name="casa_central"]').prop('disabled', true);
                  $('[name="rut_empresa"]').val(data.rut_empresa);
                  $('[name="nombre_empresa"]').val(data.nombre_empresa);
                  $('[name="telefono_empresa"]').val(data.telefono_empresa);
                  $('[name="direccion_empresa"]').val(data.direccion_empresa);
                  $('[name="estado"]').val(data.estado);
                  $('[name="es_casa_central"]').val(data.casa_central);

                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Editar Empresa'); // Set title to Bootstrap modal title

                  $('#photo-preview').show(); // show photo preview modal

                  if(data.logo_empresa)
                  {
                      $('#label-photo').text('Cambiar foto'); // label photo upload
                      $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.logo_empresa+'" class="img-responsive">'); // show photo
                      $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Eliminar foto al guardar'); // remove photo

                  }
                  else
                  {
                      $('#label-photo').text('Cargar foto'); // label photo upload
                      $('#photo-preview div').text('(Sin foto)');
                  }


                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error al obtener los datos');
                  }
                });
            }

            function parametro_empresa(id)
            {
              //alert(id);
              save_method = 'param';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form_param')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_param_empresa/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  $('[name="id_empresa"]').val(id);

                  
                  for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
                    var id_parametro_detalle = data[i].id_parametro_detalle;
                      $("#id_parametro_detalle_save" + id_parametro_detalle).prop('checked', true);
                  }

                  $('#modal_form_param').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Parámetros Empresa'); // Set title to Bootstrap modal title

                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error al obtener los datos');
                  }
                });
            }

            function servicio_empresa(id)
            {
              //alert(id);
              save_method = 'servi';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form_servi')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_servi_empresa/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  $('[name="id_empresa"]').val(id);

                  
                  for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
                    let cantidad_servicios = data.length;
                    $("#cant_serv").val(cantidad_servicios);
                    
                    let id_empresa_servicio = data[i].id_empresa_servicio;
                    let nombre_servicio = data[i].nombre_servicio;
                      $("#servicio_"+i).val(nombre_servicio);

                      //$("#id_parametro_detalle_save" + id_parametro_detalle).prop('checked', true);
                  }

                  $('#modal_form_servi').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Servicios Empresa'); // Set title to Bootstrap modal title

                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error al obtener los datos');
                  }
                });
            }

            function traza_empresa(id)
            {

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_edit_empresa/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                  $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
                  $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
                  $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
                  $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

                    $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text(data.nombre_empresa); // Set title to Bootstrap modal title

                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error al obtener los datos.');
                  }
                });
            }

            function reload_table()
            {
              table.ajax.reload(null,false); //reload datatable ajax
              
              consulta_casa_central();

            }

            function invierte(val){

              d = document.getElementById("id_empresa_orden"+val).value;
              alert(d);

              /*console.log(this.value);
              let ie = $("#id_empresa_orden" + val).val();
              let ios = $("#id_empresa" + ie).val();
              $("#id_empresa"+ie);//.css("background","#87b87f").css("color","#fff");*/
            }
            
            function save()
            {
              $('#btnSave').text('Guardando...'); //change button text
              $('#btnSave').attr('disabled',true); //set button disable
              var url;

              if(save_method == 'add')
              {
                url = "<?php echo site_url('save_empresa')?>";
                modal = $('#modal_form');
                form = $('#form');
              }
              else if (save_method == 'param')
              {
                url = "<?php echo site_url('save_empresa_param')?>";
                modal = $('#modal_form_param');
                form = $('#form_param');
              }
              else if (save_method == 'servi')
              {
                url = "<?php echo site_url('save_empresa_servi')?>";
                modal = $('#modal_form_servi');
                form = $('#form_servi');
              } 
              else if (save_method == 'order')
              {
                url = "<?php echo site_url('save_empresa_orden')?>";
                modal = $('#modal_form_orden');
                form = $('#form_orden');
              }                            
              else
              {
                url = "<?php echo site_url('update_empresa')?>";
                modal = $('#modal_form');
                form = $('#form');
              }

              var formData = new FormData(form[0]);

               $.ajax({
                url : url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    { 
                        
                        modal.modal('hide');
                        alert('Empresa se guardó con éxito.');
                        reload_table();
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('Guardar'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable
                  },

                     error: function (jqXHR, textStatus, errorThrown)
                     {
                       alert('Error al guardar o actualizar los datos.');
                       $('#btnSave').text('Guardando...'); //change button text
                       $('#btnSave').attr('disabled',false); //set button enable
                    }
                  });
             }


                    </script>
            
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Person Form</h3>
                  </div>
                  <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" value="" name="id_empresa"/>
                      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                      <input type="hidden" value="<?php echo $id_holding_user;?>" name="id_holding" id="id_holding"/>
                      <input type="hidden" value="" name="accion" id="accion"/>
                      <input type="hidden" value="<?php echo $es_casa_central; ?>" name="es_casa_central" id="es_casa_central"/>

                      <div class="form-body">
                         
                        <div class="form-group">
                          <label class="control-label col-md-3">RUT</label>
                          <div class="col-md-9">
                            <input name="rut_empresa" id="rut_empresa" onblur="consulta_rut(this.value, 'empresa');"  placeholder="RUT" class="form-control" type="text" value="" autocomplete="off">
                            <span class="help-block"></span>
                            <span class="rut-existente"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Nombre</label>
                          <div class="col-md-9">
                            <input name="nombre_empresa" id="nombre_empresa" onblur="consulta_nombre(this.value, 'empresa');" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                            <span class="nombre-existente"></span>
                          </div>
                        </div>
                        <div class="form-group" id="photo-preview">
                          <label class="control-label col-md-3">Logo</label>
                          <div class="col-md-9">Cancelar
                              (Sin foto)
                              <span class="help-block"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3" id="label-photo">Logo </label>
                          <div class="col-md-9">
                              <input name="logo_empresa" type="file">
                              <span class="help-block"></span>
                          </div>
                      </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Telefono</label>
                          <div class="col-md-9">
                            <input name="telefono_empresa" id="telefono_empresa" placeholder="Telefono" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Direccion</label>
                          <div class="col-md-9">
                            <input name="direccion_empresa" placeholder="Direccion" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>                

              

                      <div class="form-group">
                        <label class="control-label col-md-3">Casa Central</label>
                        <div class="col-md-9">
                            <label class="block">
                              <input type="checkbox" name="casa_central" id="casa_central"  class="ace"/>
                              <span class="lbl">&nbsp;</span>
                              <span class="empresa-madre"></span>
                            </label>
                            
                        </div>

                      </div>                            
                        <div class="form-group">
                          <label class="control-label col-md-3">Estado</label>
                          <div class="col-md-9">
                            <select name="estado" class="form-control">
                              <option value="">Seleccione</option>
                              <option value="1">ACTIVO</option>
                              <option value="0">INACTIVO</option>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>
                      
                      
                      
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form_orden" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Person Form</h3>
                  </div>

                  <div class="modal-body form">

                  <form action="#" id="form_orden" class="form-horizontal">
                
                        <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                        <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda_orden"/>

                        <div class="form-body">
                        <div class="form-group">
                        <label class="control-label col-md-6"><h4 class="blue bigger-125">EMPRESA</h4></label>
                        <label class="control-label col-md-1"><h4 class="blue bigger-125">POSICI&Oacute;N</h4></label>
                        </div>
                          
                  

                            <?php $em = 0; 
                            
                              foreach ($mostrar_empresas as $p) { 
                                
                                if(es_casa_central($p->id_empresa) == 1){
                  
                                  $img_casa_central1 = '<i class="icon-star"></i>';
                                
                                }else{
                  
                                  $img_casa_central1 = '';
                                }
                                ?><div class="form-group">
                                
                                  <label class="control-label col-md-6"><?php echo $img_casa_central1." ".$p->nombre_empresa ?></label>

                                  <div class="col-md-6">
                                        <label>
                                        
                                        <input type="hidden" value="<?php echo $p->id_empresa;?>" title="id_empresa_orden<?php echo $em;?>" name="id_empresa_orden<?php echo $em;?>" id="id_empresa_orden<?php echo $em;?>"/>
                                        
                                        <?php if($p->orden == 0){$disabled_cero1 = 'disabled="disabled"';}else{$disabled_cero1 = '';}?>

                                        <select class="form-control" title="id_empresa<?php echo $p->id_empresa;?>" id="id_empresa<?php echo $p->id_empresa;?>" name="id_empresa[<?php echo $p->id_empresa;?>]">
                                        
                                          <option value="<?php echo $p->orden; ?>" selected="selected"><?php echo $p->orden; ?></option>
                                            
                                            <?php 
                                            
                                            if($p->orden > 0){

                                            for ($oe = 1; $oe <= count($mostrar_empresas); $oe++){ 
                                                if($p->orden != $oe){?>
                                                  <option  value="<?php echo $oe;?>"><?php echo $oe;?></option>
                                                  <?php } ?>
                                            <?php }
                                            
                                                }?>

                                            </select>

                                        </label>
                                  </div>
                                  </div>
                            <?php $em++; } ?>

                          

                        </div>

                  </form>
                    
                  </div>

                  <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                  
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Inicio modal parametros -->
            <div class="modal fade" id="modal_form_param" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aid_parametroria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Person Form</h3>
                  </div>
                  <div class="modal-body form">
                    <form action="#" id="form_param" class="form-horizontal">
                      <input type="hidden" value="" name="id_empresa"/>
                      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda_param"/>
                      <div class="form-body">
                        
                            <div class="form-group">
                              <div class="col-md-12">
                                

                     
                                <?php

                                    if(!empty($mostrar_parametros))
                                    {                              
                                        foreach ($mostrar_parametros as $p){
                                          
                                          echo "<h3 class='header smaller lighter blue'>
                                              $p->nombre_parametro
                                              <small>".$p->comentario_parametro."</small>
                                              </h3>";

                                          if(!empty($mostrar_parametros_dealle))
                                          {                              
                                              foreach ($mostrar_parametros_dealle as $pd){

                                                if($pd->condicion == 0){
                                                  $disabled = 'disabled="disabled"';
                                                  $txt_disabled = '(A&uacute;n no disponible)';
                                                }else{
                                                  $disabled = '';
                                                  $txt_disabled = '';
                                                }

                                                if($p->id_parametro==$pd->id_parametro){?>
                                                  
                                                  <div class="radio">
                                                  <label>
                                                    <input class="ace" type="radio" id="id_parametro_detalle_save<?php echo $pd->id_parametro_detalle;?>" name="id_parametro_detalle_save[<?php echo $pd->grupo_parametro;?>]" value="<?php echo $pd->id_parametro_detalle;?>" <?php echo $disabled;?>>
                                                    <span class="lbl"> <?php echo $pd->opcion_parametro."&nbsp;".$txt_disabled; ?></span>
                                                    <label>
                                                  </div>

                                                  <?php } 
                                                   
                                            
                                                 }
                                           }                                           
                                                 
                                          }
                                    } 


                                ?>
                              </div>
                            </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
          <!-- Inicio modal parametros -->


    <!-- Inicio modal servicios -->
    <div class="modal fade" id="modal_form_servi" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Person Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form_servicio" class="form-horizontal">
            <input type="hidden" value="" name="id_parametro"/>
            <input type="hidden" value="" name="id_parametro_detalle"/>
            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
            <input type="text" value="" name="cant_serv" id="cant_serv"/>
            <div class="form-body">
            

            <input type="text" value="1" name="cant_mov_det2" id="cant_mov_det2"/>
              <div class="bodyClone">
                <div id="clonedInput0" class="clonedInput">

                  <div class="form-group">
                    <label class="control-label col-md-3">Nombre Servicio</label>
                    

                    
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="servicio_0" name="servicio[]" placeholder="Nombre Servicio" value="">
                      
                      <span class="help-block"></span>
                    </div>
                    <div class="actions">
                      <a class="btn btn-sm btn-success clone_serv"  id="clone_serv_0" title="Agregar"><i class="icon icon-plus"></i></a>
                      <a class="btn btn-sm btn-danger remove_serv"  id="remove_serv_0" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div> <!-- Termino modal servicios -->


            <!-- Ventana modal Traza Registro -->
            <div class="modal fade" id="modal_form_traza" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Person Form</h3>
                  </div>
                  <div class="modal-body form">
                    <form action="#" class="form-horizontal">
                      <div class="form-body">
                        <div class="form-group">
                          <label class="col-sm-6 control-label">Usuario creaci&oacute;n Empresa</label>
                          <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-6">Fecha creaci&oacute;n Empresa</label>
                          <label class="col-sm-6 control-label" id="fecha_guarda" style="text-align:left;"></label>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-6">Usuario &uacute;ltima modificaci&oacute;n</label>
                          <label class="col-sm-6 control-label" id="username_modifica" style="text-align:left;"></label>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-6">Fecha &uacute;ltima modificaci&oacute;n</label>
                          <label class="col-sm-6 control-label" id="fecha_modifica" style="text-align:left;"></label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            </div><!-- /.main-content-inner -->