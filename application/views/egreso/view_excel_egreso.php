<style>

.popover{
        padding-top:18px;
        max-width:1500px;
    }

table tbody tr td table tbody tr td  {
    min-width: 77px !important;
    font-size: 12px !important;
}
body {
  overflow: hidden;
}
.hhfixed {
  /*overflow-y: scroll;
  height: 100vh;
  width: 1500px;*/
}
.page-content{
  position: relative;
  overflow-y: scroll;
  max-height: 85vh;
}

tr.cdata, tr.ctrl {
  /*position: fixed;
  width: 100%;*/
}

.fixed #tbfix{
  position: fixed;
  z-index: 0;
  top: 47px;
}
td.gtd{
        min-width: 311px !important;
    }
.fixed td.gtd{
  min-width: 263px !important;
}
.footer {
  padding-top: 0px !important;
}

</style>

<!-- SCid: Quitar espacio en blanco que aparece de manera vertical-->
<!--<div class="main-content">-->
    
    <div class="main-content-inner">
<div class="page-content" onscroll="move($(this))">
  <div class="page-header">

<!-- HAmestica: Ocultar botón Actualizar Totales -->
<!-- <?php if(!empty($mostrar_cuenta_egreso)){?>
  <div style="float: right;text-align: right;">
      <a id="clear-view" data-file="" style="color: #fff;padding: 4px 15px;border-radius: 4px;background-color: #4CAF50;font-size: 13px;text-transform: uppercase;margin: 0px 5px;box-shadow: 1px 1px 4px 0px #0000009c;" href="javascript:void(0)">
        Actualizar totales
      </a>
  </div>
  <?php }?> -->
    <h1>
            <i class="icon-plus"></i> Egresos
                          <small>
                <i class="icon-double-angle-right"></i>
                &nbsp;movimientos.
              </small>
    </h1>
  </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
              <!-- PAGE CONTENT BEGINS -->
              <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
              <!-- SCid: agrego este  <div class="row"> para "agrandar" calendario y poder verlo mas amplio-->
              <div class="row">
                <?php

                  $param_cal = devuelve_parametro_cal($id_empresa);
                    if($param_cal == 'CALENDARIO SEMANAL'){
                      
                      require("view_egreso_semanal.php");
                    
                    }else if ($param_cal == 'CALENDARIO QUINCENAL') {
                      
                      echo "CALENDARIO QUINCENAL";
                    
                    }else if ($param_cal == 'CALENDARIO MENSUAL') {
                      
                      echo "CALENDARIO MENSUAL";
                    
                    }else {
                      
                      echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">
                        <i class="icon-remove"></i>
                      </button>
                      <strong>
                        Atenci&oacute;n!
                      </strong>
                        La empresa seleccionada <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong> no tiene el par&aacute;metro de Calendario definido.<strong> Cont&aacute;ctese con el administrador del sistema</strong>
                        </div>';
                    }
                  ?>


    
</div><!-- /.row -->
</div><!-- /.page-content -->

</div><!-- /.page-content -->

</div><!-- /.main-content -->
</div><!-- /.main-content-inner -->