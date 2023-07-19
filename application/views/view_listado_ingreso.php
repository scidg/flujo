
    <div class="main-content-inner">
<div class="page-content">
  <div class="page-header">
    <h1>
      <i class="icon-th-list"></i> Ingresos
                          <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;listado.
              </small>
    </h1>
  </div><!-- /.page-header -->
  <div class="row">
             
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                <div class="row">

                  <div class="table-responsive">

                        <table id="table-listado" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="text-align: center;">Nº de Movimiento</th>
                  <th style="text-align: center;">Cuenta</th>
                  <th style="text-align: center;">Subcuenta</th>
                  <th style="text-align: center;">Fecha Registro</th>
                  <th>Estado</th>
                  <th>Ver Detalle</th>
                  <th>Ver Traza</th>
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



              table = $('#table-listado').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.

                // Load data for the table's content from an Ajax source
                "ajax": {
                  "url": "<?php echo site_url('lista_ingreso')?>/" + <?php echo $id_empresa;?>,
                  "type": "POST"
                },

                //Set column definition initialisation properties.
                  "columnDefs": [
                  
                  {
                    "targets": [ 0 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "6%"
                  },
                  {
                    "targets": [ 1 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-left",
                    "width": "10%"
                  },
                  {
                    "targets": [ 2 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-left",
                    "width": "15%"
                  },
                  {
                    "targets": [ 3 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "6%"
                  },
                  {
                    "targets": [ 4 ], //last column
                    "orderable": true, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  },
                  {
                    "targets": [ 5 ], //last column
                    "orderable": false, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  },
                  {
                    "targets": [ 6 ], //last column
                    "orderable": false, //set not orderable
                    "className": "text-center",
                    "width": "5%"
                  }
                ],

              });


            });


    function activar(id)
    {
      bootbox.confirm("¿Está seguro de volver a Activar este Movimiento?", function(result) {
      if(result) {
          $.ajax({
              url : "<?php echo site_url('activar_ingreso')?>",
              type: "POST",
              data: {id_movimiento: id},
              success: function(data)
                  {
                    reload_table();
                  },
              error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error al activar.');
                  }
          });
      }
    });
   }


            function traza_ingreso(id)
            {

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('ajax_data_ingreso/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                  $('#username_guarda').css("font-weight","Bold").html(": " + data.usuario_guarda);
                  $('#fecha_guarda').css("font-weight","Bold").html(": " + data.fecha_guarda);
                  $('#username_modifica').css("font-weight","Bold").html(": " + data.usuario_modifica);
                  $('#fecha_modifica').css("font-weight","Bold").html(": " + data.fecha_modifica);

                    $('#modal_form_traza').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Traza Ingreso'); // Set title to Bootstrap modal title

                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error al obtener los datos.');
                  }
                });
            }

            function detalle_ingreso(id)
            {

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo site_url('get_detalle_ingreso/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                  table_docs = '<table class="table table-striped table-bordered table-hover width="100%"><thead><tr><th>Fecha Ingreso</th><th>Monto</th><th>Monto Cuenta Banco</th><th>Estado</th></tr></thead><tbody>';

                  for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
                            
                            var fecha_ingreso = data[i].fecha_ingreso;
                            var monto = data[i].monto;
                            var monto_cuenta_banco = data[i].monto_cuenta_banco;
                            var estado = data[i].estado;
                            var nombre_tipo_estado_movimiento = data[i].nombre_tipo_estado_movimiento;

                            if(nombre_tipo_estado_movimiento == 'PAGADO'){
                              color_back = 'style="background-color:#FFFF00;"';
                            }else{
                              color_back = 'style="background-color:#EEEEEE;"';
                            }

                            table_docs += "<tr><td>"+fecha_ingreso+"</td><td>$ "+formatNumber(monto)+"</td><td>"+formatNumber(monto_cuenta_banco)+"</td><td "+color_back+">"+nombre_tipo_estado_movimiento+"</td></tr>";

                          }

                          table_docs += '</tbody></table>';
                          $("#table_docs").html(table_docs);
                    
                    $('#modal_form_detalle').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Detalle Movimiento: '+id); // Set title to Bootstrap modal title

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

            


                    </script>


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

            <!-- Ventana modal Detalle Movimiento -->
              <div class="modal fade" id="modal_form_detalle" role="dialog">
                  
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header no-padding">
                        
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h3 class="modal-title">Person Form</h3>
                        </div>

                      </div>

                      <div class="modal-body">
                            <div id="table_docs"></div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                      </div>
                    
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div>
                </div><!-- /.main-content-inner -->