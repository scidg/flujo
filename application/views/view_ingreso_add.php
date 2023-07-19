<input type="hidden" value="<?php echo $m_fi;?>" name="input_mes_fi" id="input_mes_fi"/>
<input type="hidden" value="<?php echo $a_fi;?>" name="input_anio_fi" id="input_anio_fi"/>

<div class="bodyClone">

  <div id="clonedInput0" class="clonedInput">
 
  <div class="space-4"></div>

      <?php if($cuenta_banco == 1) {?>
        <div class="widget-box">
												<div class="widget-header">
													<h4>Detalle del Movimiento</h4>
												</div>

												<div class="widget-body">
													<div class="widget-main">
        <div class="row"><!-- Inicia row Es Cuenta Banco -->

          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <label for="monto_cuenta_banco">Monto Cuenta Banco</label>
            <input type="text" class="form-control" id="monto_cuenta_banco" name="monto_cuenta_banco" placeholder="Monto" value="">
            <span class="help-block"></span>
          </div>

          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <label for="fecha_ingreso">Fecha de Ingreso</label>
            <div class="input-group">
              <input class="form-control date-picker" id="fecha_ingreso_0" name="fecha_ingreso[]" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $fecha_registro;?>"/>
              <span class="help-block"></span>
            </div>
          </div>

        </div><!-- Termina row Es Cuenta Banco -->
        </div>
      </div>
    </div>
      <?php } else { ?>
        
        <div class="widget-box">
												<div class="widget-header">
													<h4>Detalle del Movimiento</h4>
												</div>

												<div class="widget-body">
													<div class="widget-main">
                          <div class="row"><!-- Inicia row Tipo de Documento -->



<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
  
  <label for="tipo_documento">Tipo de Documento</label>
  
  <select name="id_tipo_documento[]" id="id_tipo_documento_0" class="form-control" onchange="periodo_iva(this.value,this.id);">

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
  <input type="hidden" value="" name="es_nota_credito[]" id="es_nota_credito_0"/>
  
  
</div>

<div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
  <label for="numero_tipo_documento">Nº</label>
  <input type="text" class="form-control clean obligatorio" id="numero_tipo_documento_0" name="numero_tipo_documento[]" title="numero_tipo_documento_0" placeholder="Numero" value="<?php echo $numero_tipo_documento;?>">
  <span class="help-block"></span>
  <input type="hidden" value="" name="es_obligatorio[]" id="es_obligatorio_0"/>
</div>

<div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
  <label for="monto">Monto</label>
  <input type="text" class="form-control clean" id="monto_0" name="monto[]" placeholder="Monto" value="<?php echo $monto; ?>">

  <span class="help-block"></span>
</div>

<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
  <label for="fecha_ingreso">Fecha de Ingreso</label>
    <input class="form-control date-picker" id="fecha_ingreso_0" name="fecha_ingreso[]" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $fecha_ingreso;?>"/>
  <span class="help-block"></span>
</div>

<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
  <label for="fecha_pago">Fecha de Pago</label>
    <input class="form-control date-picker" id="fecha_pago_0" name="fecha_pago[]" type="text" data-date-format="dd-mm-yyyy" value=""/>
  <span class="help-block"></span>
</div>

<div id="periodo_iva_0" class="iva" style="visibility:hidden">
  <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
    <label for="mes_iva">IVA</label>
    <select name="mes_iva[]" id="mes_iva_0" class="form-control">
      <?php
      $mes=$m_fi;
      $rango=2;
      for ($i=$mes;$i<=$mes+$rango;$i++){
          $meses=date('m', mktime(0, 0, 0, $i, 1, date("Y") ) );
          echo "<option value='$meses'>$meses</option>";
      }
      ?>
    </select>
  </div>

  <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
    <label for="año_iva">&nbsp;</label>
    <select name="año_iva[]" id="año_iva_0" class="form-control">
      <?php
      $anio=$a_fi;
      $rangoa=1;
      for ($ia=$anio;$ia<=$anio+$rangoa;$ia++){
          $anos=date('Y', mktime(0, 0, 0, 1, 1, $ia ) );
          echo "<option value='$anos'>$anos</option>";
      }
      ?>
    </select>
  </div>
</div>
<input type="hidden" value="" name="iva_disabled[]" id="iva_disabled_0"/>
</div><!-- Termina row Tipo de Documento -->

<div class="row"><!-- Inicia row Estado Documento-->

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
  <textarea type="textarea" class="form-control" name="observaciones[]" id="observaciones_0" placeholder="Observaciones" required><?php echo $observaciones;?></textarea>
  <span class="help-block"></span>
</div>

</div><!-- Termina row Estado Documento-->

<div class="actions">
<a class="btn btn-sm btn-success clone"  id="clone_0" title="Agregar Nuevo Documento"><i class="icon icon-plus"></i></a>
<a class="btn btn-sm btn-danger remove"  id="remove_0" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
</div>
													</div>
												</div>
                      </div>
                      
        
        
      <?php } ?>
    
  </div>

</div>
