
    
    <div class="main-content-inner">
<div class="page-content">
  <div class="page-header">
    <h1>
      <i class="icon-book"></i> Manual
      <small>
        <i class="icon-double-angle-right"></i>
        &nbsp;ultimos manuales cargados
      </small>
    </h1>
  </div><!-- /.page-header -->

  <div class="row">

              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
  
                <div class="row">

                  <div class="table-responsive">

                        <table id="table-manual" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>C&oacute;digo</th>
                              <th>M&oacute;dulo</th>
                              <th>Subm&oacute;dulo</th>
                              <th>Nombre</th>
							  <!--<th>Estado</th>-->
							  <th>Descargar</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>


                        </table>

                  </div><!-- /.table-responsive -->

                </div><!-- /.row -->
                </div><!-- /.row -->
              </div><!-- /.page-content -->


              </div><!-- /.main-content-inner -->


      <!-- inline scripts related to this page -->
      <script type="text/javascript">
      var save_method; //for save method string
      var table;

      $(document).ready(function() {

        table = $('#table-manual').DataTable({


          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.

          // Load data for the table's content from an Ajax source
          "ajax": {
            "url": "<?php echo site_url('lista_manual')?>/" + <?php echo $id_empresa;?>,
            "type": "POST"
          },

          //Set column definition initialisation properties.
          "columnDefs": [
          {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
			"className": "text-center",
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

      function add_manual()
      {

		$('[name="nombre_manual"]').parent().parent().removeClass('has-error');
		$('[name="nombre_manual"]').next().empty();

		$('[name="simbolo_manual"]').parent().parent().removeClass('has-error');
		$('[name="simbolo_manual"]').next().empty();

		$('[name="abreviatura_manual"]').parent().parent().removeClass('has-error');
		$('[name="abreviatura_manual"]').next().empty();

		$('[name="estado"]').parent().parent().removeClass('has-error');
		$('[name="estado"]').next().empty();
              
        save_method = 'add';
		
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Agregar Moneda'); // Set Title to Bootstrap modal title

        $("#accion").val("add");

      }

      function edit_manual(id)
      {
        $('[name="nombre_manual"]').parent().parent().removeClass('has-error');
        $('[name="nombre_manual"]').next().empty();

        $('[name="simbolo_manual"]').parent().parent().removeClass('has-error');
        $('[name="simbolo_manual"]').next().empty();

        $('[name="abreviatura_manual"]').parent().parent().removeClass('has-error');
        $('[name="abreviatura_manual"]').next().empty();

        $('[name="estado"]').parent().parent().removeClass('has-error');
        $('[name="estado"]').next().empty();
        
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
          url : "<?php echo site_url('ajax_edit_manual/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {

            $("#accion").val("edit");
            $('[name="id_manual"]').val(data.id_manual);
            $('[name="nombre_manual"]').val(data.nombre_manual);
            $('[name="simbolo_manual"]').val(data.simbolo_manual);
            if(data.id_posicion_manual == 1){
              $('[id="id_posicion_manual"]').prop('checked', true);
            }

            if(data.id_posicion_manual == 2){
                $('[id="id_posicion_manual"').prop('checked', true);
            }
            
              $('[name="estado"]').val(data.estado);

              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Editar Moneda'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error al obtener los datos.');
            }
          });
      }
	  
      function traza_manual(id)
      {

        //Ajax Load data from ajax
        $.ajax({
          url : "<?php echo site_url('ajax_edit_manual/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {

            $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
            $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
            $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
            $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

              $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text(data.nombre_manual); // Set title to Bootstrap modal title

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
          url = "<?php echo site_url('save_manual')?>";
        }
        else
        {
          url = "<?php echo site_url('update_manual')?>";
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
    <form action="#" id="form" class="form-horizontal">
      <input type="hidden" value="" name="id_manual"/>
      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
              <input type="hidden" value="" name="accion" id="accion"/>
              
      <div class="form-body">
        <div class="form-group">
          <label class="control-label col-md-3">Nombre</label>
          <div class="col-md-9">
            <input name="nombre_manual" id="nombre_manual" onblur="consulta_nombre(this.value, 'moneda');" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
            <span class="help-block"></span>
            <span class="nombre-existente"></span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">S&iacute;mbolo</label>
          <div class="col-md-9">
            <input name="simbolo_manual" placeholder="S&iacute;mbolo" class="form-control" type="text" autocomplete="off">
            <span class="help-block"></span>
          </div>
        </div>
        <div class="form-group">
                              <label class="control-label col-md-3">Posicion simbolo</label>
                              <div class="col-md-9">
                                  <label>
                                    <input id="id_posicion_manual" name="id_posicion_manual[]" type="radio" class="ace" value="1" />
                                    <span class="lbl">&nbsp;Izquierda del monto</span>
                                  </label>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3">&nbsp;</label>
                              <div class="col-md-9">
                                  <label>
                                    <input id="id_posicion_manual" name="id_posicion_manual[]" type="radio" class="ace" value="2"/>
                                    <span class="lbl">&nbsp;Derecha del monto</span>
                                  </label>
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
          <label class="col-sm-6 control-label">Usuario creaci&oacute;n Moneda</label>
          <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
        </div>
        <div class="form-group">
          <label class="control-label col-md-6">Fecha creaci&oacute;n Moneda</label>
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