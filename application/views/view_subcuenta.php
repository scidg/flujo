
    
    <div class="main-content-inner">
      
      <div class="page-content">
          
          <div class="page-header">
            <h1>
              <i class="icon-th"></i> Mantenedor de Subcuenta
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita subcuentas.
              </small>
            </h1>
          </div><!-- /.page-header -->

          <div class="row">
                             
                                <div class="col-xs-12">
                  
                                <div class="row">
                                <p><button class="btn btn-success" onclick="add_subcuenta()"><i class="glyphicon glyphicon-plus"></i> Agregar Subcuenta</button></p>
                                </div>

                                  <div class="row">

                                    <div class="table-responsive">

   <table id="table_subcuenta" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th style="width:50px;">ID Subcuenta</th>
                                    <th style="width:200px;">Nombre Cuenta</th>
                                    <th style="width:75px;">RUT</th>
                                    <th style="width:200px;">Nombre Subcuenta</th>
                                    <th style="width:75px;">Tipo Movimiento</th>
                                    <th style="width:70px;">Estado</th>
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

                          table = $('#table_subcuenta').DataTable({


                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.

                            // Load data for the table's content from an Ajax source
                            "ajax": {
                              "url": "<?php echo site_url('lista_subcuenta')?>/" + <?php echo $id_empresa;?>,
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

                          $("#tipo_movimiento_a").change(function() {

                            $("#tipo_movimiento_a option:selected").each(function() {
                              tm = $('#tipo_movimiento_a').val();
                              id_em = $('#id_empresa_guarda').val();
                              
                              $.ajax({
                                url : "<?php echo site_url('llena_cuentas/')?>" + tm + "/" + id_em,
                                type: "GET",
                                success: function(data)
                                  {
                                    $("#id_cuenta_a").html(data);

                                  },
                                  error: function (jqXHR, textStatus, errorThrown)
                                  {
                                    alert('Error al obtener los datos.');
                                  }
                                });

                            });
                            })

                        });

                        function add_subcuenta()
                        {
                          $('.form-group').removeClass('has-error'); // clear error class
                          save_method = 'add';
                          $('.help-block').empty(); // clear error string
                          
                          $('#form')[0].reset(); // reset form on modals
                          $('#modal_form').modal('show'); // show bootstrap modal
                          $('.modal-title').text('Agregar Subcuenta'); // Set Title to Bootstrap modal title
                          $('#nuevo').val(1);
                          $("#accion").val("add");
                        
                        }

                        function edit_subcuenta(id)
                        {
                          $('.form-group').removeClass('has-error'); // clear error class
                          save_method = 'update';
                          
                          $('.help-block').empty(); // clear error string
                          $('#form_edit')[0].reset(); // reset form on modals
                         

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_subcuenta/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                              $('#editar').val(1);
                              $("#accion").val("edit");
                              $('[name="tipo_movimiento"]').val(data.tipo_movimiento);
                              $('[name="tipo_movimiento_m"]').val(data.tipo_movimiento);
                              $('[name="id_cuenta"]').val(data.id_cuenta);
                              $('[name="id_cuenta_m"]').val(data.id_cuenta);
                              $('[name="nombre_tipo_movimiento"]').val(data.nombre_tipo_movimiento);
                              $('[name="nombre_cuenta"]').val(data.nombre_cuenta);
                              $('[name="id_subcuenta"]').val(data.id_subcuenta);
                              $('[name="rut_subcuenta"]').val(data.rut_subcuenta);
                              $('[name="nombre_subcuenta"]').val(data.nombre_subcuenta);
                              $('[name="estado"]').val(data.estado);

                              $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
                              $('.modal-title').text('Editar Subcuenta'); // Set title to Bootstrap modal title

                              },
                              error: function (jqXHR, textStatus, errorThrown)
                              {
                                alert('Error al obtener los datos.');
                              }
                            });
                        }

                        function traza_subcuenta(id)
                        {

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_subcuenta/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {

                              $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
                              $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
                              $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
                              $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

                                $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Traza Subcuenta código: ' + data.id_subcuenta); // Set title to Bootstrap modal title

                              },
                              error: function (jqXHR, textStatus, errorThrown)
                              {
                                alert('Error al obetener los datos.');
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
                            url = "<?php echo site_url('save_subcuenta')?>";
                            form = $('#form');
                            modal = $('#modal_form');
                          }
                          else
                          {
                            url = "<?php echo site_url('update_subcuenta')?>";
                            form = $('#form_edit');
                            modal = $('#modal_form_edit');
                          }

                           // ajax adding data to database

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
                                  alert('Error al guardar o actulizar los datos');
                                  $('#btnSave').text('Guardar'); //change button text
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
                                <input type="hidden" value="" name="id_subcuenta"/>
                                <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                                <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                                <input type="hidden" value="" name="nuevo" id="nuevo"/>
                                <input type="hidden" value="" name="accion" id="accion"/>

                                <div class="form-body">

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Tipo Movimiento</label>
                                    <div class="col-md-9">
                                      <select id="tipo_movimiento_a" name="tipo_movimiento_a" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="1">INGRESO</option>
                                        <option value="2">EGRESO</option>
                                      </select>
                                      <span class="help-block"></span>
                                    </div>
                                  </div> 

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Cuenta</label>
                                    <div class="col-md-9">
                                      <select name="id_cuenta_a" id="id_cuenta_a" class="form-control">
                                        <option value="">Seleccione</option>
                                      </select>
                                      <span class="help-block"></span>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3">RUT</label>
                                    <div class="col-md-9">
                                      <input name="rut_subcuenta" placeholder="RUT" class="form-control" type="text" autocomplete="off">
                                      <span class="help-block"></span>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Nombre</label>
                                    <div class="col-md-9">
                                      <input name="nombre_subcuenta" id="nombre_subcuenta" onblur="consulta_nombre(this.value, 'subcuenta');"  placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                                      <span class="help-block"></span>
                                      <span class="nombre-existente"></span>
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

                          <!-- Bootstrap modal -->

                        <div class="modal fade" id="modal_form_edit" role="dialog">
                          <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h3 class="modal-title">Person Form</h3>
                            </div>
                            
                            <div class="modal-body form">
                              <form action="#" id="form_edit" class="form-horizontal">
                                <input type="hidden" value="" name="id_subcuenta"/>
                                <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                                <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                                <input type="hidden" value="" name="editar" id="editar"/>
                                <input name="tipo_movimiento" id="tipo_movimiento" type="hidden" value="" >
                                <input name="id_cuenta" id="id_cuenta" type="hidden" value="">
                                     
                                <div class="form-body">

                                 <div class="form-group">
                                    <label class="control-label col-md-3">Tipo Movimiento</label>
                                    <div class="col-md-9">
                                      <select id="tipo_movimiento_m" name="tipo_movimiento_m" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="1">INGRESO</option>
                                        <option value="2">EGRESO</option>
                                      </select>
                                      <span class="help-block"></span>
                                    </div>
                                  </div> 

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Cuenta</label>
                                    <div class="col-md-9">
                                      <select name="id_cuenta_m" id="id_cuenta_m" class="form-control">
                                        <option value="">Seleccione</option>
                                                                <?php
                                              if(!empty($mostrar_cuentas))
                                              {
                                                  foreach ($mostrar_cuentas as $m)
                                                  {
                                                      ?>
                                                      <option value="<?php echo $m->id_cuenta ?>" <?php echo  set_select('id_moneda', $m->id_cuenta); ?>><?php echo $m->nombre_cuenta ?></option>
                                                      <?php
                                                  }
                                              }
                                              ?>
                                      </select>
                                      <span class="help-block"></span>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3">RUT</label>
                                    <div class="col-md-9">
                                      <input name="rut_subcuenta" placeholder="RUT" class="form-control" type="text" autocomplete="off">
                                      <span class="help-block"></span>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Nombre</label>
                                    <div class="col-md-9">
                                      <input name="nombre_subcuenta" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
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
                    <label class="col-sm-6 control-label">Usuario creaci&oacute;n Subcuenta</label>
                    <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-6">Fecha creaci&oacute;n Subcuenta</label>
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