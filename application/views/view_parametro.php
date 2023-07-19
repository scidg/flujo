<script src="<?php echo base_url() ?>js/mantenedor/mantenedor.js"></script>

<div class="page-content">
  <div class="page-header">
    <h1>
      <i class="icon-cogs"></i> Mantenedor de Par&aacute;metros
      <small>
        <i class="icon-double-angle-right"></i>
        &nbsp;crea, edita par&aacute;metros.
      </small>
    </h1>
  </div><!-- /.page-header -->
  <div class="row">
    <button class="btn btn-success" onclick="add_parametro()"><i class="glyphicon glyphicon-plus"></i> Agregar Par&aacute;metro</button>
    <br />
    <br />
    <div class="col-xs-12">
      <!-- PAGE CONTENT BEGINS -->
      <div class="row">
        <div class="table-responsive">
              <table id="table-parametro" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Grupo</th>
                  <th>Cant. opciones</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.page-content -->
  </div><!-- /.page-content -->
</div><!-- /.main-content -->



  <!-- inline scripts related to this page -->

  <script type="text/javascript">
  var save_method; //for save method string
  var table;
  var base_url = '<?php echo base_url();?>';

  $(document).ready(function() {

    $.mask.definitions['~']='[+-]';
    $('#nombre_empresa').mask('999999999');

    table = $('#table-parametro').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('lista_parametro')?>/" + <?php echo $id_empresa;?>,
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

  function add_parametro()
  {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar Par&aacute;metro'); // Set Title to Bootstrap modal title
  }

  function edit_parametro(id)
  {
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('#form')[0].reset(); // reset form on modals
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('ajax_edit_parametro/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {

        $('[name="id_parametro"]').val(data.id_parametro);
        $('[name="nombre_parametro"]').val(data.nombre_parametro);
        $('[name="comentario_parametro"]').val(data.comentario_parametro);
        $('[name="estado"]').val(data.estado);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Editar Parámetro'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error al obtener los datos');
        }
      });
  }
  
  function opcion_param(id)
  {
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('#form')[0].reset(); // reset form on modals
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('ajax_edit_parametro/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        
        $('[name="id_parametro"]').val(data.id_parametro);
        
        for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
          var opcion_parametro = data[i].opcion_parametro;
          
            $("#opcion_parametro_" + i).val(opcion_parametro);
        }

        $('#modal_form_opcion').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Editar Opciones'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error al obtener los datos');
        }
      });
  }

  function traza_parametro(id)
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
          $('.modal-title').text('Traza Par&aacute;metro código: ' + data.id_empresa); // Set title to Bootstrap modal title

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
      url = "<?php echo site_url('save_parametro')?>";
      modal = $('#modal_form');
      form = $('#form');
    }
    else if (save_method == 'opcion')
    {
      url = "<?php echo site_url('save_opciones')?>";
      modal = $('#modal_form_opcion');
      form = $('#form_opcion');
    }
    else
    {
      url = "<?php echo site_url('update_parametro')?>";
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
              $('#modal_form').modal('hide');
              alert('Ingreso se guardó con éxito.');
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

  <!-- Inicio modal nuevo -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Person Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id_parametro"/>
            <input type="hidden" value="" name="id_parametro_detalle"/>
            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Nombre</label>
                <div class="col-md-9">
                  <input name="nombre_parametro" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Comentario</label>
                <div class="col-md-9">
                  <textarea name="comentario_parametro" placeholder="Comentario del Par&aacute;metro" class="form-control"></textarea>
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
      </div>
    </div>
  </div> <!-- Termino modal nuevo -->

    <!-- Inicio modal opciones -->
    <div class="modal fade" id="modal_form_opcion" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Person Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form_opcion" class="form-horizontal">
            <input type="text" value="" name="id_parametro"/>
            <input type="text" value="" name="id_parametro_detalle"/>
            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
            <div class="form-body">


              <div class="bodyClone">
                <div id="clonedInput0" class="clonedInput">
                  <div class="form-group">
                    <label class="control-label col-md-3">Valor</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="opcion_parametro_0" name="opcion_parametro[]" placeholder="Valor" value="">
                      <span class="help-block"></span>
                    </div>
                    <div class="actions">
                      <a class="btn btn-sm btn-success clone"  id="clone_0" title="Agregar"><i class="icon icon-plus"></i></a>
                      <a class="btn btn-sm btn-danger remove"  id="remove_0" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
  </div> <!-- Termino modal opciones -->

  <!-- Inicio traza -->
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
                <label class="col-sm-6 control-label">Usuario creaci&oacute;n Par&aacute;metro</label>
                <label class="col-sm-6 control-label" id="username_guarda" style="text-align:left;"></label>
              </div>
              <div class="form-group">
                <label class="control-label col-md-6">Fecha creaci&oacute;n Par&aacute;metro</label>
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
      </div>
    </div>
  </div><!-- FIn traza -->
