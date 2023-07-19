
    
    <div class="main-content-inner">
    
          
        <div class="page-content">
          
          <div class="page-header">

            <h1>
              <i class="icon-th-large"></i> Mantenedor de Cuenta
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita cuentas.
              </small>
            </h1>

          </div><!-- /.page-header -->
          
          <div class="row">

            <div class="col-xs-12">

              <div class="row">
                <p><button class="btn btn-success" onclick="add_cuenta()"><i class="glyphicon glyphicon-plus"></i> Agregar Cuenta</button></p>
              </div>

              <div class="row">

                <div class="table-responsive">

                  <table id="table-cuenta" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nombre Cuenta</th>
                        <th>Cuenta Banco</th>
                        <th>Cuenta Pr&eacute;stamo</th>
                        <th>Tipo Movimiento</th>
                        <th style="width:75px;">Estado</th>
                        <th style="width:75px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

                </div><!-- /.table-responsive -->

              </div><!-- /.row -->
            
            </div><!-- /.col-xs-12 -->
          
          </div><!-- /.row -->
         
        </div><!-- /.page-content -->

    </div><!-- /.main-content-inner -->
    

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

      table = $('#table-cuenta').DataTable({


        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('lista_cuenta')?>/" + <?php echo $id_empresa;?>,
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },{
          "targets": [ 2 ], //last column
          "orderable": true, //set not orderable
          "className": "text-center",
          "width": "10%"
        },{
          "targets": [ 3 ], //last column
          "orderable": true, //set not orderable
          "className": "text-center",
          "width": "10%"
        },{
          "targets": [ 4 ], //last column
          "orderable": true, //set not orderable
          "className": "text-center"
        }
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

    function muestra_chk_banco(val){
      if(val==1){
        $('[name="cuenta_banco"]').prop('disabled', false);
      }else{
        $('[name="cuenta_banco"]').prop('checked', false);
        $('[name="cuenta_banco"]').prop('disabled', true);
      }
    }

    function add_cuenta()
    {
      $('[name="tipo_movimiento"]').parent().parent().removeClass('has-error');
      $('[name="tipo_movimiento"]').next().empty();
  
      $('[name="nombre_cuenta"]').parent().parent().removeClass('has-error');
      $('[name="nombre_cuenta"]').next().empty();

      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Agregar Cuenta'); // Set Title to Bootstrap modal title
      $("#accion").val("add");

      // HAmestica: Cargar orden de cuentas de tabla cuenta_orden
      $.ajax({
        url : "<?php echo site_url('ajax_get_orden_cuenta/')?>" + <?php echo $id_empresa;?> + '/0',
        type: "GET",
        success: function(data){
          $("#orden_cuenta").html(data);
        },
        error: function (jqXHR, textStatus, errorThrown){
          alert('Error al obtener orden de cuentas.');
        }
      });
    }

    function edit_cuenta(id)
    {
      $('[name="tipo_movimiento"]').parent().parent().removeClass('has-error');
      $('[name="tipo_movimiento"]').next().empty();
  
      $('[name="nombre_cuenta"]').parent().parent().removeClass('has-error');
      $('[name="nombre_cuenta"]').next().empty();
                                          
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_cuenta/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $("#accion").val("edit");
          $('[name="id_cuenta"]').val(data.id_cuenta);
          $('[name="nombre_cuenta"]').val(data.nombre_cuenta);
          if(data.cuenta_banco == 1){
              $('[id="id_tipo_cuenta_b"]').prop('checked', true);
          }

          if(data.cuenta_prestamo == 1){
              $('[id="id_tipo_cuenta_p"').prop('checked', true);
          }
          
          
          $('[name="tipo_movimiento"]').val(data.tipo_movimiento);
          $('[name="estado"]').val(data.estado);

          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Editar Cuenta'); // Set title to Bootstrap modal title

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos.');
          }
        });

        // HAmestica: Cargar orden de cuentas de tabla cuenta_orden
        $.ajax({
          url : "<?php echo site_url('ajax_get_orden_cuenta/')?>" + <?php echo $id_empresa;?> + '/' + id,
          type: "GET",
          success: function(data){
            $("#orden_cuenta").html(data);
          },
          error: function (jqXHR, textStatus, errorThrown){
            alert('Error al obtener orden de cuentas.');
          }
        });
    }

    function traza_cuenta(id)
    {

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_cuenta/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          
          var usuario_guarda = data.usuario_guarda;
          var fecha_guarda = data.fecha_guarda;

          var usuario_modifica = data.usuario_modifica;
          var fecha_modifica = data.fecha_modifica;
          

          $('#username_guarda').css("font-weight","Bold").html(": " + usuario_guarda);
          $('#fecha_guarda').css("font-weight","Bold").html(": " + fecha_guarda);
          $('#username_modifica').css("font-weight","Bold").html(": " + usuario_modifica);
          $('#fecha_modifica').css("font-weight","Bold").html(": " + fecha_modifica);

            $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text(data.nombre_cuenta); // Set title to Bootstrap modal title

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

    function reset(){
      $('#form')[0].reset(); // reset form on modals
    }
    function save()
    {
      $('#btnSave').text('Guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;

      if(save_method == 'add')
      {
        url = "<?php echo site_url('save_cuenta')?>";
      }
      else
      {
        url = "<?php echo site_url('update_cuenta')?>";
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
                          <input type="hidden" value="" name="id_cuenta"/>
                          <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                          <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                          <input type="hidden" value="" name="accion" id="accion"/>

                          <div class="form-body">
                            <div class="form-group">
                              <label class="control-label col-md-3">Tipo Movimiento</label>
                              <div class="col-md-9">
                                <select name="tipo_movimiento" class="form-control" onchange="muestra_chk_banco(this.value);">
                                  <option value="">Seleccione</option>
                                  <option value="1">INGRESO</option>
                                  <option value="2">EGRESO</option>
                                </select>
                                <span class="help-block"></span>
                              </div>
                            </div>     
                                              
                            <div class="form-group">
                              <label class="control-label col-md-3">Nombre</label>
                              <div class="col-md-9">
                                <input name="nombre_cuenta" id="nombre_cuenta" onblur="consulta_nombre(this.value, 'cuenta');" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                                <span class="help-block"></span>
                                <span class="nombre-existente"></span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="control-label col-md-3">Tipo de Cuenta</label>
                              <div class="col-md-9">
                                  <label>
                                    <input id="id_tipo_cuenta_b" name="id_tipo_cuenta[]" type="radio" class="ace" value="banco" />
                                    <span class="lbl">&nbsp;Cuenta Banco</span>
                                  </label>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3">&nbsp;</label>
                              <div class="col-md-9">
                                  <label>
                                    <input id="id_tipo_cuenta_p" name="id_tipo_cuenta[]" type="radio" class="ace" value="prestamo"/>
                                    <span class="lbl">&nbsp;Cuenta Pr&eacute;stamo</span>
                                  </label>
                              </div>
                            </div>

                            <!-- HAmestica: Agregar campo orden para tabla cuenta_orden -->
                            <div class="form-group">
                              <label class="control-label col-md-3">Orden</label>
                              <div class="col-md-9">
                                <select name="orden_cuenta" id="orden_cuenta" class="form-control">
                                  <option value="999">Seleccione</option>
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
                        <button type="button" id="btnReset" onclick="reset()" class="btn btn-default">Limpiar</button>
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
                              <label class="col-sm-6 control-label">Usuario creaci&oacute;n Cuenta</label>
                              <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-6">Fecha creaci&oacute;n Cuenta</label>
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

