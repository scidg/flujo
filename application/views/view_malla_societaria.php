
    
    <div class="main-content-inner">

        <div class="page-content">
          <div class="page-header">
            <h1>
              <i class="icon-globe"></i> Mantenedor de Malla Societaria
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita socios.
              </small>
            </h1>
          </div><!-- /.page-header -->

          <div class="row">
                              
                                <div class="col-xs-12">
                                  <!-- PAGE CONTENT BEGINS -->
                                  <div class="row">
                                  <p><button class="btn btn-success" onclick="add_malla_societaria()"><i class="glyphicon glyphicon-plus"></i> Agregar Socio</button>
</p>
                                </div><!-- /.page-content -->

                                  <div class="row">

                                    <div class="table-responsive">

                                          <table id="table-malla-societaria" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Código</th>
                                    <th>Rut Socio</th>
                                    <th>Nombre Socio</th>
                                    <th>Empresa</th>
                                    <th>Porcentaje Socio</th>
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

                          table = $('#table-malla-societaria').DataTable({


                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.

                            // Load data for the table's content from an Ajax source
                            "ajax": {
                              "url": "<?php echo site_url('lista_malla_societaria')?>/" + <?php echo $id_empresa;?>,
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

                        function add_malla_societaria()
                        {
                          $('.form-group').removeClass('has-error'); // clear error class
                          save_method = 'add';
                          $('.help-block').empty(); // clear error string
                          
                          $('#form')[0].reset(); // reset form on modals
                          $('#modal_form').modal('show'); // show bootstrap modal
                          $('.modal-title').text('Agregar Socio'); // Set Title to Bootstrap modal title
                          $("#accion").val("add");
                        }

                        function edit_malla_societaria(id)
                        {
                          $('.form-group').removeClass('has-error'); // clear error class
                          save_method = 'update';
                          $('#form')[0].reset(); // reset form on modals
                          $('.help-block').empty(); // clear error string

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_malla_societaria/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                              $("#accion").val("edit");
                              $('[name="id_socio"]').val(data.id_socio);
                              $('[name="rut_socio"]').val(data.rut_socio);
                              $('[name="nombre_socio"]').val(data.nombre_socio);
                              $('[name="id_empresa"]').val(data.id_empresa);
                              $('[name="porcentaje_socio"]').val(data.porcentaje_socio);
                              $('[name="estado"]').val(data.estado);

                                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Editar Socio'); // Set title to Bootstrap modal title

                              },
                              error: function (jqXHR, textStatus, errorThrown)
                              {
                                alert('Error al obtener los datos.');
                              }
                            });
                        }
                        function traza_malla_societaria(id)
                        {

                          //Ajax Load data from ajax
                          $.ajax({
                            url : "<?php echo site_url('ajax_edit_malla_societaria/')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {

                              $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
                              $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
                              $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
                              $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

                                $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text(data.nombre_socio); // Set title to Bootstrap modal title

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
                            url = "<?php echo site_url('save_malla_societaria')?>";
                          }
                          else
                          {
                            url = "<?php echo site_url('update_malla_societaria')?>";
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
                        <!-- Bootstrap modal -->
                        <div class="modal fade" id="modal_form" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Person Form</h3>
                              </div>
                              <div class="modal-body form">
                                <form action="#" id="form" name="form" class="form-horizontal">
                                  <input type="hidden" value="" name="id_socio"/>
                                  <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                                  <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                                  <input type="hidden" value="" name="accion" id="accion"/>

                                  <div class="form-body">
                                    <div class="form-group">
                                      <label class="control-label col-md-3">RUT</label>
                                      <div class="col-md-9">
                                        <input name="rut_socio" placeholder="RUT" class="form-control" type="text" value="" autocomplete="off">
                                        <span class="help-block"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3">Nombre</label>
                                      <div class="col-md-9">
                                        <input name="nombre_socio" id="nombre_socio" onblur="consulta_nombre(this.value, 'malla_societaria');" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                        <span class="nombre-existente"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3">Empresa</label>
                                      <div class="col-md-9">
                                        <select name="id_empresa" id="id_empresa" class="form-control">

                                          <option value="">--Seleccione--</option>

                                           <?php
                                           if(!empty($mostrar_empresas))
                                           {
                                               foreach ($mostrar_empresas as $cl)
                                               {
                                                   ?>
                                                   <option value="<?php echo $cl->id_empresa ?>" <?php echo  set_select('id_empresa', $cl->id_empresa); ?>><?php echo $cl->nombre_empresa ?></option>
                                                   <?php
                                               }
                                           }
                                           ?>
                                        </select>
                                        <span class="help-block"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3">Porcentaje</label>
                                      <div class="col-md-9">
                                        <input name="porcentaje_socio" placeholder="Porcentaje" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
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
                                      <label class="col-sm-6 control-label">Usuario creaci&oacute;n Socio</label>
                                      <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-6">Fecha creaci&oacute;n Socio</label>
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