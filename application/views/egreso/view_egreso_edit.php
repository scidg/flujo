<input type="hidden" value="<?php echo $m_fi;?>" name="input_mes_fi" id="input_mes_fi"/>
<input type="hidden" value="<?php echo $a_fi;?>" name="input_anio_fi" id="input_anio_fi"/>
<input type="hidden" value="<?php echo $idmov;?>" name="idmov" id="idmov"/>  
<input type="hidden" value="<?php echo $id_m;?>" name="id_movimiento_ed" id="id_movimiento_ed"/>
<input type="hidden" value="<?php echo $id_me;?>" name="id_movimiento_e_ed" id="id_movimiento_e_ed"/>  
<input type="hidden" value="<?php echo count($data_movimiento_sinrango);?>" name="cant_mov_det2" id="cant_mov_det2"/>

<div class="bodyClone">

<?php

if(!empty($data_movimiento_sinrango)){

  $j=0;
  
    foreach ($data_movimiento_sinrango as $dmd) {
      
      $disabled = 'disabled="disabled"';
      $id_movimiento = $dmd->id_movimiento;
      $id_movimiento_detalle = $dmd->id_movimiento_detalle;
      $id_movimiento_detalle_max = 2;
      $fecha_registro = $dmd->fecha_registro;
      $id_tipo_movimiento = $dmd->id_tipo_movimiento;
      $id_empresa_guarda = $dmd->id_empresa_guarda;
      $id_cuenta = $dmd->id_cuenta;
      $cuenta_banco = $dmd->cuenta_banco;
      $nombre_cuenta = $dmd->nombre_cuenta;
      $id_subcuenta = $dmd->id_subcuenta;
      $nombre_subcuenta = $dmd->nombre_subcuenta;
      $id_tipo_documento = $dmd->id_tipo_documento;
      $es_obligatorio = $dmd->es_obligatorio;      
      $nombre_tipo_documento = $dmd->nombre_tipo_documento;
      $tipo_documento_con_iva = $dmd->con_iva;

      if($tipo_documento_con_iva == 1){
        $visible = 'style="visibility:show;"';
        $aviso_visible = 'style="visibility:hidden;"';
        $texto_iva = 'con iva';
      }else{
        $visible = 'style="visibility:hidden;"';
        $aviso_visible = 'style="visibility:show;"';
        $texto_iva = 'sin iva';      
      }

      $tipo_documento_nota_credito = $dmd->es_nota_credito;
      if($tipo_documento_nota_credito == 1){
        $texto_nota_credito = 1;
      }else{
        $texto_nota_credito = 0;     
      }

      $numero_tipo_documento = $dmd->numero_tipo_documento;
      $monto = $dmd->monto;
      if($monto == 0){
        $monto = $dmd->monto_nota_credito;
      }else{
        $monto = $monto;
      }
      $fecha_ingreso = fecha_espanol($dmd->fecha_ingreso);
      list($d_fi,$m_fi,$a_fi) = explode("-",$fi);

      if( ($fi<=$dmd->fecha_ingreso) && ($ft>=$dmd->fecha_ingreso) ){
        $disabled_camp = 'disabled="disabled"';
        $background_camp = 'style="background:#FFFF33;"';
        $bandera_fi = '<i class="icon-plus-sign"></i>';
        $bandera_fp = '';
        $alert = 'alert alert-warning';

      }else{
        $disabled_camp = '';
        $background_camp = 'style=""';
        $bandera_fi = '';
        $bandera_fp = '';
        $alert = '';
      }

      $fecha_pago = $dmd->fecha_pago;
      if($fecha_pago == '0000-00-00' || $fecha_pago == '00-00-0000'){
        $fecha_pago = '';
        $background_fp = 'style=""';
      }else{

        //if($fi==$dmd->fecha_pago){
        if( ($fi<=$dmd->fecha_pago) && ($ft>=$dmd->fecha_pago) ){
          $background_fp = 'style="background:#FFFF33;"';
          $bandera_fp = '<i class="icon-usd"></i>';
          $fecha_pago = fecha_espanol($fecha_pago);
        }else{
          $bandera_fp = '';
          $fecha_pago = fecha_espanol($fecha_pago);
          $background_fp = 'style=""';
        }
  
      }
      
      $mes_iva = $dmd->mes_iva;
      $año_iva = $dmd->año_iva;

      //echo $j."-".$mes_iva."-".$año_iva;        

      $id_tipo_estado_movimiento = $dmd->id_tipo_estado_movimiento;
      $nombre_tipo_estado_movimiento = $dmd->nombre_tipo_estado_movimiento;
      $id_banco = $dmd->id_banco;
      $nombre_banco = $dmd->nombre_banco;
      $id_condicion_pago = $dmd->id_condicion_pago;
      $nombre_condicion_pago = $dmd->nombre_condicion_pago;
      $numero_voucher = $dmd->numero_voucher;
      $observaciones = $dmd->observaciones;
      if($_SESSION['egr_mov_edi']==1){
        $solo_lectura = '';
      }else{
        $solo_lectura = 'disabled="disabled"';

      }
?>
                    


  <div id="<?php echo "clonedInput".$j;?>" class="clonedInput">

    <div class="space-4"></div>

        <?php if($cuenta_banco == 1) {?>
          
          <div class="row"><!-- Inicia row Es Cuenta Banco -->
            
            <input type="hidden" value="<?php echo count($data_movimiento_detalle);?>" name="cant_mov_det" id="cant_mov_det"/>
            <input type="hidden" value="<?php echo $id_movimiento_detalle;?>" name="id_movimiento_detalle[]" id="id_movimiento_detalle"/>

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

          </div><!-- Termina row Es Cuenta Banco -->

        <?php } else {?>
          <div class="widget-box" >
												<div class="widget-header" >
                        <h4 class="widget-title">Detalle del Movimiento</h4>
                      <div class="widget-toolbar">
															
													</div>
												</div>

												<div class="widget-body">
													<div class="widget-main">
                            
          <div class="row" style=""> <!-- Inicia row Tipo de Documento -->

            
            <input type="hidden" value="<?php echo $id_movimiento_detalle;?>" name="id_movimiento_detalle[]" id="<?php echo "id_movimiento_detalle_".$j;?>"/>
            
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label for="tipo_documento">Tipo de Documento</label>
              <select <?php echo $solo_lectura;?> name="id_tipo_documento[]" id="<?php echo "id_tipo_documento_".$j;?>" class="form-control td" onchange="periodo_iva_edit(this.value,this.id);">
              <?php
                if(!empty($mostrar_tipo_documento))
                {

                  if(empty($id_tipo_documento)){
                    echo "<option value=''>--Seleccione--</option>";
                  }else {
                    echo "<option value=''>--Seleccione--</option>";
                    echo "<option value='$id_tipo_documento' selected='selected'>$nombre_tipo_documento</option>";
                    
                  }

                  foreach ($mostrar_tipo_documento as $td)
                    {
                      if($td->con_iva == 1){
                        $con_iva = 1;
                      }else {
                        $con_iva = '';
                      }
                        
                      if($td->id_tipo_documento != $id_tipo_documento){ ?>
                        <option value="<?php echo $td->id_tipo_documento ?>"><?php echo $td->nombre_tipo_documento ?></option>
                        <?php 
                      }
                    }

                }else {

                  echo "<option value=''>--Seleccione--</option>";

                }
                ?>
              </select>
              <span class="help-block"></span>
              <input type="hidden" name="es_nota_credito[]" id="es_nota_credito_0" value="<?php echo $texto_nota_credito;?>">
              
            </div>

            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
              <label for="numero_tipo_documento">Nº</label>
              <input <?php echo $solo_lectura;?> type="text" class="form-control" id=<?php echo "numero_tipo_documento_".$j;?> name="numero_tipo_documento[]" placeholder="Numero" value="<?php echo $numero_tipo_documento;?>">
              <span class="help-block"></span>
              <input type="hidden" value="<?php echo $es_obligatorio;?>" name="es_obligatorio[]" id="<?php echo "es_obligatorio_".$j;?>"/>
            </div>

            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
              <label for="monto">Monto</label>
              <input <?php echo $solo_lectura;?> type="text" class="form-control" id="<?php echo "monto_".$j;?>" name="monto[]" placeholder="Monto" value="<?php echo $monto; ?>">
              <span class="help-block"></span>
            </div>

            <?php if(isset($is_disabled) == 1) { ?>
            
              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <label for="fecha_ingreso">Fecha de Ingreso</label>

                <input <?php echo $solo_lectura;?> class="form-control date-picker" id=<?php echo "fecha_ingreso_".$j;?> name="fecha_ingreso[]" type="text"  data-date-format="dd-mm-yyyy" value="<?php echo $fecha_ingreso;?>" onchange="cambia_fecha(this.id, this.value);"/>
                <input id=<?php echo "fecha_ingreso_2_".$j;?> name="fecha_ingreso_2[]" type="hidden" value="<?php echo $fecha_ingreso;?>"/>
              </div>

            <?php } else { ?>

              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <label for="fecha_ingreso">Fecha de Ingreso</label>
                  <input <?php echo $solo_lectura;?> class="form-control date-picker" id=<?php echo "fecha_ingreso_".$j;?> name="fecha_ingreso[]" type="text"  data-date-format="dd-mm-yyyy" value=""/>
                  <span class="help-block"></span>
              </div>

            <?php } ?>

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label for="fecha_pago">Fecha de Pago</label>
                <input <?php echo $solo_lectura;?> class="form-control date-picker" id=<?php echo "fecha_pago_".$j;?> name="fecha_pago[]" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $fecha_pago;?>"/>
              <span class="help-block"></span>
            </div>
            
            <!--<div id="<?php echo "aviso_iva_".$j;?>" <?php echo $aviso_visible; ?>>
              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <label for="aviso_visible">&nbsp;</label>
                <div class="input-group">
                  hola
                </div>
              </div>
            </div>-->

            <div id="<?php echo "periodo_iva_".$j;?>" class="iva" <?php echo $visible; ?>>
            
            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
              <label for="mes_iva">IVA</label>
              <select <?php echo $solo_lectura;?> name="mes_iva[]" id=<?php echo "mes_iva_".$j;?> class="form-control">
              
              <?php if($mes_iva > 0){ ?>
              <option value="<?php echo $mes_iva; ?>"><?php echo $mes_iva; ?></option>
              <?php } else{ ?>
              <?php } 
                 $mes=$m_fi;
                 $rango=2;
                 for ($i=$mes;$i<=$mes+$rango;$i++){
                     $meses=date('m', mktime(0, 0, 0, $i, 1, date("Y") ) );
                     if($meses != $mes_iva){
                      echo "<option value='$meses'>$meses</option>";
                     }
                 }
                ?>
              </select>
            </div>

            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
              <label for="año_iva">&nbsp;</label>
              <select <?php echo $solo_lectura;?> name="año_iva[]" id=<?php echo "año_iva_".$j;?> class="form-control">
              
              <?php if($año_iva > 0){?>
              <option value="<?php echo $año_iva; ?>"><?php echo $año_iva; ?></option>
              <?php } else{ ?>
              <option value="0">Año</option>
              <?php } ;
                 $anio=$a_fi;
                 $rangoa=1;
                 for ($ia=$anio;$ia<=$anio+$rangoa;$ia++){
                     $anos=date('Y', mktime(0, 0, 0, 1, 1, $ia ) );
                     if($anos != $año_iva){
                     echo "<option value='$anos'>$anos</option>";
                     }
                 }
                ?>
                
              </select>
            </div>
          </div>
          <input type="hidden" value="" name="iva_disabled[]" id="<?php echo "iva_disabled_".$j;?>"/>
        </div><!-- Termina row Tipo de Documento -->

          <div class="row" style=""><!-- Inicia row Estado de Documento -->

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label for="id_tipo_estado_movimiento">Estado</label>
              <select <?php echo $solo_lectura;?> name="id_tipo_estado_movimiento[]" id="<?php echo "id_tipo_estado_movimiento_".$j;?>" class="form-control"
              onchange="limpmia_pendiente(this.value,this.id);">
              <?php
                if(!empty($mostrar_estado_movimiento))
                {

                  if(empty($id_tipo_estado_movimiento)){
                    echo "<option value=''>--Seleccione--</option>";
                  }else {
                    echo "<option value=''>--Seleccione--</option>";
                    echo "<option value='$id_tipo_estado_movimiento' selected='selected'>$nombre_tipo_estado_movimiento</option>";
                  }

                  foreach ($mostrar_estado_movimiento as $tem)
                  {                         
                    if($tem->id_tipo_estado_movimiento != $id_tipo_estado_movimiento){ ?>
                      <option value="<?php echo $tem->id_tipo_estado_movimiento ?>"><?php echo $tem->nombre_tipo_estado_movimiento ?></option>
                      <?php 
                    }
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
              <select <?php echo $solo_lectura;?> name="id_banco[]" id="<?php echo "id_banco_".$j;?>" class="form-control">
              <?php
                  if(!empty($mostrar_banco))
                  {

                    if(empty($id_banco)){
                      echo "<option value=''>--Seleccione--</option>";
                    }else {
                      echo "<option value=''>--Seleccione--</option>";
                      echo "<option value='$id_banco' selected='selected'>$nombre_banco</option>";
                    }

                    foreach ($mostrar_banco as $b)
                    {                         
                      if($b->id_banco != $id_banco){ ?>
                        <option value="<?php echo $b->id_banco ?>"><?php echo $b->nombre_banco ?></option>
                        <?php 
                      }
                    }
              
                  }else {
                    
                    echo "<option value=''>--Seleccione--</option>";

                  }
                  ?>
              </select>
              <span class="help-block"></span>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label for="id_condicion_pago">Condici&oacute;n de Pago</label>
              <select <?php echo $solo_lectura;?> name="id_condicion_pago[]" id="<?php echo "id_condicion_pago_".$j;?>" class="form-control">
              <?php
                  if(!empty($mostrar_condicion_pago))
                  {

                    if(empty($id_condicion_pago)){
                      echo "<option value=''>--Seleccione--</option>";
                    }else {
                      echo "<option value=''>--Seleccione--</option>";
                      echo "<option value='$id_condicion_pago' selected='selected'>$nombre_condicion_pago</option>";
                    }

                    foreach ($mostrar_condicion_pago as $cp)
                    {                         
                      if($cp->id_condicion_pago != $id_condicion_pago){ ?>
                        <option value="<?php echo $cp->id_condicion_pago ?>"><?php echo $cp->nombre_condicion_pago ?></option>
                        <?php 
                      }
                    }
              
                  }else {
                    
                    echo "<option value=''>--Seleccione--</option>";

                  }

                  ?>
              </select>
              <span class="help-block"></span>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <label for="numero_voucher">Nº de Voucher CT</label>
              <input <?php echo $solo_lectura;?> type="text" class="form-control" id=<?php echo "numero_voucher_".$j;?> name="numero_voucher[]" placeholder="Numero de Voucher" value="<?php echo $numero_voucher;?>">
              <span class="help-block"></span>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <label for="observaciones">Observaciones</label>
              <textarea <?php echo $solo_lectura;?> type="textarea" class="form-control" name="observaciones[]" id=<?php echo "observaciones_".$j;?> placeholder="Observaciones"><?php echo $observaciones;?></textarea>
              <span class="help-block"></span>
            </div>

          </div><!-- Termina row Estado de Documento -->

          <div class="actions"><!-- Inicia botones clone y remove -->
            <a class="btn btn-sm btn-success clone"  <?php echo $solo_lectura;?> id="clone_0" title="Agregar Nuevo Documento"><i class="icon icon-plus"></i></a>
            <a class="btn btn-sm btn-danger remove"  <?php echo $solo_lectura;?> onclick="elimina_documento(this.id, this.value);" id="<?php echo "remove_".$j;?>"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
          </div>
          </div>
												</div>
                      </div>
        <?php } ?>
  
  </div>

<?php $j++;} ?>

<?php } ?>

</div>


<script>

  
function elimina_documento(id,val)
{
  var res1 = id.split("_");
  var trozo_div1 = res1[1];
  var idmd = $("#id_movimiento_detalle_"+trozo_div1).val();
 
  var id_m = $("#id_movimiento_ed").val();
  var lav_e =  $("#id_movimiento_e_ed").val();
  var id_e = $('#id_empresa_guarda').val();
  var id_mov = $('#idmov').val();
  


      if(idmd > 0){

        bootbox.confirm("¿Está seguro de <B>ELIMINAR</B> este Detalle?", function(result) {
    if(result) {


    $.ajax({
      url : "<?php echo site_url('del_document')?>/" + idmd,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        save_update();
        //alert('Detalle del Movimiento fue eliminado con éxito.');
        $(location).attr('href','<?php echo base_url() ?>movimiento_egreso/' + id_e + '/' + id_mov);
      },
      error: function (jqXHR, textStatus, errorThrown){
        alert('Error al eliminar el Detalle del Movimiento.');
      }
    });

  }else{
      $(location).attr('href','<?php echo base_url() ?>movimiento/' + id_e + '/' + id_mov);
    }
  });

  }
  
}

</script>