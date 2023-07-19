<style>
#logo-prestamo{
  width:100px;
  text-align:center;
  padding:1px;
}
</style>

    <div class="main-content-inner">
<div class="page-content">
  <div class="page-header">
    <h1>
      <i class="icon-refresh"></i> Pr&eacute;stamo
      <small>
        <i class="icon-double-angle-right"></i>
        &nbsp;crea y edita pr&eacute;stamos.
      </small>
    </h1>
  </div><!-- /.page-header -->
  <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                  <p>
                    <button class="btn btn-success" onclick="add_prestamo()"><i class="glyphicon glyphicon-plus"></i> Agregar Pr&eacute;stamo</button>
              
                  <p>
                </div>
                
                <div class="row">

                  <div class="table-responsive">

                        <table id="table-prestamo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              
                              <th>Nombre</th>
                              <th>Fecha Coloc.</th>
                              <th>Tasa</th>
                              <th>Monto Sol.</th>
                              <th>Pie ($)</th>
                              <th>Monto Adeudado ($)</th>
                              <th>Valor Cuota ($)</th>
                              <th>Cuotas</th>
                              <th>C. Canceladas</th>
                              <th>C. Pendientes</th>
                              <th>Saldo ($)</th>
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

            $('.date-picker').datepicker({
              todayBtn: false,
              language: "es",
              autoclose: true,
              todayHighlight: false,
              daysOfWeekDisabled: "0,6",
              weekStart: 1
            })

              table = $('#table-prestamo').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [[ 0, 'asc' ]],
                // Load data for the table's content from an Ajax source
                "ajax": {
                  "url": "<?php echo site_url('lista_prestamo')?>/" + <?php echo $id_empresa;?>,
                  "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                  {
                    "targets": [ 0 ],
                    "className": "text-center",
                  },  
                  {
                    "targets": [ 1 ],
                    "className": "text-center",
                  },    
                  {
                    "targets": [ 2 ],
                    "className": "text-center",
                  },                  
                  {
                      "targets": [ 3 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 4 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 5 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 6 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 7 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 8 ],
                      "className": "text-center",
                  },
                  {
                      "targets": [ 9 ],
                      "className": "text-center",
                  },                                                      
                  {
                      "targets": [ 10 ],
                      "className": "text-center",
                  },
                  {
                  "targets": [ -1 ],
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

            });
            
            function add_prestamo()
            {
              save_method = 'add';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string
              
              $('#modal_form').modal('show'); // show bootstrap modal
              $('.modal-title').text('Agregar Préstamo'); // Set Title to Bootstrap modal title
            }

            function edit_prestamo(id)
            {
              save_method = 'update';
              $('.form-group').removeClass('has-error'); // clear error class
              $('#form')[0].reset(); // reset form on modals
              $('.help-block').empty(); // clear error string

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_edit_prestamo/')?>" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                  $('[name="id_cuenta_p"]').val(data.id_cuenta);
                  $('[name="id_prestamo"]').val(data.id_prestamo);
                  $('[name="nombre_prestamo"]').val(data.nombre_prestamo);
                  $('[name="fecha_colocacion"]').val(data.fecha_colocacion);
                  $('[name="tasa"]').val(data.tasa);
                  $('[name="monto_solicitado"]').val(data.monto_solicitado);
                  $('[name="id_moneda"]').val(data.id_moneda);
                  $('[name="pie"]').val(data.pie);
                  $('[name="valor_cuota"]').val(data.valor_cuota);
                  $('[name="cuotas"]').val(data.cuotas);
                  $('[name="dia_vencimiento"]').val(data.dia_vencimiento);
                  $('[name="observacion"]').val(data.observacion);
                  $('[name="estado"]').val(data.estado);

                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Editar Préstamo'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  alert('Error al obtener los datos');
                }
                });
            }

            function traza_prestamo(id)
            {

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_edit_prestamo/')?>/" + id,
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
            }

          
            function save()
            {
              $('#btnSave').text('Guardando...'); //change button text
              $('#btnSave').attr('disabled',true); //set button disable
              var url;

              if(save_method == 'add')
              {
                url = "<?php echo site_url('save_prestamo')?>";
                modal = $('#modal_form');
                form = $('#form');
                msg_alert = 'Préstamo guardado exitosamente!';
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
                url = "<?php echo site_url('update_prestamo')?>";
                modal = $('#modal_form');
                form = $('#form');
                msg_alert = 'Préstamo actualizado exitosamente!';
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
                        alert(msg_alert);
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
                      <input type="hidden" value="" name="id_prestamo"/>
                      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
                      <input type="hidden" value="1" name="id_holding" id="id_holding"/>

                      <div class="form-body">
                        
                        <div class="form-group">
                          <label class="control-label col-md-3">Cuenta</label>
                          <div class="col-md-9">
                            <select name="id_cuenta_p" id="id_cuenta_p" class="form-control">
                            <option value="">Seleccione</option>
                              <?php
                              if(!empty($mostrar_cuenta))
                              {
                                  foreach ($mostrar_cuenta as $lc)
                                  {
                                      ?>
                                      <option value="<?php echo $lc->id_cuenta ?>" <?php echo  set_select('id_cuenta_p', $lc->id_cuenta); ?>><?php echo $lc->nombre_cuenta ?></option>
                                      <?php
                                  }
                              }
                              ?>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3">Nombre</label>
                          <div class="col-md-9">
                            <input name="nombre_prestamo" id="nombre_prestamo" placeholder="Nombre" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>
  
                        <div class="form-group">
                          <label class="control-label col-md-3">Fecha Coloc.</label>
                          <div class="col-md-9">
                            <input name="fecha_colocacion" id="fecha_colocacion" placeholder="Fecha Coloc." class="form-control date-picker" type="text" value="" data-date-format="yyyy-mm-dd">                            
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Tasa</label>
                          <div class="col-md-9">
                            <input name="tasa" id="tasa" placeholder="Tasa" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>                
                        <div class="form-group">
                          <label class="control-label col-md-3">Monto Solic.</label>
                          <div class="col-md-9">
                            <input name="monto_solicitado" id="monto_solicitado" placeholder="Monto Solic." class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>  
                        <div class="form-group">
                          <label class="control-label col-md-3">Moneda</label>
                          <div class="col-md-9">
                          <select name="id_moneda" id="id_moneda" class="form-control">

                          <option value=""> Seleccione </option>
                          <?php
                          if(!empty($mostrar_moneda))
                          {
                              foreach ($mostrar_moneda as $m)
                              {
                                  ?>
                                  <option value="<?php echo $m->id_moneda ?>" <?php echo  set_select('id_moneda', $m->id_moneda); ?>><?php echo $m->nombre_moneda . " [".$m->simbolo_moneda."]" ?></option>
                                  <?php
                              }
                          }
                          ?>
                          </select>
                            <span class="help-block"></span>
                          </div>
                        </div>                           
                        <div class="form-group">
                          <label class="control-label col-md-3">Pie</label>
                          <div class="col-md-9">
                            <input name="pie" id="pie" placeholder="Pie" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>  
                        <div class="form-group">
                          <label class="control-label col-md-3">Cuotas</label>
                          <div class="col-md-9">
                            <input name="cuotas" id="cuotas" placeholder="Cuotas" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>                         
                        <div class="form-group">
                          <label class="control-label col-md-3">Valor Cuota</label>
                          <div class="col-md-9">
                            <input name="valor_cuota" id="valor_cuota" placeholder="Valor Cuota" class="form-control" type="text" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                        </div>  

                       <!-- <div class="form-group">
                          <label class="control-label col-md-3">D&iacute;a Vencimiento</label>
                          <div class="col-md-9">
                          <select name="dia_vencimiento" id="dia_vencimiento" class="form-control">
                          <option value=""> Seleccione </option>
                          <?php
                          $mes=1;
                          $rango=10;
                          for ($i=$mes;$i<=$rango;$i++){
                              echo "<option value='$i'>$i</option>";
                          }
                          ?>
                        </select>
                            <span class="help-block"></span>
                          </div>
                        </div>   -->                    
                        <div class="form-group">
                          <label class="control-label col-md-3">Observaci&oacute;n</label>
                          <div class="col-md-9">
                            <textarea type="textarea" class="form-control" name="observacion" id="observacion" placeholder="Observaci&oacute;n"></textarea>
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