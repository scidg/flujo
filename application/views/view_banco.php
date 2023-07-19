
    <div class="main-content-inner">
<div class="page-content">
          <div class="page-header">
            <h1>
              <i class="icon-credit-card"></i> Mantenedor de Banco
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita bancos.
              </small>
            </h1>
          </div><!-- /.page-header -->


          <div class="row">     
                                <div class="col-xs-12">
                                  <!-- PAGE CONTENT BEGINS -->
                                  <div class="row">
                                <p><button class="btn btn-success" onclick="add_banco()"><i class="glyphicon glyphicon-plus"></i> Agregar Banco</button></p>
                                </div><!-- /.page-content -->
                                  <div class="row">

                                    <div class="table-responsive">

                                          <table id="table_banco" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Código</th>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Moneda</th>
                                    <th>L&iacute;nea de Sobregiro</th>
                                    <th>L&iacute;nea de Cr&eacute;dito</th>
                                    <th style="width:75px;">Estado</th>
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

                          table = $('#table_banco').DataTable({


                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.

                            // Load data for the table's content from an Ajax source
                            "ajax": {
                              "url": "<?php echo site_url('lista_banco')?>/" + <?php echo $id_empresa;?>,
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
                          $("input").change(function(){
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

                        function add_banco()
                        {
                          $('[name="rut_banco"]').parent().parent().removeClass('has-error');
                          $('[name="rut_banco"]').next().empty();
                      
                          $('[name="nombre_banco"]').parent().parent().removeClass('has-error');
                          $('[name="nombre_banco"]').next().empty();

                          $('[name="id_moneda"]').parent().parent().removeClass('has-error');
                          $('[name="id_moneda"]').next().empty();

                          $('[name="linea_sobregiro"]').parent().parent().removeClass('has-error');
                          $('[name="linea_sobregiro"]').next().empty();

                          $('[name="id_linea_credito"]').parent().parent().removeClass('has-error');
                          $('[name="id_linea_credito"]').next().empty();                          
                          
                          save_method = 'add';
                          $('#form')[0].reset(); // reset form on modals
                          $('#modal_form').modal('show'); // show bootstrap modal
                          $('.modal-title').text('Agregar Banco'); // Set Title to Bootstrap modal title
                          $("#accion").val("add");
                        }

                        function edit_banco(id)
                        {
                          $('[name="rut_banco"]').parent().parent().removeClass('has-error');
                          $('[name="rut_banco"]').next().empty();
                      
                          $('[name="nombre_banco"]').parent().parent().removeClass('has-error');
                          $('[name="nombre_banco"]').next().empty();

                          $('[name="id_moneda"]').parent().parent().removeClass('has-error');
                          $('[name="id_moneda"]').next().empty();

                          $('[name="linea_sobregiro"]').parent().parent().removeClass('has-error');
                          $('[name="linea_sobregiro"]').next().empty();

                          $('[name="id_linea_credito"]').parent().parent().removeClass('has-error');
                          $('[name="id_linea_credito"]').next().empty();                          
                          
                          save_method = 'update';
                          $('#form')[0].reset(); // reset form on modals

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_banco/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                              $("#accion").val("edit");
                              $('[name="id_banco"]').val(data.id_banco);
                              $('[name="rut_banco"]').val(data.rut_banco);
                              $('[name="nombre_banco"]').val(data.nombre_banco);
                              $('[name="id_moneda"]').val(data.id_moneda);
                              $('[name="linea_sobregiro"]').val(data.linea_sobregiro);
                              $('[name="id_linea_credito"]').val(data.id_linea_credito);
                              $('[name="estado"]').val(data.estado);

                                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Editar Banco'); // Set title to Bootstrap modal title

                              },
                              error: function (jqXHR, textStatus, errorThrown)
                              {
                                alert('Error al obtener los datos.');
                              }
                            });
                        }
                        function traza_banco(id)
                        {

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_banco/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {

                              $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
                              $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
                              $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
                              $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

                                $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text(data.nombre_banco); // Set title to Bootstrap modal title

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
                          $('#btnSave').text('Guardando...'); //change button text
                          $('#btnSave').attr('disabled',true); //set button disable
                          var url;

                          if(save_method == 'add')
                          {
                            url = "<?php echo site_url('save_banco')?>";
                          }
                          else
                          {
                            url = "<?php echo site_url('update_banco')?>";
                          }

                           // ajax adding data to database
                           $.ajax({
                            url : url,
                            type: "POST",
                            data: $('#form').serialize(),
                            dataType: "JSON",
                            success: function(data)
                            {

                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
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
              <input type="hidden" value="" name="id_banco"/>
              <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
              <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
              <input type="hidden" value="" name="accion" id="accion"/>

              <div class="form-body">

                <div class="form-group">
                  <label class="control-label col-md-3">Rut</label>
                  <div class="col-md-9">
                    <input name="rut_banco" id="rut_banco" onblur="consulta_rut(this.value, 'banco');" placeholder="Rut" class="form-control" type="text" autocomplete="off">
                    <span class="help-block"></span>
                    <span class="rut-existente"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">Nombre</label>
                  <div class="col-md-9">
                    <input name="nombre_banco" id="nombre_banco" placeholder="Nombre" onblur="consulta_nombre(this.value, 'banco');" class="form-control" type="text" autocomplete="off">
                    <span class="help-block"></span>
                    <span class="nombre-existente"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">Moneda</label>
                  <div class="col-md-9">
                    <select name="id_moneda" id="id_moneda" class="form-control">

                      <option value="">--Seleccione--</option>
                       <?php
                       if(!empty($mostrar_moneda))
                       {
                           foreach ($mostrar_moneda as $m)
                           {
                               ?>
                               <option value="<?php echo $m->id_moneda ?>" <?php echo  set_select('id_moneda', $m->id_moneda); ?>><?php echo $m->nombre_moneda ?></option>
                               <?php
                           }
                       }
                       ?>
                    </select>
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">L&iacute;n. de Sobregiro</label>
                  <div class="col-md-9">
                    <input name="linea_sobregiro" placeholder="L&iacute;nea Sobregiro" class="form-control" type="text" autocomplete="off">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">L&iacute;nea de Cr&eacute;dito</label>
                  <div class="col-md-9">
                    <select name="id_linea_credito" id="id_linea_credito" class="form-control">

                      <option value="">--Seleccione--</option>

                       <?php
                       if(!empty($mostrar_linea_credito))
                       {
                           foreach ($mostrar_linea_credito as $lc)
                           {
                               ?>
                               <option value="<?php echo $lc->id_linea_credito ?>" <?php echo  set_select('id_linea_credito', $lc->id_linea_credito); ?>><?php echo $lc->nombre_linea_credito ?></option>
                               <?php
                           }
                       }
                       ?>
                    </select>
                    <span class="help-block"></span>
                  </div>
                </div>


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
                    <label class="col-sm-6 control-label">Usuario creaci&oacute;n Banco</label>
                    <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-6">Fecha creaci&oacute;n Banco</label>
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