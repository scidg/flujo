<style>
    table tbody tr td table tbody tr td {
        min-width: 77px !important;
        font-size: 12px !important;
    }

    table tr td .con-check {
        min-width: 20px !important;
        text-align:left;
    }

    table tr td .num-con-check {
        min-width: 20px !important;
        text-align:right;
    }

    table tr td .vacio-con-check {
        min-width: 5px !important;
    }

    .popover{
            padding-top:5px;
            max-width:1500px;
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


    
    <div class="main-content-inner">
        
        <div class="page-content" onscroll="move($(this))">
            
            <div class="page-header">
                <h1>
                    <i class="icon-plus"></i> Ingresos
                                <small>
                        <i class="icon-double-angle-right"></i>
                        &nbsp;movimientos.
                    </small>
                </h1>
            </div><!-- /.page-header -->
    
            <div class="row">
                
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <input type="hidden" value="<?php echo $id_empresa; ?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
                    <input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="hoy_dia" id="hoy_dia"/>
                    <div class="row">

                        <?php
                        $param_cal = devuelve_parametro_cal($id_empresa);

                        if ($param_cal == 'CALENDARIO SEMANAL') {

                            require("view_semanal.php");
                        } else if ($param_cal == 'CALENDARIO QUINCENAL') {

                            echo "CALENDARIO QUINCENAL";
                        } else if ($param_cal == 'CALENDARIO MENSUAL') {

                            echo "CALENDARIO MENSUAL";
                        } else {

                            echo '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                            Atenci&oacute;n!
                            </strong>
                            La empresa seleccionada <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong> no tiene el par&aacute;metro de Calendario definido.<strong> Cont&aacute;ctese con el administrador del sistema</strong>
                                                <br />
                                                </div>';
                        }
                        ?>

</div><!-- /.row -->

                </div><!-- /.col-xs-12 -->

            </div><!-- /.row -->

        </div><!-- /.page-content -->

    </div><!-- /.main-content-inner -->