        <?php

        if(!empty($data_movimiento_detalle))
        {
            foreach ($data_movimiento_detalle as $dmd)
            {
              $disabled = 'disabled="disabled"';
              $id_movimiento = $dmd->id_movimiento;
              $id_movimiento_detalle = $dmd->id_movimiento_detalle;
              $fecha_registro = $dmd->fecha_registro;
              $id_tipo_movimiento = $dmd->id_tipo_movimiento;
              $id_empresa_guarda = $dmd->id_empresa_guarda;
              $parametro1 = devuelve_parametro_fi($id_empresa_guarda);

              /*if($parametro1=='FECHA INGRESO AUTOMATICO'){
                $disabled_fi='disabled="disabled"';
                $is_disabled=1;
              }else{*/
                $disabled_fi='';
                $is_disabled=0;
              //}
              $id_cuenta = $dmd->id_cuenta;
              $cuenta_banco = $dmd->cuenta_banco;
              $monto_cuenta_banco = $dmd->monto_cuenta_banco;
              $nombre_cuenta = $dmd->nombre_cuenta;
              $id_subcuenta = $dmd->id_subcuenta;
              $nombre_subcuenta = $dmd->nombre_subcuenta;
              $id_tipo_documento = $dmd->id_tipo_documento;
              $nombre_tipo_documento = $dmd->nombre_tipo_documento;
              $numero_tipo_documento = $dmd->numero_tipo_documento;
              $monto = $dmd->monto;
              $fecha_ingreso = $dmd->fecha_ingreso;
              $fecha_ingreso_mostrar = fecha_espanol($dmd->fecha_ingreso);

              $fecha_pago = $dmd->fecha_pago;
              $mes_iva = $dmd->mes_iva;
              $año_iva = $dmd->año_iva;
              $id_tipo_estado_movimiento = $dmd->id_tipo_estado_movimiento;
              $nombre_tipo_estado_movimiento = $dmd->nombre_tipo_estado_movimiento;
              $id_banco = $dmd->id_banco;
              $nombre_banco = $dmd->nombre_banco;
              $id_condicion_pago = $dmd->id_condicion_pago;
              $nombre_condicion_pago = $dmd->nombre_condicion_pago;
              $numero_voucher = $dmd->numero_voucher;
              $observaciones = $dmd->observaciones;
              $accion = 'edit';
            }

        }else {

              $disabled = 'disabled="disabled"';
              $id_movimiento_detalle = $dmd->id_movimiento_detalle
              $fecha_registro = date("Y-m-d");
              $id_tipo_movimiento = '';
              $id_empresa_guarda = '';
              $id_cuenta = $id_c;
              (isset($cuenta_banco))? $cuenta_banco=$cuenta_banco->cuenta_banco:$cuenta_banco='';
              (isset($nombre_cuenta))? $nombre_cuenta=$nombre_cuenta->nombre_cuenta:$nombre_cuenta='';
              $id_subcuenta = $id_s;
              (isset($nombre_subcuenta))? $nombre_subcuenta=$nombre_subcuenta->nombre_subcuenta:$nombre_subcuenta='';
              $id_tipo_documento = '';
              $numero_tipo_documento = '';
              $monto = '';
              $fecha_ingreso = $fi;
              $fecha_pago = date("Y-m-d");
              $mes_iva = '';
              $año_iva = '';
              $id_tipo_estado_movimiento = '';
              $id_banco = '';
              $id_condicion_pago = '';
              $numero_voucher = '';
              $observaciones = '';
              $accion = 'agreg';
        }
        ?>

      
            <div class="page-content">
  
              <div class="page-header">
                <h1>
                  <i class="icon-arrow-down" style="color:green"></i> FORMULARIO DE INGRESO: <strong><?php
                  if($id_m){
                    echo $id_m;
                  }else {
                    echo $devuelve_ultimo_id_ingreso;
                  }
                  ?></strong>
                </h1>
              </div><!-- /.page-header -->
                
              <script>

              var save_method; //for save method string
              var base_url = '<?php echo base_url();?>';

              function volver(){

                var id_empresa = $('#id_empresa_guarda').val();

                $('#btnVolver').text('Volviendo...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable
                $('#btnReset').attr('disabled',true); //set button disable

                $(location).attr('href','<?php echo base_url() ?>ingreso/' + id_empresa);
              }

              function save()
              {

                $('#btnSave').text('Guardando...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable
                //$('#btnReset').attr('disabled',true); //set button disable
                var url;

                var formData = new FormData($('#form')[0]);
                var id_empresa = $('#id_empresa_guarda').val();
                var accion = $('#accion').val();

                if(accion == 'agreg')
                {
                  url = "<?php echo site_url('save_ingreso')?>";
                }
                else
                {
                  url = "<?php echo site_url('update_ingreso')?>";
                }

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
                          alert('Ingreso se guardo con exito.');
                          $(location).attr('href','<?php echo base_url() ?>ingreso/' + id_empresa);

                      }
                      else
                      {
                            for (var i = 0; i < data.inputerror.length; i++)
                            {
                                $('[id="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                $('[id="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                            }

                      }
                      $('#btnSave').text('Guardar'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable
                    },

                      error: function (jqXHR, textStatus, errorThrown)
                      {
                        alert('Error al guardar los datos.');
                        $('#btnSave').text('Guardando...'); //change button text
                        $('#btnSave').attr('disabled',false); //set button enable
                        $('#btnReset').attr('disabled',true); //set button disable
                        $('#btnVolver').attr('disabled',true); //set button disable
                      }
                    });
              }
              </script>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
                <form action="#" id="form" class="form-horizontal">
                  <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
                  <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                  <input type="hidden" value="<?php echo $id_movimiento;?>" name="id_movimiento" id="id_movimiento"/>
                  <input type="hidden" value="<?php echo $accion;?>" name="accion" id="accion"/>
                  <input type="hidden" value="<?php echo date("Y-m-d");?>" name="fecha_registro" id="fecha_registro"/>
                  <input type="hidden" value="<?php echo $id_cuenta;?>" name="id_cuenta" id="id_cuenta"/>
                  <input type="hidden" value="<?php echo $id_subcuenta;?>" name="id_subcuenta" id="id_subcuenta"/>

                    <div class="row">
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="fecha_registro">Fecha Registro</label>
                            <div class="input-group">
                              <input class="form-control date-picker" id="fecha_registro" disabled="disabled" name="fecha_registro" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_registro;?>"/>
                              <span class="input-group-addon">
                                <i class="icon icon-calendar bigger-110"></i>
                              </span>
                            </div>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="id_cuenta">Cuenta</label>
                        <select class="form-control" name="id_cuenta" id="id_cuenta" <?php echo $disabled;?>>
                           <?php
                             if(!empty($mostrar_cuenta))
                             {
                               if(empty($id_cuenta)){
                                 echo "<option value=''>--Seleccione--</option>";
                               }else {
                                 echo "<option value='$id_cuenta'>$nombre_cuenta</option>";
                               }
                                 /*foreach ($mostrar_cuenta as $mc)
                                 {
                                     ?>
                                     <option value="<?php echo $mc->id_cuenta ?>"><?php echo $mc->nombre_cuenta ?></option>
                                     <?php
                                 }*/
                             }
                           ?>
                        </select>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="id_subcuenta">Subcuenta</label>
                        <select class="form-control" id="id_subcuenta" name="id_subcuenta" <?php echo $disabled;?>>
                          <?php if(empty($id_subcuenta)){
                           echo "<option value=''>--Seleccione--</option>";
                          }else {
                            echo "<option value='$id_subcuenta'>$nombre_subcuenta</option>";
                          };?>
                        </select>
                      </div>
                    </div>

                      <?php
                      if(!empty($data_movimiento_detalle))
                      {

                      foreach ($data_movimiento_detalle as $dmd) {

                        $disabled = 'disabled="disabled"';
                        $id_movimiento = $dmd->id_movimiento;
                        $id_movimiento_detalle = $dmd->id_movimiento_detalle;
                        $fecha_registro = $dmd->fecha_registro;
                        $id_tipo_movimiento = $dmd->id_tipo_movimiento;
                        $id_empresa_guarda = $dmd->id_empresa_guarda;
                        $id_cuenta = $dmd->id_cuenta;
                        $cuenta_banco = $dmd->cuenta_banco;
                        $nombre_cuenta = $dmd->nombre_cuenta;
                        $id_subcuenta = $dmd->id_subcuenta;
                        $nombre_subcuenta = $dmd->nombre_subcuenta;
                        $id_tipo_documento = $dmd->id_tipo_documento;
                        $nombre_tipo_documento = $dmd->nombre_tipo_documento;
                        $numero_tipo_documento = $dmd->numero_tipo_documento;
                        $monto = $dmd->monto;
                        $fecha_ingreso = $dmd->fecha_ingreso;
                        $fecha_pago = $dmd->fecha_pago;
                        $mes_iva = $dmd->mes_iva;
                        $año_iva = $dmd->año_iva;
                        $id_tipo_estado_movimiento = $dmd->id_tipo_estado_movimiento;
                        $nombre_tipo_estado_movimiento = $dmd->nombre_tipo_estado_movimiento;
                        $id_banco = $dmd->id_banco;
                        $nombre_banco = $dmd->nombre_banco;
                        $id_condicion_pago = $dmd->id_condicion_pago;
                        $nombre_condicion_pago = $dmd->nombre_condicion_pago;
                        $numero_voucher = $dmd->numero_voucher;
                        $observaciones = $dmd->observaciones;
                        $accion = 'edit';

                        ?>

                    <div class="space-18"></div>



                    <div class="row">

                      <?php if($cuenta_banco == 1) {?>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label for="id_subcuenta">Monto Cuenta Banco</label>
                          <input type="text" class="form-control" id="monto_cuenta_banco" name="monto_cuenta_banco" placeholder="Monto" value="<?php echo $monto_cuenta_banco;?>">
                          <span class="help-block"></span>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label for="fecha_ingreso">Fecha de Ingreso</label>
                          <div class="input-group">
                            <input class="form-control fin" id="fecha_ingreso_0" name="fecha_ingreso[]" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_ingreso;?>"/>
                            <span class="input-group-addon">
                              <i class="icon icon-calendar bigger-110"></i>
                            </span>
                            <span class="help-block"></span>
                          </div>
                        </div>

                        </div>

                      <?php } else {?>

                      <input type="hidden" value="<?php echo count($data_movimiento_detalle);?>" name="cant_mov_det" id="cant_mov_det"/>
                      <input type="hidden" value="<?php echo $id_movimiento_detalle;?>" name="id_movimiento_detalle[]" id="id_movimiento_detalle"/>

                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="tipo_documento">Tipo de Documento</label>
                        <select name="id_tipo_documento[]" id="id_tipo_documento_0" class="form-control td">

                        <?php
                         if(!empty($mostrar_tipo_documento))
                         {

                           if(empty($id_tipo_documento)){
                            echo "<option value=''>--Seleccione--</option>";
                           }else {
                             echo "<option value='$id_tipo_documento'>[$nombre_tipo_documento]</option>";
                           }

                           foreach ($mostrar_tipo_documento as $td)
                             {
                               if($td->con_iva == 1){
                                 $con_iva = 1;
                               }else {
                                 $con_iva = '';
                               }
                                 ?>
                                 <option value="<?php echo $td->id_tipo_documento ?>" <?php echo  set_select('id_tipo_documento', $td->id_tipo_documento); ?>><?php echo $td->nombre_tipo_documento ?></option>
                                 <?php
                             }
                         }else {
                           echo "<option value=''>--Seleccione--</option>";
                         }
                         ?>

                      </select>
                      <span class="help-block"></span>
                      </div>

                      <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                        <label for="numero_tipo_documento">Nº</label>
                        <input type="text" class="form-control" id="numero_tipo_documento_0" name="numero_tipo_documento[]" title="numero_tipo_documento_0" placeholder="Numero" value="<?php echo $numero_tipo_documento;?>">
                        <span class="help-block"></span>
                      </div>

                      <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                        <label for="monto">Monto</label>
                        <input type="text" class="form-control" id="monto_0" name="monto[]" placeholder="Monto" value="<?php echo $monto; ?>">
                        <span class="help-block"></span>
                      </div>

                      <?php if(isset($is_disabled) == 1) { ?>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                              <label for="fecha_ingreso">Fecha de Ingreso 336</label>
                              <div class="input-group">
                                <span style="font-size:18px;"> <?php echo $fecha_ingreso_mostrar;?></span>
                                <input id="fecha_ingreso_0" name="fecha_ingreso[]" type="hidden" value="<?php echo $fecha_ingreso;?>"/>
                              </div>
                            </div>
                      <?php } else { ?>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label for="fecha_ingreso">Fecha de Ingreso 344</label>
                          <div class="input-group">
                            <input class="form-control fin" id="fecha_ingreso_0" name="fecha_ingreso[]" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_ingreso;?>" <?php echo $disabled_fi;?>/>
                            <span class="input-group-addon">
                              <i class="icon icon-calendar bigger-110"></i>
                            </span>
                            <span class="help-block"></span>
                          </div>
                        </div>
                      <!--<?php } ?>-->
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="fecha_pago">Fecha de Pago</label>
                        <div class="input-group">
                          <input class="form-control fin" id="fecha_pago_0" name="fecha_pago[]" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_pago;?>"/>
                          <span class="input-group-addon">
                            <i class="icon icon-calendar bigger-110"></i>
                          </span>
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                        <label for="mes_iva">IVA</label>
                        <select name="mes_iva[]" id="mes_iva_0" class="form-control">
                          <?php
                          if(empty($mes_iva)){
                           $mes=date("m");
                           $rango=2;
                           for ($i=$mes;$i<=$mes+$rango;$i++){
                              $meses=date('m', mktime(0, 0, 0, $i, 1, date("Y") ) );
                              echo "<option value='$meses'>$meses</option>";
                           }
                          }else {
                            echo "<option value='$mes_iva'>$mes_iva</option>";
                          }
                          ;?>
                        </select>
                      </div>

                      <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                        <label for="año_iva">&nbsp;</label>
                        <select name="año_iva[]" id="año_iva_0" class="form-control">
                          <?php
                          if(empty($año_iva)){
                           $anio=date("Y");
                           $rango=1;
                           for ($i=$anio;$i<=$anio+$rango;$i++){
                              $meses=date('Y', mktime(0, 0, 0, $i, 1, date("Y") ) );
                              echo "<option value='$anio'>$anio</option>";
                           }
                         }else {
                           echo "<option value='$año_iva'>$año_iva</option>";
                         }
                          ;?>
                        </select>
                        <span class="help-block"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="id_tipo_estado_movimiento">Estado</label>
                        <select name="id_tipo_estado_movimiento[]" id="id_tipo_estado_movimiento_0" class="form-control">
                           <?php
                           if(!empty($mostrar_estado_movimiento))
                           {
                             if(empty($id_tipo_estado_movimiento)){
                              echo "<option value=''>--Seleccione--</option>";
                             }else {
                               echo "<option value='$id_tipo_estado_movimiento'>[$nombre_tipo_estado_movimiento]</option>";
                             }
                             foreach ($mostrar_estado_movimiento as $tem)
                               {
                                   ?>
                                   <option value="<?php echo $tem->id_tipo_estado_movimiento ?>" <?php echo  set_select('id_tipo_estado_movimiento', $tem->id_tipo_estado_movimiento); ?>><?php echo $tem->nombre_tipo_estado_movimiento ?></option>
                                   <?php
                               }
                           }else {
                             echo "<option value=''>--Seleccione--</option>";
                           }
                           ?>
                        </select>
                        <span class="help-block"></span>
                      </div>

                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="id_banco">Banco</label>
                        <select name="id_banco[]" id="id_banco_0" class="form-control">
                           <?php
                           if(!empty($mostrar_banco))
                           {
                             if(empty($id_banco)){
                              echo "<option value=''>--Seleccione--</option>";
                             }else {
                               echo "<option value='$id_banco'>[$nombre_banco]</option>";
                             }

                               foreach ($mostrar_banco as $b)
                               {
                                   ?>
                                   <option value="<?php echo $b->id_banco ?>" <?php echo  set_select('id_banco', $b->id_banco); ?>><?php echo $b->nombre_banco ?></option>
                                   <?php
                               }
                           }
                           ?>
                        </select>
                        <span class="help-block"></span>
                      </div>

                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="id_condicion_pago">Condici&oacute;n de Pago</label>
                        <select name="id_condicion_pago[]" id="id_condicion_pago_0" class="form-control">
                           <?php
                           if(!empty($mostrar_condicion_pago))
                           {
                             if(empty($id_condicion_pago)){
                              echo "<option value=''>--Seleccione--</option>";
                             }else {
                               echo "<option value='$id_condicion_pago'>[$nombre_condicion_pago]</option>";
                             }

                               foreach ($mostrar_condicion_pago as $cp)
                               {
                                   ?>
                                   <option value="<?php echo $cp->id_condicion_pago ?>" <?php echo  set_select('id_condicion_pago', $cp->id_condicion_pago); ?>><?php echo $cp->nombre_condicion_pago ?></option>
                                   <?php
                               }
                           }
                           ?>
                        </select>
                        <span class="help-block"></span>
                      </div>

                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label for="numero_voucher">Nº de Voucher CT</label>
                        <input type="text" class="form-control" id="numero_voucher_0" name="numero_voucher[]" placeholder="Numero de Voucher" value="<?php echo $numero_voucher;?>">
                        <span class="help-block"></span>
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label for="observaciones">Observaciones</label>
                        <textarea type="textarea" class="form-control" name="observaciones[]" id="observaciones_0" placeholder="Observaciones"><?php echo $observaciones;?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="actions">
                           <a class="btn btn-sm btn-success clone"  id="clone_0" title="Agregar Nuevo Documento"><i class="icon icon-plus"></i></a>
                           <a class="btn btn-sm btn-danger remove"  id="remove_0" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                    </div>

                    <?php }?>
                    
                    <?php } ?>

                              <?php } else {

                                require('view_ingreso_add.php');

                              } ?>



                    <div class="clearfix form-actions">
                      <div class="col-md-offset-3 col-md-3">
                        <button class="btn btn-primary" type="button" id="btnVolver" onclick="volver()">
                          <i class="ace-icon icon icon-chevron-left bigger-110"></i>
                          Volver
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <button class="btn btn-primary" type="button" id="btnSave" onclick="save()">
                          <i class="ace-icon icon icon-ok bigger-110"></i>
                          Guardar
                        </button>

                        <!--&nbsp; &nbsp; &nbsp;
                        <button class="btn" type="reset" id="btnReset">
                          <i class="ace-icon icon icon-undo bigger-110"></i>
                          Limpiar
                        </button>
                        -->
                      </div>
                    </div>
                  </form>


								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
            </div><!-- /.row -->
            
          </div><!-- /.page-content -->
          
      </div><!-- /.main-content -->
      
      <!-- inline scripts related to this page -->
<script>
$(document).ready(function() {

//$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });

  $('.fin').datepicker({

  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });

  $('.fep').datepicker({

  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });

  $("#id_cuenta").change(function() {

    $("#id_cuenta option:selected").each(function() {
      id_cuenta = $('#id_cuenta').val();

      $.ajax({
        url : "<?php echo site_url('llena_subcuentas/')?>" + id_cuenta,
        type: "GET",
        success: function(data)
        {
            $("#id_subcuenta").html(data);

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos1.');
          }
        });

    });
  })


$.mask.definitions['~']='[+-]';

$("input").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
});
$("textarea").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
});
$("select").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).next().empty();
});

});

</script>
