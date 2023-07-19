
    <div class="main-content-inner">
        <div class="page-content">
          <div class="page-header">
            <h1>
              <i class="icon-file"></i> Mantenedor de Tipo de Documento
              <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;crea y edita tipos de documentos.

              </small>
            </h1>
          </div><!-- /.page-header -->

          <div class="row">
            <div class="col-xs-12">
              <!-- PAGE CONTENT BEGINS -->
              <div class="row">
              <p> <button class="btn btn-success" onclick="add_tipo_documento()"><i class="glyphicon glyphicon-plus"></i> Agregar Tipo de Documento</button>
</p>
            </div><!-- /.page-content -->
              <div class="row">

                <div class="table-responsive">

                      <table id="table-tipo-documento" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th style="width:50px;">Código</th>
                            <th>Nombre</th>
                            <th style="width:145px;">Es Prioritario</th>
                            <th style="width:145px;">Incluye IVA</th>
                            <th style="width:145px;">Es Nota de Cr&eacute;dito</th>
                            <th style="width:145px;">Es Obligatorio</th>
                            <th style="width:75px;">Color Celda</th>
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

        table = $('#table-tipo-documento').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('lista_tipo_documento')?>/" + <?php echo $id_empresa;?>,
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
      /*
      $("select").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });*/

      $('#color_tipo_documento').ace_colorpicker();

    });

    function add_tipo_documento()
    {
      $('[name="nombre_tipo_documento"]').parent().parent().removeClass('has-error');
      $('[name="nombre_tipo_documento"]').next().empty();

      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Agregar Tipo de Documento'); // Set Title to Bootstrap modal title
      $("#accion").val("add");
    }
    
    function edit_tipo_documento(id)
    {

      $('[name="nombre_tipo_documento"]').parent().parent().removeClass('has-error');
      $('[name="nombre_tipo_documento"]').next().empty();

      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_tipo_documento/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $("#accion").val("edit");
          $('[name="id_tipo_documento"]').val(data.id_tipo_documento);
          $('[name="nombre_tipo_documento"]').val(data.nombre_tipo_documento);
          if(data.es_prioritario == 1){
              $('[name="es_prioritario"]').prop('checked', true);
          }

          $('[name="color_tipo_documento"]').val(data.color_tipo_documento);
          
          if(data.con_iva == 1){
              $('[name="con_iva"]').prop('checked', true);
          }
          if(data.es_nota_credito == 1){
              $('[name="es_nota_credito"]').prop('checked', true);
          }          
          $('[name="estado"]').val(data.estado);
          
          if(data.es_obligatorio == 1){
              $('[name="es_obligatorio"]').prop('checked', true);
          }      

          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Editar Tipo de Documento'); // Set title to Bootstrap modal title

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos.');
          }
        });
    }
    function traza_tipo_documento(id)
    {

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('ajax_edit_tipo_documento/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

          $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
          $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
          $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
          $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

            $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text(data.nombre_tipo_documento); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('save_tipo_documento')?>";
      }
      else
      {
        url = "<?php echo site_url('update_tipo_documento')?>";
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
            <form action="#" id="form" name="form" class="form-horizontal">
              <input type="hidden" value="" name="id_tipo_documento"/>
              <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
              <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
              <input type="hidden" value="" name="accion" id="accion"/>
              <div class="form-body">

                <div class="form-group">
                  <label class="control-label col-md-4">Nombre</label>
                  <div class="col-md-8">
                    <input name="nombre_tipo_documento" id="nombre_tipo_documento" onblur="consulta_nombre(this.value, 'tipo_documento');"  class="form-control required" type="text" autocomplete="off">
                    <span class="help-block"></span>
                    <span class="nombre-existente"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-4">Es prioritario</label>
                  <div class="col-md-8">
                      <label>
                        <input name="es_prioritario" type="checkbox" class="ace" />
                        <span class="lbl">&nbsp;</span>
                      </label>
                      <span class="help-block"></span>
                  </div>
                </div>
              
                            
                <div class="form-group">
                  <label class="control-label col-md-4">Color celda</label>
                  <div class="col-md-8">
                  <select id="color_tipo_documento" name="color_tipo_documento" class="form-control">
                    <option value="#eee">#eee</option>
                    <option value="#d06b64">#d06b64</option>
                    <option value="#f83a22">#f83a22</option>
                    <option value="#fa573c">#fa573c</option>
                    <option value="#ff7537">#ff7537</option>
                    <option value="#ffad46">#ffad46</option>
                    <option value="#42d692">#42d692</option>
                    <option value="#16a765">#16a765</option>
                    <option value="#7bd148">#7bd148</option>
                    <option value="#b3dc6c">#b3dc6c</option>
                    <option value="#fbe983">#fbe983</option>
                    <option value="#fad165">#fad165</option>
                    <option value="#92e1c0">#92e1c0</option>
                    <option value="#9fe1e7">#9fe1e7</option>
                    <option value="#9fc6e7">#9fc6e7</option>
                    <option value="#4986e7">#4986e7</option>
                    <option value="#9a9cff">#9a9cff</option>
                    <option value="#b99aff">#b99aff</option>
                    <option value="#c2c2c2">#c2c2c2</option>
                    <option value="#cabdbf">#cabdbf</option>
                    <option value="#cca6ac">#cca6ac</option>
                    <option value="#f691b2">#f691b2</option>
                    <option value="#cd74e6">#cd74e6</option>
                    <option value="#a47ae2">#a47ae2</option>
                    <option value="#555">#555</option>
                  </select>
                </div>
              </div>

                <div class="form-group">
                  <label class="control-label col-md-4">I.V.A.</label>
                  <div class="col-md-8">
                      <label>
                        <input name="con_iva" type="checkbox" class="ace" />
                        <span class="lbl">&nbsp;</span>
                      </label>
                      <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-4">Es Nota de Cr&eacute;dito</label>
                  <div class="col-md-8">
                      <label>
                        <input name="es_nota_credito" type="checkbox" class="ace" />
                        <span class="lbl">&nbsp;</span>
                      </label>
                      <span class="help-block"></span>
                  </div>
                </div>     
                <div class="form-group">
                  <label class="control-label col-md-4">Es obligatorio</label>
                  <div class="col-md-8">
                      <label>
                        <input name="es_obligatorio" type="checkbox" class="ace" />
                        <span class="lbl">&nbsp;</span>
                      </label>
                      
                  </div>
                </div>                               
                <div class="form-group">
                  <label class="control-label col-md-4">Estado</label>
                  <div class="col-md-8">
                    <select name="estado" class="form-control">
                      <option value="">Seleccione</option>
                      <option value="1" selected="">ACTIVO</option>
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
                  <label class="col-sm-6 control-label">Usuario creaci&oacute;n Tipo de Documento</label>
                  <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-6">Fecha creaci&oacute;n Tipo de Documento</label>
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