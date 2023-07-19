
    
    <div class="main-content-inner">

        <div class="page-content">
          <div class="page-header">
            <h1>
              <i class="icon-user"></i> Mantenedor de usuarios
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita. <?php echo $id_empresa."-".$es_casa_central; ?>
              </small>
            </h1>
          </div> <!-- /.page-header -->

          <div class="row">

            <div class="col-xs-12">
              <!-- PAGE CONTENT BEGINS -->
              
              <div class="row">
                <?php if( ($es_casa_central == 1) || ( ($multiempresa == 1) || ($multiempresa == 0) )){?>
                  <p> <button class="btn btn-success" onclick="add_usuario()"><i class="glyphicon glyphicon-plus"></i> Agregar Usuario</button>  </p>              
                <?php } ?>    
              </div><!-- /.page-content -->

              <div class="row">

                <div class="table-responsive">

                      <table id="table-usuario" class="table table-striped table-bordered table-hover">

                      <thead>
                        <tr>
                          <th style="width:50px;">ID Usuario</th>
                          <th style="width:50px;">Perfil</th>
                          <th style="width:60px;">Nombre</th>
                          <th style="width:60px;">Usuario</th>
                          <th style="width:30px;">Estado Usuario</th>
                          <th style="width:75px;"></th>
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

    $(document).ready(function() {

     

      table = $('#table-usuario').DataTable({


        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('lista_usuario')?>/" + <?php echo $id_empresa;?>,
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
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


    });




 function consulta_usuario(val)
    {
      var acc = $("#accion").val();
      var fecha = new Date();
      var ano = fecha.getFullYear();
      
      usuario = val.toLowerCase();
      usuario_pass = 'precisa' + ano;

      if(acc!='edit'){
        $.ajax({
          url : "<?php echo site_url('ajax_consulta_usuario/')?>" + usuario,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            if(data){
              $(".usuario-existente").attr('style','visibility:show');
              $('.usuario-existente').parent().parent().addClass('has-error')
              $('.usuario-existente').html("* Usuario '<strong>"+ usuario +"</strong>' ya existe en este Holding. <br>Intente con otro Usuario.");
              $("#username").val('');
              $("#username").focus();
              $('#pass_default').html();
              $('#pass_default').hide();
              $('#muestra-pass-default').hide();
            }else{
              $('.usuario-existente').parent().parent().removeClass('has-error')
              $('.usuario-existente').empty();
              $('#pass_default').show();
              $('#muestra-pass-default').show();
              $('#pass_default').html(usuario_pass);
            }
          }
        });
      }
    }

    function add_usuario()
    {
      
      $('#muestra-pass-default').hide();

      $('[name="fullname"]').parent().parent().removeClass('has-error');
      $('[name="fullname"]').next().empty();
  
      $('[name="username"]').parent().parent().removeClass('has-error');
      $('[name="username"]').next().empty();

      $('[name="password"]').parent().parent().removeClass('has-error');
      $('[name="password"]').next().empty();

      $('.usuario-existente').parent().parent().removeClass('has-error')
      $('.usuario-existente').empty();

      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Agregar Usuario'); // Set Title to Bootstrap modal title
      $("#accion").val("add");
    }

    function resetea_pass_usuario(id)
    {

      var fecha = new Date();
      var ano = fecha.getFullYear();

      $.ajax({
        url : "<?php echo site_url('reset_pass_usuario/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            alert('Clave reseteada a "precisa' +ano +'" con éxito.');
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al resetear clave.');
          }
        });
    }

    function edit_usuario(id)
    {

      

      $('#pass_default').hide();
      $('#muestra-pass-default').hide();

      $('[name="fullname"]').parent().parent().removeClass('has-error');
      $('[name="fullname"]').next().empty();
  
      $('[name="username"]').parent().parent().removeClass('has-error');
      $('[name="username"]').next().empty();

      $('[name="password"]').parent().parent().removeClass('has-error');
      $('[name="password"]').next().empty();

      $('.usuario-existente').parent().parent().removeClass('has-error')
      $('.usuario-existente').empty();
      
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_usuario/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $("#accion").val("edit");
          $('[name="id_usuario"]').val(data.id_usuario);
          $('[name="id_tipo_perfil"]').val(data.id_tipo_perfil);
          $('[name="fullname"]').val(data.fullname);
          $('[name="username"]').val(data.username);
          $('[name="password"]').val(data.password);
          $('[name="estado"]').val(data.estado);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar usuario'); // Set title to Bootstrap modal title

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos.');
          }
        });
    }

    function puedes_nopuedes(cod_per){
      if($("#codigo_permiso" + cod_per).prop('checked')){
        $("#puedes" + cod_per).html("Puedes&nbsp;");  
      }else{
        $("#puedes" + cod_per).html("No Puedes&nbsp;");  
      }
      
    }
    function permiso_usuario(ide,idu)
    {
      
      save_method = 'permi';
      $('.form-group').removeClass('has-error'); // clear error class
      $('#form_permi')[0].reset(); // reset form on modals
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_permi_usuario/')?>" + ide + "/" + idu,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {

          $('[name="id_usuario_perm"]').val(idu);

          for (var i=0;i<response.length; i++){ //cuenta la cantidad de registros
            var codigo_permiso = response[i].codigo_permiso;
              $("#codigo_permiso" + codigo_permiso).prop('checked', true);
              //$("#puedes" + codigo_permiso).html("Puedes&nbsp;");
          }

          $('#modal_form_permi').modal('show'); // show bootstrap modal when complete loaded
          //$('.modal-title').text(''); // Set title to Bootstrap modal title*/

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos');
          }
        });
    }

    function empresa_usuario(idu)
    {
      save_method = 'empre';
      $('.form-group').removeClass('has-error'); // clear error class
      $('#form_empre')[0].reset(); // reset form on modals
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_empre_usuario/')?>" + idu,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {

          $('[name="id_usuario_empr"]').val(idu);

          for (var i=0;i<response.length; i++){ //cuenta la cantidad de registros
            
            var id_empresa = response[i].id_empresa;
            var id_empresa_m = response[i].casa_central;
            
            if(id_empresa_m == 1){
              $("#id_empresa" + id_empresa).prop('checked', true);
              $("#es_empresa_chk").prop('checked', true);
            }else{
              $("#id_empresa" + id_empresa).prop('checked', true);
            }
          }

          $('#modal_form_empre').modal('show'); // show bootstrap modal when complete loaded
          //$('.modal-title').text(''); // Set title to Bootstrap modal title*/

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos');
          }
        });
    }

    function traza_usuario(id)
    {

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_usuario/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

          $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
          $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
          $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
          $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

            $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text(data.username); // Set title to Bootstrap modal title

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
    }

    function save()
    {
      var id_e = $('#id_empresa_guarda_perm').val();
      $('#btnSave').text('Guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      var alerta = 'Cambios se guardaron con éxito.'

      if(save_method == 'add')
      {
        url = "<?php echo site_url('save_usuario')?>";
        modal = $('#modal_form');
        form = $('#form');
      }
      else if (save_method == 'permi')
      {
        url = "<?php echo site_url('save_permi_usuario')?>";
        modal = $('#modal_form_permi');
        form = $('#form_permi');
        alerta = 'Permisos guardados con éxito.'

      }
      else if (save_method == 'empre')
      {
        url = "<?php echo site_url('save_empre_usuario')?>";
        modal = $('#modal_form_empre');
        form = $('#form_empre');
      }
      else
      {
        url = "<?php echo site_url('update_usuario')?>";
        modal = $('#modal_form');
        form = $('#form');
      }

      var formData = new FormData(form[0]);

       // ajax adding data to database
       $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            
            if(data.status)
            {
                modal.modal('hide');
                alert(alerta);
                //reload_table();
                $(location).attr('href','<?php echo base_url() ?>usuario/' + id_e);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
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
                      <input type="hidden" value="" name="id_usuario"/>
                      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
                      <input type="hidden" value="<?php echo $casa_central_id;?>" name="id_casa_central"/>
                      <input type="hidden" value="" name="accion" id="accion"/>
                      
                      <?php
                      if(!empty($mostrar_empresas))
                      {
                          foreach ($mostrar_empresas as $cl)
                          {
                              ?>
                              <input type="hidden" value="<?php echo $cl->id_empresa;?>" name="empresa[<?php echo $cl->id_empresa;?>]"/>
                              <?php
                              
                          }
                      }
                      if(!empty($mostrar_per_admin))
                      {
                          foreach ($mostrar_per_admin as $pad)
                          {
                              ?>
                              <input type="hidden" name="<?php echo "permisos_administrador[".$pad->codigo_permiso;?>]" value="<?php echo $pad->codigo_permiso;?>"/>
                              <?php

                          }
                      }

                      if(!empty($mostrar_per_dig))
                      {
                          foreach ($mostrar_per_dig as $pdig)
                          {
                              ?>
                              <input type="hidden" name="<?php echo "permisos_digitador[".$pdig->codigo_permiso;?>]" value="<?php echo $pdig->codigo_permiso;?>"/>
                              <?php

                          }
                      }

                      if(!empty($mostrar_per_guest))
                      {
                          foreach ($mostrar_per_guest as $pg)
                          {
                              ?>
                              <input type="hidden" name="<?php echo "permisos_invitado[".$pg->codigo_permiso;?>]" value="<?php echo $pg->codigo_permiso;?>"/>
                              <?php

                          }
                      }
                      ?>


                      <div class="form-body">
                        <div class="form-group">
                          <label class="control-label col-md-3">Perfil</label>
                          <div class="col-md-9">
                            <select name="id_tipo_perfil" class="form-control">
                              <option value="">Seleccione</option>
                              <option value="1">ADMINISTRADOR</option>
                              <option value="3" selected="selected">DIGITADOR</option>
                              <option value="4">INVITADO</option>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Nombre</label>
                          <div class="col-md-9">
                            <input name="fullname" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Usuario</label>
                          <div class="col-md-9">
                            <input name="username" id="username" placeholder="Usuario" onblur="consulta_usuario(this.value);" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                            <span class="usuario-existente"></span>
                          </div>
                        </div>
                        
                        <!--
                        <div class="form-group">
                          <label class="control-label col-md-3">Password</label>
                          <div class="col-md-9">
                            <div class="form-control">
                            </div>
                            <span class="help-block"></span>
                            
                          </div>
                        </div>
                        -->
                        
                        <div class="form-group">
                          <label class="control-label col-md-3">Estado</label>
                          <div class="col-md-9">
                            <select name="estado" class="form-control">
                              <option value="">Seleccione</option>
                              <option value="1" selected="selected">ACTIVO</option>
                              <option value="0">INACTIVO</option>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>


                        <div id="muestra-pass-default" style="visibility: none;" class="form-group">
                          <label class="control-label col-md-3">&nbsp;</label>
                          <div class="col-md-9">
                             
                          
                          <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                      </button>
                      
                      Clave <strong><span id="pass_default"></span></strong> generada automáticamente.<br>
                      El usuario podrá modificarla en su sección "Mi Perfil".
                 
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
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->

              <!-- Bootstrap modal Permisos -->
              <div class="modal fade" id="modal_form_permi" role="dialog">
                <div class="modal-dialog" style="width:700px;">
                  <div class="modal-content">
                    
                    <div class="modal-body form">
                      <form action="#" id="form_permi" class="form-horizontal">
                        <input type="hidden" value="" name="id_empresa"/>
                        <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                        <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda_perm" id="id_empresa_guarda_perm"/>
                        <input type="hidden" value="" name="id_usuario_perm"/>

                        <div class="form-body">
                          
                        

                      <?php

                      if(!empty($mostrar_mod))
                      {                              
                          foreach ($mostrar_mod as $p){
                            
                            $IsMother = is_company_mother($id_empresa);
                                    
                              if($IsMother){

                                if($p->id_ambiente == 3){

                                  echo " <h3 class='header smaller lighter blue'><i class='".$p->icono."'></i>
                                  $p->titulo_modulo
                                  <small>permisos activos del módulo ".$p->titulo_modulo."</small>
                                  </h3>";

                                ?>

                                <div class="radio">
                                  <label>
                                  <input onclick="check_all(<?php echo $p->id_modulo;?>);" class="ace" type="checkbox" title="codigo_modulo<?php echo $p->id_modulo;?>"  id="codigo_modulo<?php echo $p->id_modulo;?>" name="codigo_modulo[<?php echo $p->id_modulo;?>]" value="<?php echo $p->id_modulo;?>">
                                    <span class="lbl">&nbsp;
                                        <span style="font-size:13px;">Seleccionar todos</span>
                                    </span>
                                  <label>
                                </div>

                                <?php } 
                                
                              }else{

                                if($p->id_ambiente == 2 || $p->id_ambiente == 3){

                                echo " <h3 class='header smaller lighter blue'><i class='".$p->icono."'></i>
                                $p->titulo_modulo
                                <small>permisos activos del módulo ".$p->titulo_modulo."</small>
                                </h3>";

                                ?>

                                <div class="radio">
                                <label>
                                <input onclick="check_all(<?php echo $p->id_modulo;?>);" class="ace" type="checkbox" title="codigo_modulo<?php echo $p->id_modulo;?>"  id="codigo_modulo<?php echo $p->id_modulo;?>" name="codigo_modulo[<?php echo $p->id_modulo;?>]" value="<?php echo $p->id_modulo;?>">
                                  <span class="lbl">&nbsp;
                                      <span style="font-size:13px;">Seleccionar todos</span>
                                  </span>
                                <label>
                                </div>

                              <?php }}?>

                               
                          <?php if(!empty($mostrar_per))
                            {                              
                                foreach ($mostrar_per as $pd){

                                  if($p->id_modulo==$pd->id_modulo){
                                    
                                    $IsMother = is_company_mother($id_empresa);
                                    
                                    if(!$IsMother){
                                      
                                      if( ($pd->id_tipo_permiso == 2) || ($pd->id_tipo_permiso == 3) ){?>
                                    
                                        <div class="radio">
                                          <label>
                                          <input class="ace" type="checkbox" title="codigo_permiso<?php echo $pd->codigo_permiso;?>"  id="codigo_permiso<?php echo $pd->codigo_permiso;?>" name="codigo_permiso[<?php echo $pd->codigo_permiso;?>]" value="<?php echo $pd->codigo_permiso;?>">
                                            <span class="lbl">&nbsp;
                                                <span style="font-size:13px;"><span id="puedes<?php echo $pd->codigo_permiso;?>">&nbsp;</span><?php echo $pd->descripcion_permiso;?></span>
                                            </span>
                                          <label>
                                        </div>

                                      <?php }
                                    
                                    }else{

                                      if( ($pd->id_tipo_permiso == 1) || ($pd->id_tipo_permiso == 3) ){?>
                                    
                                        <div class="radio">
                                          <label>
                                          <input class="ace" type="checkbox" title="codigo_permiso<?php echo $pd->codigo_permiso;?>"  id="codigo_permiso<?php echo $pd->codigo_permiso;?>" name="codigo_permiso[<?php echo $pd->codigo_permiso;?>]" value="<?php echo $pd->codigo_permiso;?>">
                                            <span class="lbl">&nbsp;
                                                <span style="font-size:13px;"><span id="puedes<?php echo $pd->codigo_permiso;?>">&nbsp;</span><?php echo $pd->descripcion_permiso;?></span>
                                            </span>
                                          <label>
                                        </div>

                                      <?php }

                                    }
                                    
                                  } 
                              }
                          }                                           
                                  
                        }

                      } 


                        ?>



                                          
                      



                          
                        
                          <span class="error-permiso"></span>
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

              <!-- Bootstrap modal Empresas -->
              <div class="modal fade" id="modal_form_empre" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    
                    <div class="modal-body form">
                      <form action="#" id="form_empre" class="form-horizontal">
                        <input type="hidden" value="<?php echo $casa_central_id;?>" name="id_casa_central"/>
                        <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                        <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda_empr"/>
                        <input type="hidden" value="" name="id_usuario_empr"/>


                        <div class="form-body">
                        
                        <input type="checkbox" id="es_empresa_chk" name="es_empresa_chk" class="ace" value="">
                        
                          <?php
                          echo "<h3 class='header smaller lighter blue'>Empresas<small> 
                          &nbsp;asignaci&oacute;n de <strong>EMPRESA(S)</strong> y/o <i>Sucursal(es)</i> al usuario</small></h3>";

                          if($es_casa_central == 1){
                            
                            foreach ($mostrar_empresas as $p) { ?>
                              <div class="form-group">
                              <label class="control-label col-md-6" title="EMPRESA"><?php echo "<strong>".$p->nombre_empresa."</strong>" ?></label>

                              <div class="col-md-6">
                                    <label>
                                          <input type="checkbox" id="id_empresa<?php echo $p->id_empresa;?>" name="id_empresa[<?php echo $p->id_empresa;?>]" class="ace" value="<?php echo $p->id_empresa;?>">
                                          <span class="lbl">&nbsp;</span>
                                            <br>
                                    </label>
                              </div>
                            </div>
                            <?php   
                            }

                          }else{

                            foreach ($mostrar_empresas as $p) {
                            
                              if($p->id_empresa === $id_empresa){ ?>

                                <div class="form-group">
                                  <label class="control-label col-md-6" title="EMPRESA"><?php echo "<strong>".$p->nombre_empresa."</strong>" ?></label>

                                  <div class="col-md-6">
                                        <label>
                                              <input disabled type="checkbox" id="id_empresa<?php echo $p->id_empresa;?>" name="id_empresa[<?php echo $p->id_empresa;?>]" class="ace" value="<?php echo $p->id_empresa;?>">
                                              <span class="lbl">&nbsp;</span>
                                                <br>
                                        </label>
                                  </div>
                                </div>
                              
                                <?php 
                                
                                if($mostrar_sucursales){
                                
                                  foreach ($mostrar_sucursales as $s) { 

                                    if($p->id_empresa === $s->id_empresa){ ?>
                                      
                                      <div class="form-group">
                                      
                                        <label class="control-label col-md-6" style="font-size:14px;" title="SUCURSAL"><?php echo "<i>".ucwords(strtolower($s->nombre_sucursal))."</i>" ?></label>

                                        <div class="col-md-6">
                                              <label>
                                                    <input type="checkbox" id="id_sucursal<?php echo $s->id_sucursal;?>" name="id_sucursal[<?php echo $s->id_sucursal;?>]" class="ace" value="<?php echo $s->id_sucursal;?>" >
                                                    <span class="lbl">&nbsp;</span>
                                                      <br>
                                              </label>
                                        </div>
                                    
                                      </div>
                                      
                                    <?php }
                                  } 
                                }
                              }
                            }
                          }
                          ?>

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
                            <label class="col-sm-6 control-label">Usuario creaci&oacute;n Usuario</label>
                            <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-6">Fecha creaci&oacute;n Usuario</label>
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