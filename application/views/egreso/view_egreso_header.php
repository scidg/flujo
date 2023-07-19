<?php
//cambio de hoy a fi ya que el cliente requiere una vez guardado el detalle volver al mes en el que estaba, y no siempre volver a hoy.
$hoy = $fi;//date("Y-m-d");
$hoy = $this->encryption->encrypt($hoy);
$hoy = strtr($hoy,array('+' => '.', '=' => '-', '/' => '~'));

$parametro1 = devuelve_parametro_fi($id_empresa);
        
if($parametro1=='FECHA INGRESO AUTOMATICO'){
  $disabled_fi='disabled="disabled"';
  $is_disabled=1;
}else{
  $disabled_fi='';
  $is_disabled=0;
}

if(!empty($data_movimiento_detalle))
{
    foreach ($data_movimiento_detalle as $dmd)
    {
      $disabled = 'disabled="disabled"';
      $id_movimiento = $dmd->id_movimiento;
      $id_movimiento_detalle = $dmd->id_movimiento_detalle;
      $fecha_registro = $dmd->fecha_registro;
      $fecha_registro = fecha_espanol($dmd->fecha_registro);
      $id_tipo_movimiento = $dmd->id_tipo_movimiento;
      $id_empresa_guarda = $dmd->id_empresa_guarda;
      $id_cuenta = $dmd->id_cuenta;
      $cuenta_banco = $dmd->cuenta_banco;
      $monto_cuenta_banco = $dmd->monto_cuenta_banco;
      $nombre_cuenta = $dmd->nombre_cuenta;
      $id_subcuenta = $dmd->id_subcuenta;
      $nombre_subcuenta = $dmd->nombre_subcuenta;
      $id_tipo_documento = $dmd->id_tipo_documento;
      $es_obligatorio = $dmd->es_obligatorio;
      $nombre_tipo_documento = $dmd->nombre_tipo_documento;
      $numero_tipo_documento = $dmd->numero_tipo_documento;
      $monto = $dmd->monto;
      $fecha_ingreso = $dmd->fecha_ingreso;
      $fecha_ingreso = fecha_espanol($dmd->fecha_ingreso);
      list($d_fi,$m_fi,$a_fi) = explode("-", $fecha_ingreso);
      $fecha_pago = fecha_espanol($dmd->fecha_pago);
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
      if($_SESSION['egr_mov_eli']==1){
        $boton_anular = '';
      }else{
        $boton_anular = 'disabled="disabled"';

      }
    }

}else {

      $disabled = 'disabled="disabled"';
      $id_movimiento_detalle = '';
      $fecha_registro = date("d-m-Y");
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
      $fecha_ingreso = fecha_espanol($fecha_ingreso);
      list($d_fi,$m_fi,$a_fi) = explode("-", $fecha_ingreso);
      $fecha_pago = fecha_espanol('0000-00-00');
      $mes_iva = '';
      $año_iva = '';
      $id_tipo_estado_movimiento = '';
      $id_banco = '';
      $id_condicion_pago = '';
      $numero_voucher = '';
      $observaciones = '';
      $accion = 'agreg';
      $boton_anular = 'disabled="disabled"';
      
}
?>


    
    <div class="main-content-inner">
        
<div class="page-content">

<div class="row" >

  <div class="col-xs-12">
  <div class="row" >
    <div id="error">
        
    </div>
        <form action="#" id="form" class="form-horizontal">

            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
            <input type="hidden" value="<?php echo $id_movimiento;?>" name="id_movimiento" id="id_movimiento"/>
            <input type="hidden" value="<?php echo $accion;?>" name="accion" id="accion"/>
            <input type="hidden" value="<?php echo date("Y-m-d");?>" name="fecha_registro" id="fecha_registro"/>
            <input type="hidden" value="<?php echo $hoy;?>" name="hoy" id="hoy"/>
            <input type="hidden" value="<?php echo $id_cuenta;?>" name="id_cuenta" id="id_cuenta"/>
            <input type="hidden" value="<?php echo $id_subcuenta;?>" name="id_subcuenta" id="id_subcuenta"/>
            <input type="hidden" value="<?php echo $is_disabled;?>" name="param_fecha_inicio" id="param_fecha_inicio"/>
       

                        <?php if(!empty($data_movimiento_detalle)){

                                if($_SESSION['egr_mov_edi']==1){
                                    $boton_grabar = '';
                                  }else{
                                    $boton_grabar = 'disabled="disabled"';
                            
                                  } 
                                  
                                  ?>
                                   
                                   <div class="widget-box">
                            
                                        <div class="widget-header widget-header-large">
                                            <h4>  <?php
                                                if($id_m){
                                                    echo "FORMULARIO DE EDICI&Oacute;N > EGRESO Nº ".$id_m;
                                                }else {
                                                    echo "FORMULARIO DE CREACI&Oacute;N > EGRESO Nº ".$devuelve_ultimo_id_ingreso;
                                                }
                                                ?></h4>
                                        </div>

                                        <div class="widget-body">
                                                            
                                            <div class="widget-main">
                                                
                                                <div class="row" >

                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                        <label for="fecha_registro">Fecha Registro</label>
                                                            <div class="input-group">
                                                                <input class="form-control" id="fecha_registro" disabled="disabled" name="fecha_registro" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_registro;?>"/>
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
                                                                        
                                                                    }
                                                                ?>
                                                            </select>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                        <label for="id_subcuenta">Subcuenta</label>
                                                            <select class="form-control" id="id_subcuenta" name="id_subcuenta" <?php echo $disabled;?>>
                                                                <?php 
                                                                    if(empty($id_subcuenta)){
                                                                        echo "<option value=''>--Seleccione--</option>";
                                                                    }else {
                                                                        echo "<option value='$id_subcuenta'>$nombre_subcuenta</option>";
                                                                    };
                                                                ?>
                                                            </select>
                                                    </div>

                                                </div>
                                                
                                            </div>

                                        </div>

                                    </div>  

                                   <?php 

                                   require('view_egreso_edit.php');
                                    
                                    $botonera = '
                                            <div class="clearfix form-actions">
                                                
                                                <div class="col-md-offset-3 col-md-6">

                                                    <button class="btn btn-default" type="button" id="btnVolver" onclick="volver()">
                                                        <i class="ace-icon icon icon-chevron-left bigger-110"></i>
                                                        Volver
                                                    </button>
                                                    
                                                    &nbsp; &nbsp; &nbsp;
                    
                                                    <button class="btn btn-success" type="button" id="btnSave" '.$boton_grabar.' onclick="save()">
                                                        <i class="ace-icon icon icon-save bigger-110"></i>
                                                        Guardar
                                                    </button>
                    
                                                    &nbsp; &nbsp; &nbsp;
                    
                                                    <button class="btn btn-danger" type="button" id="btnAnular" '.$boton_anular.'>
                                                        <i class="ace-icon icon icon-remove bigger-110"></i>
                                                        Anular
                                                    </button>   
                                                     
                                                </div>
                                            
                                            </div>';
                                /*}else{
                                    $botonera = '<div class="clearfix form-actions"><div class="col-md-offset-3 col-md-3">
                                    <button class="btn btn-default" type="button" id="btnVolver" onclick="volver()">
                                        <i class="ace-icon icon icon-chevron-left bigger-110"></i>
                                        Volver
                                    </button>                  
                                </div></div>';
                                    echo '
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">
                                        <i class="icon-remove"></i>
                                        </button>
                                        <strong>
                                        Atenci&oacute;n!
                                        </strong>
                                        Usted no tiene los permisos de visualizaci&oacute;n definidos.<strong> Cont&aacute;ctese con el administrador del sistema</strong>
                                        <br />
                                    </div>';
                                }*/
                            } else {
                                
                                if($_SESSION['egr_mov_agr']==1){?>

<div class="widget-box">
                            
                            <div class="widget-header widget-header-large">
                                <h4>  <?php
                                    if($id_m){
                                        echo "FORMULARIO DE EDICI&Oacute;N > EGRESO Nº ".$id_m;
                                    }else {
                                        echo "FORMULARIO DE CREACI&Oacute;N > EGRESO Nº ".$devuelve_ultimo_id_ingreso;
                                    }
                                    ?></h4>
                            </div>

							<div class="widget-body">
                                                
                                <div class="widget-main">
                                    
                                    <div class="row" >

                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                            <label for="fecha_registro">Fecha Registro</label>
                                                <div class="input-group">
                                                    <input class="form-control" id="fecha_registro" disabled="disabled" name="fecha_registro" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $fecha_registro;?>"/>
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
                                                            
                                                        }
                                                    ?>
                                                </select>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                            <label for="id_subcuenta">Subcuenta</label>
                                                <select class="form-control" id="id_subcuenta" name="id_subcuenta" <?php echo $disabled;?>>
                                                    <?php 
                                                        if(empty($id_subcuenta)){
                                                            echo "<option value=''>--Seleccione--</option>";
                                                        }else {
                                                            echo "<option value='$id_subcuenta'>$nombre_subcuenta</option>";
                                                        };
                                                    ?>
                                                </select>
                                                <br>
                                        </div>

                                    </div>
                                    
                                </div>

                            </div>

					    </div>  

                                    <?php 
        require('view_egreso_add.php');
        $botonera = '<div class="clearfix form-actions"><div class="col-md-offset-3 col-md-6">
        <button class="btn btn-default" type="button" id="btnVolver" onclick="volver()">
            <i class="ace-icon icon icon-chevron-left bigger-110"></i>
            Volver
        </button>
        
        &nbsp; &nbsp; &nbsp;

        <button class="btn btn-success" type="button" id="btnSave" onclick="save()">
            <i class="ace-icon icon icon-save bigger-110"></i>
            Guardar
        </button>

        &nbsp; &nbsp; &nbsp;

        <button class="btn btn-danger" type="button" id="btnAnular" '.$boton_anular.'>
            <i class="ace-icon icon icon-remove bigger-110"></i>
            Anular
        </button>                    
    </div></div>';
    }else{
        $botonera = '';
        echo '
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
            </button>
            <strong>
            Atenci&oacute;n!
            </strong>
            Usted no tiene los permisos de visualizaci&oacute;n definidos.<strong> Cont&aacute;ctese con el administrador del sistema</strong>
            <br />
        </div>';
    }}?>
<?php echo $botonera;?>

</form><!-- /.form -->
                    
                    </div><!-- /.row -->

                </div><!-- /.col-xs-12 -->

            </div><!-- /.row -->
        
        </div><!-- /.page-content -->
    
    </div><!-- /.main-content-inner -->

<script>

$(document).ready(function() {

    var id_movimiento = $('#id_movimiento').val();
    var id_empresa = $('#id_empresa_guarda').val();
    var hoy = $('#hoy').val();

    $("#btnAnular").on(ace.click_event, function() {
        bootbox.confirm("¿Está seguro de anular este Movimiento?", function(result) {
            if(result) {
                $.ajax({
                    url : "<?php echo site_url('anular_egreso')?>",
                    type: "POST",
                    data: {id_movimiento: id_movimiento},
                    success: function(data)
                        {
                            //HAmestica: Llamada a url manteniendo cuentas abiertas
                            // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
                            $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
                        },
                    error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error al anular.');
                        }
                });
            }
        });
    });
                
$('.date-picker').datepicker({
   todayBtn: false,
   language: "es",
   autoclose: true,
   todayHighlight: false,
   daysOfWeekDisabled: "0,6",
   weekStart: 1
 })

 .next().on(ace.click_event, function(){
   $(this).prev().focus();
 });





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



function limpmia_pendiente(val,id){
    
    var res = id.substring(0, 25);
    var trozo_div = id.substring(26, 28);
    
    if(val == 2 || val == ''){

        $("#id_banco_"+trozo_div).val('');
        $("#id_condicion_pago_"+trozo_div).val('');
        $("#fecha_pago_"+trozo_div).val('');
    }
}

function periodo_iva(val,id){

    var res = id.split("_");
    var trozo_div = res[3];

    var mes_iva = $("#mes_iva_"+trozo_div).val();
    var año_iva = $("#año_iva_"+trozo_div).val();

    var input_mes_fi = $("#input_mes_fi").val();
    var input_anio_fi = $("#input_anio_fi").val();

    if(!val.length == 0){
    $.ajax({
       url : "<?php echo site_url('egreso_muestra_periodo_iva/')?>" + val,
       type: "GET",
       dataType: "JSON",
       success: function(data)
        {   
              if(data.es_obligatorio == 1){
                $("#es_obligatorio_"+trozo_div).val(1);
              }else{
                $("#es_obligatorio_"+trozo_div).val(0);
                $("#numero_tipo_documento_"+trozo_div).parent().removeClass('has-error');
                $("#numero_tipo_documento_"+trozo_div).next().empty();
              }

            if(data.con_iva == 1){      

                  $("#periodo_iva_"+trozo_div).attr('style','visibility:show');
                  $("#mes_iva_"+trozo_div).val(input_mes_fi);
                  $("#año_iva_"+trozo_div).val(input_anio_fi);
                  $("#iva_disabled_"+trozo_div).val('con iva');
                  $("#es_nota_credito_"+trozo_div).val(0);

            }else if(data.es_nota_credito == 1){    
                
                  $("#es_nota_credito_"+trozo_div).val(1);
                  $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
                  $("#mes_iva_"+trozo_div).val(<?php echo date("m"); ?>);
                  $("#año_iva_"+trozo_div).val(<?php echo date("Y"); ?>);
                  $("#iva_disabled_"+trozo_div).val('sin iva');

            }else{
                  $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
                  $("#mes_iva_"+trozo_div).val(input_mes_fi);
                  $("#año_iva_"+trozo_div).val(input_anio_fi);
                  $("#iva_disabled_"+trozo_div).val('sin iva');
                  $("#es_nota_credito_"+trozo_div).val(0);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           alert('Error al obtener los datos.');
        }
       });
    }else{
        
        $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
    
    }
}

function periodo_iva_edit(val,id){

var res = id.split("_");
var trozo_div = res[3];

var input_mes_fi = $("#input_mes_fi").val();
var input_anio_fi = $("#input_anio_fi").val();

if(!val.length == 0){
$.ajax({
   url : "<?php echo site_url('egreso_muestra_periodo_iva/')?>" + val,
   type: "GET",
   dataType: "JSON",
   success: function(data)
    {       

              if(data.es_obligatorio == 1){
                $("#es_obligatorio_"+trozo_div).val(1);
              }else{
                $("#es_obligatorio_"+trozo_div).val(0);
                $("#numero_tipo_documento_"+trozo_div).parent().removeClass('has-error');
                $("#numero_tipo_documento_"+trozo_div).next().empty();
              }

            if(data.con_iva == 1){      

                  $("#periodo_iva_"+trozo_div).attr('style','visibility:show');
                  $("#mes_iva_"+trozo_div).val(input_mes_fi);
                  $("#año_iva_"+trozo_div).val(input_anio_fi);
                  $("#iva_disabled_"+trozo_div).val('con iva');
                  $("#es_nota_credito_"+trozo_div).val(0);

            }else if(data.es_nota_credito == 1){    
                
                  $("#es_nota_credito_"+trozo_div).val(1);
                  $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
                  $("#mes_iva_"+trozo_div).val(<?php echo date("m"); ?>);
                  $("#año_iva_"+trozo_div).val(<?php echo date("Y"); ?>);
                  $("#iva_disabled_"+trozo_div).val('sin iva');

            }else{
                  $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
                  $("#mes_iva_"+trozo_div).val(input_mes_fi);
                  $("#año_iva_"+trozo_div).val(input_anio_fi);
                  $("#iva_disabled_"+trozo_div).val('sin iva');
                  $("#es_nota_credito_"+trozo_div).val(0);
            }


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
       alert('Error al obtener los datos1.');
    }
   });
}else{
        
        $("#periodo_iva_"+trozo_div).attr('style','visibility:hidden');
    
    }
}


function volver(){

  var id_empresa = $('#id_empresa_guarda').val();
  var hoy = $('#hoy').val();

  $('#btnVolver').html('<i class="ace-icon icon icon-chevron-left bigger-110"></i>&nbsp;Volver...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  $('#btnAnular').attr('disabled',true); //set button disable
  

  //HAmestica: Llamada a url manteniendo cuentas abiertas
  //$(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
  $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
}

var save_method;
var base_url = '<?php echo base_url();?>';

function save()
{
  var hoy = $('#hoy').val();

  $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardando...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  $('#btnAnular').attr('disabled',true); //set button disable

  var url;

  var formData = new FormData($('#form')[0]);
  var id_empresa = $('#id_empresa_guarda').val();
  var accion = $('#accion').val();

  if(accion == 'agreg')
  {
    url = "<?php echo site_url('save_egreso')?>";
  }
  else
  {
    url = "<?php echo site_url('update_egreso')?>";
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

            //alert('Ingreso se guardo con exito.');
            if(accion == 'agreg'){
                //HAmestica: Ocultar mensaje de éxito
                //alert('Egreso se guardó con éxito.');
                
                //HAmestica: Llamada a url manteniendo cuentas abiertas
                // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
                $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
            }else{
                //HAmestica: Ocultar mensaje de éxito
                //alert('Egreso actualizado con éxito.');

                //HAmestica: Llamada a url manteniendo cuentas abiertas
                // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
                $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
            }

        }
        else
        {
              for (var i = 0; i < data.inputerror.length; i++)
              {
                  $('#'+data.inputerror[i]).parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                  $('#'+data.inputerror[i]).next().text(data.error_string[i]); //select span help-block class set text error string
              }

        }
        $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardar'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
        $('#btnAnular').attr('disabled',true);
      },

         error: function (jqXHR, textStatus, errorThrown)
         {
           alert('Error al guardar los datos.');
           $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardando...'); //change button text
           $('#btnSave').attr('disabled',false); //set button enable
           $('#btnAnular').attr('disabled',true); //set button disable
           $('#btnVolver').attr('disabled',true); //set button disable
        }
      });
 }


 function save_update()
{

  var hoy = $('#hoy').val();

  $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardando...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  $('#btnAnular').attr('disabled',true); //set button disable

  var url;

  var formData = new FormData($('#form')[0]);
  var id_empresa = $('#id_empresa_guarda').val();
  var accion = $('#accion').val();



  if(accion == 'agreg')
  {
    url = "<?php echo site_url('save_egreso')?>";
  }
  else
  {
    url = "<?php echo site_url('update_egreso')?>";
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

            //alert('Ingreso se guardo con exito.');
            if(accion == 'agreg'){
                //HAmestica: Ocultar mensaje de éxito
                //alert('Egreso guardado con éxito.');
                //$('#error').html('<div class="alert alert-success"><strong><i class="icon-ok"></i>OK! </strong>Ingreso guardado con éxito. </div>');
                
                //HAmestica: Llamada a url manteniendo cuentas abiertas
                // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
                $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
            }else{
                //HAmestica: Ocultar mensaje de éxito
                //alert('Egreso actualizado con éxito.');

                //HAmestica: Llamada a url manteniendo cuentas abiertas
                // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy);
                $(location).attr('href','<?php echo base_url() ?>egreso/' + id_empresa + '/' + hoy + '/0');
            }

        }
        else
        {
              for (var i = 0; i < data.inputerror.length; i++)
              {
                  $('#'+data.inputerror[i]).parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                  $('#'+data.inputerror[i]).next().text(data.error_string[i]); //select span help-block class set text error string
              }

        }
        $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardar'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
        $('#btnAnular').attr('disabled',true);

      },

         error: function (jqXHR, textStatus, errorThrown)
         {
           $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardar'); //change button textarea
           $('#btnSave').attr('disabled',false); //set button enable
           $('#btnAnular').attr('disabled',true); //set button disable
           $('#btnVolver').attr('disabled',true); //set button disable
        }
      });
 }


function cambia_fecha(id1, val1) {
    var res1 = id1.split("_");
    var trozo_div1 = res1[2];
    $("#fecha_ingreso_2_"+trozo_div1).val(val1);
}

</script>