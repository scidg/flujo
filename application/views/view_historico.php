<style>
    table tr td table tr td {
        min-width: 75px !important;
        font-size: 13px !important;
    }
    #logo-empresa{
        width:109px;
        text-align:center;
        padding:3px;
    }
</style>
<?php
$ALLEmpresas = get_all_company();

$IsMother = is_company_mother($id_empresa);
?>

    
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    <i class="icon-time"></i> Hist&oacute;rico
                </h1>
            </div><!-- /.page-header -->
            
            <div class="row">

                <div class="col-xs-12">
                    
                    <!-- PAGE CONTENT BEGINS -->
                
                    <div class="row">
                        <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda" />

                                                                                                            <?php

                                                                                                            $meses = array();
                                                                                                            $anoss_cabecera = array();
                                                                                                            $anoss_cuerpo = array();
                                                                                                            $empresaa_cuerpo = array();
                                                                                                            $anoss_pie = array();
                                                                                                            $anoss = array();
                                                                                                            $empresass_usuario = array();


                                                                                                            if($IsMother){

                                                                                                                    echo '
                                                                                                                    
                                                                                                                        <table border="1px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                            <tr style="font-size:18px;background-color:#31859c;height:35px;" >
                                                                                                                                <td colspan="7">
                                                                                                                                <strong><div style="color:white;text-align:center;font-size:26px;">CONSOLIDADO EMPRESAS</div></strong>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                            <td style="text-align:center;background-color:#93cddd;height:35px;">
                                                                                                                            <span style="font-size:18px;">Año</span>
                                                                                                                            </td>';
                                                                                                                                if(!empty($muestra_anos_venta)){ 
                                                                                                                                    $c=0;
                                                                                                                                    foreach ($muestra_anos_venta as $av){
                                                                                                                                    $anoss_cabecera[] = $av->id_ano;
                                                                                                                                    echo '<td style="text-align:center;background-color:#93cddd;">
                                                                                                                                        <span style="font-size:18px;">'.strtoupper($av->nombre_ano).'</span>
                                                                                                                                        </td>';
                                                                                                                                    $c++;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            echo'</tr>
                                                                                                                            <tr>
                                                                                                                            <td style="text-align:center;width:175px;background-color:#93cddd;height:35px;">
                                                                                                                            <span style="font-size:18px;">Mes</span>
                                                                                                                            </td>';
                                                                                                                            for($j=0;$j<$c;$j++){
                                                                                                                            echo '<td style="background-color:#93cddd">
                                                                                                                                    <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                        <tr>
                                                                                                                                            <td style="text-align:center;width:70px;background-color:#93cddd;border-right:1px solid #000;height:35px;">
                                                                                                                                                <span style="font-size:16px;">Total</span>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:70px;background-color:#93cddd;border-right:1px solid #000;height:35px;">
                                                                                                                                                <span style="font-size:16px;">Tributario</span>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:30px;background-color:#93cddd;height:35px;">
                                                                                                                                            <span style="font-size:16px;">VAR</span>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>';
                                                                                                                            }
                                                                                                                            echo '
                                                                                                                        </tr>
                                                                                                                        ';

                                                                                                                    /* foreach ($mostrar_empresas_usuario as $cl){ 

                                                                                                                            echo $cl->id_empresa;
                                                                                                                        }       */

                                                                                                                /*foreach ($ALLEmpresas as $key => $empresa) {
                                                                                                                    if($IsMother || $empresa->id_empresa===$id_empresa){*/
                                                                                                                    foreach ($mostrar_empresas_usuario_sin_em as $cl){ 
                                                                                                                            $empresass_usuario[] = $cl->id_empresa;
                                                                                                                            if($IsMother || $cl->id_empresa===$id_empresa){

                                                                                                                        if(devuelve_logo_empresa_cabecera($cl->id_empresa)){
                                                                                                                            $logo= '<img id="logo-empresa" '.devuelve_logo_empresa_cabecera($cl->id_empresa).' alt="'.devuelve_nombre_empresa($cl->id_empresa).'"/>';
                                                                                                                        }else{
                                                                                                                            $logo= devuelve_nombre_empresa($cl->id_empresa);
                                                                                                                        }
                                                                                                                        echo '<tr>
                                                                                                                            <td>
                                                                                                                            <div align="center">'.$logo.'</div>
                                                                                                                            </td>';
                                                                                                                            if(!empty($muestra_anos_venta)){ 
                                                                                                                                $c=0;
                                                                                                                                foreach ($muestra_anos_venta as $av){
                                                                                                                                    $anoss_cuerpo[] = $av->id_ano;
                                                                                                                                    $empresaa_cuerpo[] = $cl->id_empresa;
                                                                                                                                    

                                                                                                                                    echo '<td style="text-align:center;border-right:0px solid #000;">
                                                                                                                                            <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                                <tr>
                                                                                                                                                    <td style="text-align:center;width:70px;border-right:1px solid #000;height:50px;">
                                                                                                                                                    <div id="ano_consolid_'.$av->nombre_ano.'_'.$cl->id_empresa.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                    </td>
                                                                                                                                                    <td style="text-align:center;width:70px;border-right:1px solid #000;height:50px;">
                                                                                                                                                    <div id="trib_consolid_'.$av->nombre_ano.'_'.$cl->id_empresa.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                    </td>
                                                                                                                                                    <td style="text-align:center;width:30px;height:35px;">
                                                                                                                                                        <div id="var_consolid_'.$av->nombre_ano.'_'.$cl->id_empresa.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                        </td>';
                                                                                                                                    $c++;
                                                                                                                                }
                                                                                                                            }
                                                                                                                    echo '</tr>';
                                                                                                                    }
                                                                                                                }

                                                                                                                    echo '<tr>
                                                                                                                        
                                                                                                                        <td style="background-color:#bfbfbf;height:50px;">
                                                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-align:center;font-size:16px;">Total ventas anual</span>
                                                                                                                        </td>';
                                                                                                                            if(!empty($muestra_anos_venta)){ 
                                                                                                                                $c=0;
                                                                                                                                foreach ($muestra_anos_venta as $av){
                                                                                                                                    $anoss_pie[] = $av->id_ano;
                                                                                                                                    echo '<td style="background-color:#bfbfbf;text-align:center;border-right:1px solid #000">
                                                                                                                                            <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                            <tr>
                                                                                                                                                <td style="text-align:center;width:70px;border-right:1px solid #000;height:45px;">
                                                                                                                                                <div id="total_ano_consolid_'.$av->nombre_ano.'" style="white-space: nowrap;"></div>
                                                                                                                                                <input type="hidden" value="" id="input_total_ano_consolid_'.$av->nombre_ano.'"/>
                                                                                                                                                </td>
                                                                                                                                                <td style="text-align:center;width:70px;border-right:1px solid #000;height:50px;">
                                                                                                                                                    <div id="total_trib_consolid_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                    <input type="hidden" value="" id="input_tribut_ano_consolid_'.$av->nombre_ano.'"/>
                                                                                                                                                    </td>
                                                                                                                                                <td style="text-align:center;width:30px;">
                                                                                                                                                    <div id="total_var_consolid_'.$av->nombre_ano.'" title="total_var_consolid_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            </table>
                                                                                                                                        </td>';
                                                                                                                                    $c++;
                                                                                                                                }
                                                                                                                            }
                                                                                                                    
                                                                                                                    echo '</tr>
                                                                                                                    
                                                                                                                    </table>';

                                                                                                            }else{


                                                                                                                if(devuelve_logo_empresa_cabecera($id_empresa)){
                                                                                                                    $logo= '<img '.devuelve_logo_empresa_cabecera($id_empresa).' class="img-responsive" style="width:15%;height:15%" alt="'.devuelve_nombre_empresa($id_empresa).'"/>';
                                                                                                                }else{
                                                                                                                    $logo= devuelve_nombre_empresa($id_empresa);
                                                                                                                }

                                                                                                                    echo '<div align="center">'.$logo.'</div><br>
                                                                                                                    
                                                                                                                    <table border="1px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                        
                                                                                                                        <!-- INICIO CAEBECERA -->
                                                                                                                        <tr>
                                                                                                                            <td style="text-align:center;background-color:#93cddd;height:35px;">
                                                                                                                            <span style="font-size:18px;">Año</span>
                                                                                                                            </td>';
                                                                                                                            if(!empty($muestra_anos_venta)){ 
                                                                                                                                $c=0;
                                                                                                                                foreach ($muestra_anos_venta as $av)
                                                                                                                                {
                                                                                                                                $anoss[] = $av->id_ano;
                                                                                                                                echo '<td style="text-align:center;background-color:#93cddd;">
                                                                                                                                    <span style="font-size:18px;">'.strtoupper($av->nombre_ano).'</span>
                                                                                                                                </td>';
                                                                                                                                $c++;
                                                                                                                                }
                                                                                                                            }
                                                                                                                    echo'</tr>
                                                                                                                        
                                                                                                                        <tr>
                                                                                                                            <td style="text-align:center;width:175px;background-color:#93cddd;height:35px;">
                                                                                                                            <span style="font-size:18px;">Mes</span>
                                                                                                                            </td>';
                                                                                                                            for($j=0;$j<$c;$j++){
                                                                                                                            echo '<td style="background-color:#93cddd">
                                                                                                                                    <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                        <tr>
                                                                                                                                            <td style="text-align:center;width:70px;background-color:#93cddd;border-right:1px solid #000;height:35px;">
                                                                                                                                                <span style="font-size:14px;">Total</span>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:70px;background-color:#93cddd;border-right:1px solid #000;height:35px;">
                                                                                                                                            <span style="font-size:14px;">Tributario</span>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:30px;background-color:#93cddd;height:35px;">
                                                                                                                                            <span style="font-size:14px;">VAR</span>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>';
                                                                                                                            }
                                                                                                                            echo '
                                                                                                                        </tr>
                                                                                                                        
                                                                                                                        <!-- FIN CAEBECERA -->
                                                                                                                        
                                                                                                                        
                                                                                                                        
                                                                                                                        <!-- INICIO GRILLA -->';
                                                                                                                    
                                                                                                                        foreach ($muestra_meses_venta as $mv){
                                                                                                                            $meses[] = $mv->id_mes;
                                                                                                                            echo '
                                                                                                                                <tr>
                                                                                                                                    <td style="height:35px;border-right:2px solid #000;">
                                                                                                                                        &nbsp;'.strtoupper($mv->nombre_mes).'
                                                                                                                                    </td>
                                                                                                                                    <input type="hidden" id="mes'.$mv->id_mes.'" value="'.devuelve_mes_espanol($mv->id_mes).'"/>';
                                                                                                                                $c=0;
                                                                                                                                foreach ($muestra_anos_venta as $av){
                                                                                                                                    
                                                                                                                                    if($_SESSION['his_agr_trib']==1){
                                                                                                                                        $onclick='onclick="ingresa_monto_tributario(\''.$mv->id_mes.'\',\''.$av->nombre_ano.'\');"';
                                                                                                                                        $style='style="cursor:pointer;white-space: nowrap;"';
                                                                                                                                    }else{
                                                                                                                                        $onclick='&nbsp;';
                                                                                                                                        $style='style="white-space: nowrap;"';
                                                                                                                                    }

                                                                                                                                    echo '
                                                                                                                                    <input type="hidden" id="cl'.$mv->id_mes,$av->nombre_ano.'" value="'.devuelve_cant_lunes($mv->id_mes+1,$av->nombre_ano).'"/>
                                                                                                                                    <td>
                                                                                                                                    <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                        <tr>
                                                                                                                                            <td style="text-align:center;width:70px;border-right:1px solid #000;height:35px;">
                                                                                                                                            <div style="white-space: nowrap;" data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="'.devuelve_mes_espanol($mv->id_mes)." - ".$av->nombre_ano.'" id="div_total_'.$mv->id_mes."_".$av->nombre_ano.'">&nbsp;</div>
                                                                                                                                            <input type="hidden" value="" id="input_total_'.$mv->id_mes."_".$av->nombre_ano.'"/>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:70px;border-right:1px solid #000;height:35px;">
                                                                                                                                            <div  '.$style.' data-rel="popover" data-trigger="hover" data-placement="rigth" '.$onclick.' data-content="'.devuelve_mes_espanol($mv->id_mes)." - ".$av->nombre_ano.'"  id="div_trib_'.$mv->id_mes."_".$av->nombre_ano.'">&nbsp;</div>
                                                                                                                                            <input type="hidden" value="" id="input_trib_'.$mv->id_mes."_".$av->nombre_ano.'"/>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:15px;border-right:1px solid #000;">
                                                                                                                                            <div id="div_var_'.$mv->id_mes."_".$av->nombre_ano.'">&nbsp;</div>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>';
                                                                                                                                }
                                                                                                                        echo '</tr>
                                                                                                                        
                                                                                                                        <!-- FIN GRILLA -->';
                                                                                                                        }       
                                                                                                                        
                                                                                                                        echo " 
                                                                                                                        <!-- INICIO PIE -->
                                                                                                                            <tr style='background-color:#bfbfbf;'>
                                                                                                                                <td style='height:35px;'>
                                                                                                                                    <strong>&nbsp;ANUAL</strong>
                                                                                                                                </td>";
                                                                                                                                    foreach ($muestra_anos_venta as $av){
                                                                                                                                    echo '<td>
                                                                                                                                    <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                        <tr>
                                                                                                                                            <td style="background-color:#bfbfbf;text-align:center;width:70px;border-right:1px solid #000;height:35px;">
                                                                                                                                                <div id="div_total_ano_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                <input type="hidden" value="" id="input_total_ano_'.$av->nombre_ano.'"/>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:30px;background-color:#bfbfbf;border-right:1px solid #000;hight:35px;">
                                                                                                                                                <div id="div_trib_ano_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                <input type="hidden" value="" id="input_total_trib_ano_'.$av->nombre_ano.'"/>
                                                                                                                                            </td>
                                                                                                                                            <td style="text-align:center;width:30px;background-color:#bfbfbf;hight:35px;">
                                                                                                                                                <div id="div_var_ano_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                    </td>';
                                                                                                                                    }
                                                                                                                        echo "  
                                                                                                                            </tr>
                                                                                                                            
                                                                                                                            <tr style='background-color:#bfbfbf;'>
                                                                                                                                <td >
                                                                                                                                    <strong>&nbsp;Dif. año anterior</strong>
                                                                                                                                </td>";
                                                                                                                                    foreach ($muestra_anos_venta as $av)
                                                                                                                                    {
                                                                                                                                    echo '<td>
                                                                                                                                            <table border="0px" width="100%" cellpadding="0" cellspacing="0">
                                                                                                                                                <tr>
                                                                                                                                                    <td style="background-color:#bfbfbf;text-align:center;width:70px;border-right:1px solid #000;height:35px;">
                                                                                                                                                        <div id="div_dif_ano_ant_'.$av->nombre_ano.'" title="div_dif_ano_ant_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                        <input type="hidden" value="" id="input_dif_ano_ant_'.$av->nombre_ano.'"/>
                                                                                                                                                    </td>
                                                                                                                                                    <td style="background-color:#bfbfbf;text-align:center;width:30px;white-space: nowrap;border-right:1px solid #000;">
                                                                                                                                                        <div id="div_dif_ano_ant_tribut_'.$av->nombre_ano.'" title="div_dif_ano_ant_tribut_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                        <input type="hidden" value="" id="input_dif_ano_ant_tribut_'.$av->nombre_ano.'"/>
                                                                                                                                                    </td>
                                                                                                                                                    <td style="background-color:#bfbfbf;text-align:center;width:30px;white-space: nowrap;">
                                                                                                                                                    <div id="div_var_ano_tribut_'.$av->nombre_ano.'" style="white-space: nowrap;">&nbsp;</div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                    </td>';
                                                                                                                                    }
                                                                                                                        echo "
                                                                                                                            </tr>
                                                                                                                        
                                                                                                                        <!-- FIN PIE -->
                                                                                                                        
                                                                                                                        </table>";
                                                                                                                    }

                                                                                                                    ?>

                                                                                                            <script type="text/javascript">

                                                                                                            $(document).ready(function() {

                                                                                                            $('[data-rel=popover]').popover({html:true});

                                                                                                            //############################################//
                                                                                                            //INICIO HISTORICO EMPRESA  
                                                                                                            var meses = <?php echo json_encode($meses); ?>;
                                                                                                            var anoss = <?php echo json_encode($anoss); ?>;
                                                                                                            var cant_mes = meses.length;
                                                                                                            var cant_ano = anoss.length;

                                                                                                            //return_grilla
                                                                                                            let arg0 = [];
                                                                                                            for (var i0 = 0; i0 < cant_ano; i0++) {
                                                                                                                for (var j0 = 0; j0 < cant_mes; j0++) {
                                                                                                                    arg0.push({
                                                                                                                        year: anoss[i0],
                                                                                                                        month: meses[j0]
                                                                                                                    })
                                                                                                                }
                                                                                                            }         
                                                                                                            return_grilla(arg0);      

                                                                                                            //return_tributario
                                                                                                            let arg4 = [];
                                                                                                            for (var i4 = 0; i4 < cant_ano; i4++) {
                                                                                                                for (var j4 = 0; j4 < cant_mes; j4++) {
                                                                                                                    arg4.push({
                                                                                                                        year: anoss[i4],
                                                                                                                        month: meses[j4]
                                                                                                                    })
                                                                                                                }
                                                                                                            }         
                                                                                                            return_tributario(arg4);   

                                                                                                            //return_total_year
                                                                                                            let arg1 = [];
                                                                                                            for (var i1 = 0; i1 < cant_ano; i1++) {
                                                                                                                    arg1.push({
                                                                                                                        year: anoss[i1]
                                                                                                                    })
                                                                                                            }     

                                                                                                            return_total_year(arg1);     

                                                                                                            //return_total_year_tributario
                                                                                                            let arg5 = [];
                                                                                                            for (var i5 = 0; i5 < cant_ano; i5++) {
                                                                                                                    arg5.push({
                                                                                                                        year: anoss[i5]
                                                                                                                    })
                                                                                                            }     

                                                                                                            return_total_year_tributario(arg5);   
                                                                                                            //FIN HISTORICO EMPRESA
                                                                                                            //############################################//


                                                                                                            //############################################//
                                                                                                            //INICIO HISTORICO EMPRESA MADRE

                                                                                                            var anoss_cabecera = <?php echo json_encode($anoss_cabecera); ?>;
                                                                                                            var anoss_cuerpo = <?php echo json_encode($anoss_cuerpo); ?>;
                                                                                                            var empresaa_cuerpo = <?php echo json_encode($empresaa_cuerpo); ?>;
                                                                                                            var anoss_pie = <?php echo json_encode($anoss_pie); ?>;
                                                                                                            var empresass_usuario = <?php echo json_encode($empresass_usuario); ?>;

                                                                                                            var cant_ano_cabecera = anoss_cabecera.length;
                                                                                                            var cant_ano_cuerpo = anoss_cuerpo.length;
                                                                                                            var cant_emp_cuerpo = empresaa_cuerpo.length;
                                                                                                            var cant_ano_pie = anoss_pie.length;

                                                                                                            //return_consolidated_year
                                                                                                            let arg2 = [];
                                                                                                            for (var i2 = 0; i2 < cant_ano_pie; i2++) {
                                                                                                                    arg2.push({
                                                                                                                        year: anoss_pie[i2],
                                                                                                                        comp: empresass_usuario
                                                                                                                    })
                                                                                                            }
                                                                                                            return_consolidated_year(arg2);

                                                                                                            //return_consolidated_tribute
                                                                                                            let arg7 = [];
                                                                                                            for (var i7 = 0; i7 < cant_ano_pie; i7++) {
                                                                                                                    arg7.push({
                                                                                                                        year: anoss_pie[i7],
                                                                                                                        comp: empresaa_cuerpo
                                                                                                                    })
                                                                                                            }
                                                                                                            return_consolidated_tribute(arg7);

                                                                                                            //return_amount_new
                                                                                                            let arg3 = [];
                                                                                                            for (var i3 = 0; i3 < cant_ano_cuerpo; i3++) {
                                                                                                                    arg3.push({
                                                                                                                    year: anoss_cuerpo[i3],
                                                                                                                    comp: empresaa_cuerpo[i3]
                                                                                                                })
                                                                                                            }
                                                                                                            return_amount_new(arg3);

                                                                                                            //return_tribut_new
                                                                                                            let arg6 = [];
                                                                                                            for (var i6 = 0; i6 < cant_ano_cuerpo; i6++) {
                                                                                                                    arg6.push({
                                                                                                                    year: anoss_cuerpo[i6],
                                                                                                                    comp: empresaa_cuerpo[i6]
                                                                                                                })
                                                                                                            }
                                                                                                            return_tribut_new(arg6);

                                                                                                            //FIN HISTORICO EMPRESA MADRE
                                                                                                            //############################################//



                                                                                                            });


                                                                                                            //INICIO FUNCIONES HISTORICO EMPRESA  
                                                                                                            function return_grilla(arg) {
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('return_sales_grid/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg),
                                                                                                                        e: $('#id_empresa_guarda').val()
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        
                                                                                                                        for (const j in req) { 
                                                                                                                        
                                                                                                                            let res1 = req[j].res;
                                                                                                                            let m = req[j].m;
                                                                                                                            let a = req[j].a;
                                                                                                                            var monto_total_ano = 0;
                                                                                                                            var monto_total_mes = 0;
                                                                                                                            var monto_quincena = 0;

                                                                                                                            for (var i = 0; i < res1.length; i++) { 

                                                                                                                                //var id_venta = res[i].id_venta;
                                                                                                                                var monto_quincena = parseInt(res1[i].monto_quincena);

                                                                                                                                var id_mes = res1[i].id_mes;
                                                                                                                                var id_ano = res1[i].id_ano;

                                                                                                                                monto_total_mes = monto_total_mes + monto_quincena;

                                                                                                                                if (monto_total_mes > 0) {

                                                                                                                                    $("#div_total_" + m + "_" + a).html(formatNumber(monto_total_mes));
                                                                                                                                    $("#input_total_" + m + "_" + a).val(monto_total_mes);

                                                                                                                                    var ano_actual = $('#input_total_' + m + "_" + a).val();
                                                                                                                                    var ano_anterior = $('#input_total_' + m + "_" + (a - 1)).val();
                                                                                                                                    var total_var = (((parseInt(ano_actual) - parseInt(ano_anterior)) /
                                                                                                                                        parseInt(ano_anterior)) * 100);

                                                                                                                                    if (total_var > 0) {
                                                                                                                                        $("#div_var_" + m + "_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "blue");
                                                                                                                                    } else if (total_var < 0) {
                                                                                                                                        $("#div_var_" + m + "_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "red");
                                                                                                                                    } else if (total_var == 0) {
                                                                                                                                        $("#div_var_" + m + "_" + a).html(Math.round(total_var) + " %");
                                                                                                                                    } else {
                                                                                                                                        $("#div_var_" + m + "_" + a).html();
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function return_tributario(arg) {
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('return_tributario_grid/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg),
                                                                                                                        e: $('#id_empresa_guarda').val()
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        
                                                                                                                        for (const j in req) { 
                                                                                                                        
                                                                                                                            let res1 = req[j].res;
                                                                                                                            let m = req[j].m;
                                                                                                                            let a = req[j].a;
                                                                                                                            var monto_tributario = 0;

                                                                                                                            for (var i = 0; i < res1.length; i++) { 

                                                                                                                                //var id_venta = res[i].id_venta;
                                                                                                                                var monto_tributario = parseInt(res1[i].monto_tributario);

                                                                                                                                var id_mes = res1[i].id_mes;
                                                                                                                                var id_ano = res1[i].id_ano;

                                                                                                                                if (monto_tributario > 0) {

                                                                                                                                    $("#div_trib_" + m + "_" + a).html(formatNumber(monto_tributario));
                                                                                                                                    $("#input_trib_" + m + "_" + a).val(monto_tributario);

                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function return_total_year(arg) {

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('return_total_year/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg),
                                                                                                                        e: $('#id_empresa_guarda').val()
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        for (const j in req) { 
                                                                                                                            
                                                                                                                            let res2 = req[j].res;
                                                                                                                            let a = req[j].a;
                                                                                                                            
                                                                                                                            for (var i = 0; i < res2.length; i++) { 

                                                                                                                                var total_año = parseInt(res2[i].total_año);
                                                                                                                                //console.log(total_año);
                                                                                                                                monto_total_año = total_año;

                                                                                                                                if (monto_total_año > 0) {

                                                                                                                                    $("#div_total_ano_" + a).html(formatNumber(monto_total_año));
                                                                                                                                    $("#input_total_ano_" + a).val(monto_total_año);
                                                                                                                                    $("#input_dif_ano_ant_" + a).val(monto_total_año);

                                                                                                                                    var ano_actual_anual = $('#input_total_ano_' + a + '').val();
                                                                                                                                    var ano_anterior_anual = $('#input_total_ano_' + (a - 1)).val();
                                                                                                                                    var total_var_anual = (((parseInt(ano_actual_anual) - parseInt(ano_anterior_anual)) / parseInt(ano_anterior_anual)) * 100);
                                                                                                                                    var diferencia_anterior = ano_actual_anual - ano_anterior_anual;

                                                                                                                                    if (total_var_anual > 0) {
                                                                                                                                        $("#div_var_ano_" + a).html(Math.round(total_var_anual) + " %").css("color", "blue")
                                                                                                                                        $("#div_dif_ano_ant_" + a).html(formatNumber(diferencia_anterior));
                                                                                                                                    } else if (total_var_anual < 0) {
                                                                                                                                        $("#div_var_ano_" + a).html(Math.round(total_var_anual) + " %").css("color", "red");
                                                                                                                                        $("#div_dif_ano_ant_" + a).html(formatNumber(diferencia_anterior)).css("color", "red");
                                                                                                                                    } else if (total_var_anual == 0) {
                                                                                                                                        $("#div_var_ano_" + a).html();
                                                                                                                                        $("#div_dif_ano_ant_" + a).html(formatNumber(diferencia_anterior));
                                                                                                                                    } else {
                                                                                                                                        $("#div_var_ano_" + a).html();
                                                                                                                                    }

                                                                                                                                } else {
                                                                                                                                    $("#div_total_ano_" + a + "").html();
                                                                                                                                }

                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function return_total_year_tributario(arg) {

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('return_total_year_tribut/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg),
                                                                                                                        e: $('#id_empresa_guarda').val()
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        for (const j in req) { 
                                                                                                                            
                                                                                                                            let res2 = req[j].res;
                                                                                                                            let a = req[j].a;
                                                                                                                            
                                                                                                                            for (var i = 0; i < res2.length; i++) { 

                                                                                                                                var total_tributario_año = parseInt(res2[i].total_tributario_año);
                                                                                                                                //console.log(total_año);
                                                                                                                                monto_total_trib_año = total_tributario_año;

                                                                                                                                if (monto_total_trib_año > 0) {

                                                                                                                                    $("#div_trib_ano_" + a).html(formatNumber(monto_total_trib_año));
                                                                                                                                    //$("#input_total_ano_" + a).val(monto_total_trib_año);
                                                                                                                                    $("#input_dif_ano_ant_tribut_" + a).val(monto_total_trib_año);

                                                                                                                                    var ano_actual_anual = $('#input_dif_ano_ant_tribut_' + a + '').val();
                                                                                                                                    var ano_anterior_anual = $('#input_dif_ano_ant_tribut_' + (a - 1)).val();
                                                                                                                                    var total_var_anual = (((parseInt(ano_actual_anual) - parseInt(ano_anterior_anual)) / parseInt(ano_anterior_anual)) * 100);
                                                                                                                                    var diferencia_anterior = ano_actual_anual - ano_anterior_anual;

                                                                                                                                    if (total_var_anual > 0) {
                                                                                                                                        $("#div_var_ano_tribut_" + a).html(Math.round(total_var_anual) + " %").css("color", "blue")
                                                                                                                                        $("#div_dif_ano_ant_tribut_" + a).html(formatNumber(diferencia_anterior));
                                                                                                                                    }

                                                                                                                                } else {
                                                                                                                                    $("#div_total_ano_" + a + "").html();
                                                                                                                                }

                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                                }
                                                                                                            //FIN FUNCIONES HISTORICO EMPRESA  


                                                                                                            //INICIO FUNCIONES HISTORICO EMPRESA MADRE
                                                                                                            function return_amount_new(arg) {
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('return_sales_grid_consolidated/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg)
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        for (const j in req) { 
                                                                                                                            let res1 = req[j].res;
                                                                                                                            let m = req[j].e;
                                                                                                                            let a = req[j].a;
                                                                                                                            var monto_total_ano = 0;
                                                                                                                            var monto_total_mes = 0;
                                                                                                                            var monto_quincena = 0;

                                                                                                                            for (var i = 0; i < res1.length; i++) { 

                                                                                                                                //var id_venta = res[i].id_venta;
                                                                                                                                var monto_quincena = parseInt(res1[i].monto_quincena);

                                                                                                                                var id_mes = res1[i].id_mes;
                                                                                                                                var id_ano = res1[i].id_ano;

                                                                                                                                monto_total_mes = monto_total_mes + monto_quincena;

                                                                                                                                if (monto_total_mes > 0) {

                                                                                                                                    $("#ano_consolid_" + a + "_" + m).html(formatNumber(monto_total_mes));
                                                                                                                                    $("#totalmes" + a + m).val(monto_total_mes);

                                                                                                                                    var ano_actual = $('#totalmes' + m + a).val();
                                                                                                                                    var ano_anterior = $('#totalmes' + m + (a - 1)).val();
                                                                                                                                    var total_var = (((parseInt(ano_actual) - parseInt(ano_anterior)) /
                                                                                                                                        parseInt(ano_anterior)) * 100);

                                                                                                                                    if (total_var > 0) {
                                                                                                                                        $("#var_consolid_" +  a + "_" + m).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "blue");
                                                                                                                                    } else if (total_var < 0) {
                                                                                                                                        $("#var_consolid_" +  a + "_" + m).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "red");
                                                                                                                                    } else if (total_var == 0) {
                                                                                                                                        $("#var_consolid_" +  a + "_" + m).html(Math.round(total_var) + " %");
                                                                                                                                    } else {
                                                                                                                                        $("#var_consolid_" +  a + "_" + m).html();
                                                                                                                                    }

                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function return_tribut_new(arg) {
                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('return_tribut_grid_consolidated/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg)
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        for (const j in req) { 
                                                                                                                            let res1 = req[j].res;
                                                                                                                            let m = req[j].e;
                                                                                                                            let a = req[j].a;
                                                                                                                            var monto_total_ano = 0;
                                                                                                                            var monto_total_mes = 0;
                                                                                                                            var monto_tributario = 0;

                                                                                                                            for (var i = 0; i < res1.length; i++) { 

                                                                                                                                //var id_venta = res[i].id_venta;
                                                                                                                                var monto_tributario = parseInt(res1[i].monto_tributario);

                                                                                                                                var id_mes = res1[i].id_mes;
                                                                                                                                var id_ano = res1[i].id_ano;

                                                                                                                                monto_total_mes = monto_total_mes + monto_tributario;
                                                                                                                                monto_total_ano = monto_total_ano + monto_total_mes
                                                                                                                                if (monto_total_mes > 0) {

                                                                                                                                    $("#trib_consolid_" + a + "_" + m).html(formatNumber(monto_total_mes));
                                                                                                                                    $("#input_total_trib_consolid_" + a + "_" + m).val(monto_total_mes);
                                                                                                                                    //$("#input_total_trib_acumulated_" + a + "_" + m).val(monto_total_ano);
                                                                                                                                    //total_trib_consolid_

                                                                                                                                }
                                                                                                                            }
                                                                                                                            
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function return_consolidated_year(arg) {

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('return_consolidated_year/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        arg: JSON.stringify(arg)
                                                                                                                    },
                                                                                                                    success: function(req) {
                                                                                                                        for (const j in req) { 
                                                                                                                            let res3 = req[j].res;
                                                                                                                            let a = req[j].a;
                                                                                                                            for (var i = 0; i < res3.length; i++) { 

                                                                                                                                var total_año = parseInt(res3[i].total_año);

                                                                                                                                monto_total_año = total_año;

                                                                                                                                if (monto_total_año > 0) {

                                                                                                                                    $("#total_ano_consolid_" + a).html(formatNumber(monto_total_año));
                                                                                                                                    $("#input_total_ano_consolid_" + a).val(monto_total_año);

                                                                                                                                    var ano_actual_anual = $('#input_total_ano_consolid_' + a ).val();
                                                                                                                                    var ano_anterior_anual = $('#input_total_ano_consolid_' + (a - 1)).val();
                                                                                                                                    var total_var = (((parseInt(ano_actual_anual) - parseInt(
                                                                                                                                            ano_anterior_anual)) / parseInt(ano_anterior_anual)) *
                                                                                                                                        100);
                                                                                                                                    if (total_var > 0) {
                                                                                                                                        $("#total_var_consolid_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "blue");
                                                                                                                                    } else if (total_var < 0) {
                                                                                                                                        $("#total_var_consolid_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                            "color", "red");
                                                                                                                                    } else if (total_var == 0) {
                                                                                                                                        $("#total_var_consolid_" + a).html(Math.round(total_var) + " %");
                                                                                                                                    } else {
                                                                                                                                        $("#total_var_consolid_" + a).html();
                                                                                                                                    }

                                                                                                                                } else {
                                                                                                                                    $("#total_ano_consolid_" + a + "").html();
                                                                                                                                }

                                                                                                                            }
                                                                                                                        }
                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }


                                                                                                            function return_consolidated_tribute(arg) {

                                                                                                            $.ajax({

                                                                                                                url: "<?php echo site_url('return_consolidated_year_tribute/')?>",
                                                                                                                type: "POST",
                                                                                                                dataType: "JSON",
                                                                                                                data: {
                                                                                                                    arg: JSON.stringify(arg)
                                                                                                                },
                                                                                                                success: function(req) {
                                                                                                                    for (const j in req) { 
                                                                                                                        let res3 = req[j].res;
                                                                                                                        let a = req[j].a;
                                                                                                                        for (var i = 0; i < res3.length; i++) { 

                                                                                                                            var total_año = parseInt(res3[i].total_año);

                                                                                                                            monto_total_año = total_año;

                                                                                                                            if (monto_total_año > 0) {

                                                                                                                                $("#total_trib_consolid_" + a).html(formatNumber(monto_total_año));
                                                                                                                                $("#input_tribut_ano_consolid_" + a).val(monto_total_año);


                                                                                                                            } else {
                                                                                                                                $("#total_trib_consolid_" + a + "").html();
                                                                                                                            }

                                                                                                                        }
                                                                                                                    }
                                                                                                                },
                                                                                                                error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                    alert('Error al obtener los datos.');
                                                                                                                }
                                                                                                            });
                                                                                                            }

                                                                                                            //FIN FUNCIONES HISTORICO EMPRESA MADRE

                                                                                                            function devuelve_monto(a, m) {

                                                                                                                var e = $('#id_empresa_guarda').val();

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('devuelve_venta_grilla/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        a: a,
                                                                                                                        m: m,
                                                                                                                        e: e
                                                                                                                    },
                                                                                                                    success: function(res1) {

                                                                                                                        var monto_total_ano = 0;
                                                                                                                        var monto_total_mes = 0;
                                                                                                                        var monto_quincena = 0;

                                                                                                                        for (var i = 0; i < res1.length; i++) { 

                                                                                                                            //var id_venta = res[i].id_venta;
                                                                                                                            var monto_quincena = parseInt(res1[i].monto_quincena);

                                                                                                                            var id_mes = res1[i].id_mes;
                                                                                                                            var id_ano = res1[i].id_ano;

                                                                                                                            monto_total_mes = monto_total_mes + monto_quincena;

                                                                                                                            if (monto_total_mes > 0) {

                                                                                                                                $("#total_" + m + "_" + a).html(formatNumber(monto_total_mes));
                                                                                                                                $("#totalmes" + m + a).val(monto_total_mes);

                                                                                                                                var ano_actual = $('#totalmes' + m + a).val();
                                                                                                                                var ano_anterior = $('#totalmes' + m + (a - 1)).val();
                                                                                                                                var total_var = (((parseInt(ano_actual) - parseInt(ano_anterior)) /
                                                                                                                                    parseInt(ano_anterior)) * 100);

                                                                                                                                if (total_var > 0) {
                                                                                                                                    $("#var_" + m + "_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                        "color", "blue");
                                                                                                                                } else if (total_var < 0) {
                                                                                                                                    $("#var_" + m + "_" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                        "color", "red");
                                                                                                                                } else if (total_var == 0) {
                                                                                                                                    $("#var_" + m + "_" + a).html(Math.round(total_var) + " %");
                                                                                                                                } else {
                                                                                                                                    $("#var_" + m + "_" + a).html();
                                                                                                                                }

                                                                                                                            }



                                                                                                                        }

                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });


                                                                                                            }

                                                                                                            function devuelve_total_año(a) {

                                                                                                                var e = $('#id_empresa_guarda').val();

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('devuelve_total_ano/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        a: a,
                                                                                                                        e: e
                                                                                                                    },
                                                                                                                    success: function(res2) {

                                                                                                                        for (var i = 0; i < res2.length; i++) { 

                                                                                                                            var total_año = parseInt(res2[i].total_año);

                                                                                                                            monto_total_año = total_año;

                                                                                                                            if (monto_total_año > 0) {

                                                                                                                                $("#total_ano" + a).html(formatNumber(monto_total_año));
                                                                                                                                $("#totalano" + a).val(monto_total_año);
                                                                                                                                $("#difanoant" + a).val(monto_total_año);

                                                                                                                                var ano_actual_anual = $('#totalano' + a + '').val();
                                                                                                                                var ano_anterior_anual = $('#totalano' + (a - 1)).val();
                                                                                                                                var total_var_anual = (((parseInt(ano_actual_anual) - parseInt(
                                                                                                                                    ano_anterior_anual)) / parseInt(ano_anterior_anual)) * 100);
                                                                                                                                var diferencia_anterior = ano_actual_anual - ano_anterior_anual;


                                                                                                                                if (total_var_anual > 0) {
                                                                                                                                    $("#var_ano" + a).html(Math.round(total_var_anual) + " %").css(
                                                                                                                                        "color", "blue");
                                                                                                                                    $("#dif_ano_ant_" + a).html(formatNumber(diferencia_anterior));
                                                                                                                                } else if (total_var_anual < 0) {
                                                                                                                                    $("#var_ano" + a).html(Math.round(total_var_anual) + " %").css(
                                                                                                                                        "color", "red");
                                                                                                                                    $("#dif_ano_ant_" + a).html(formatNumber(diferencia_anterior)).css(
                                                                                                                                        "color", "red");
                                                                                                                                } else if (total_var_anual == 0) {
                                                                                                                                    $("#var_ano" + a).html(Math.round(total_var_anual) + " %");
                                                                                                                                    $("#dif_ano_ant_" + a).html(formatNumber(diferencia_anterior));
                                                                                                                                } else {
                                                                                                                                    $("#var_ano" + a).html();
                                                                                                                                }

                                                                                                                            } else {
                                                                                                                                $("#total_ano" + a + "").html();
                                                                                                                            }

                                                                                                                        }

                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function devuelve_consolidado_año(a) {

                                                                                                                var e = $('#id_empresa_guarda').val();

                                                                                                                $.ajax({

                                                                                                                    url: "<?php echo site_url('devuelve_consolidado_ano/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        a: a,
                                                                                                                        e: e
                                                                                                                    },
                                                                                                                    success: function(res3) {

                                                                                                                        for (var i = 0; i < res3.length; i++) { 

                                                                                                                            var total_año = parseInt(res3[i].total_año);

                                                                                                                            monto_total_año = total_año;

                                                                                                                            if (monto_total_año > 0) {

                                                                                                                                $("#ano_consolid" + a).html(formatNumber(monto_total_año));

                                                                                                                                var ano_actual_anual = $('#totalano' + a + '').val();
                                                                                                                                var ano_anterior_anual = $('#totalano' + (a - 1)).val();
                                                                                                                                var total_var = (((parseInt(ano_actual_anual) - parseInt(
                                                                                                                                    ano_anterior_anual)) / parseInt(ano_anterior_anual)) * 100);

                                                                                                                                if (total_var > 0) {
                                                                                                                                    $("#var_consolid" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                        "color", "blue");
                                                                                                                                } else if (total_var < 0) {
                                                                                                                                    $("#var_consolid" + a).html(Math.round(total_var) + " %").css(
                                                                                                                                        "color", "red");
                                                                                                                                } else if (total_var == 0) {
                                                                                                                                    $("#var_consolid" + a).html(Math.round(total_var) + " %");
                                                                                                                                } else {
                                                                                                                                    $("#var_consolid" + a).html();
                                                                                                                                }

                                                                                                                            } else {
                                                                                                                                $("#ano_consolid" + a + "").html();
                                                                                                                            }

                                                                                                                        }

                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });
                                                                                                            }
                                                                                                            function ingresa_monto_tributario(m, a) {

                                                                                                                $('#form_tributario')[0].reset(); // reset for m on modals
                                                                                                                var idv = $("#total" + m + "_" + a + "").val();
                                                                                                                var e = $('#id_empresa_guarda').val();
                                                                                                                var mes_español = $("#mes" + m + "").val();

                                                                                                                $('#id_mes_trib').val(m);
                                                                                                                $('#id_ano_trib').val(a);

                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('devuelve_tributario_editar/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        a: a,
                                                                                                                        m: m,
                                                                                                                        e: e
                                                                                                                    },
                                                                                                                    success: function(res4) {
                                                                                                                        var q = 1;
                                                                                                                        for (var i = 0; i < res4.length; i++) { 

                                                                                                                            var monto_tributario = res4[i].monto_tributario;
                                                                                                                            var id_mes = res4[i].id_mes;
                                                                                                                            var id_ano = res4[i].id_ano;

                                                                                                                            $("#monto_tributario").val(monto_tributario);

                                                                                                                            //$("#id_mes").val(id_mes);
                                                                                                                            //$("#id_ano").val(id_ano);
                                                                                                                            q++;
                                                                                                                        }

                                                                                                                        $('#modal_form_tributario').modal('show'); // show bootstrap modal
                                                                                                                        $('.modal-title').text('Ingresar monto Tributario para ' + mes_español + ' de ' +
                                                                                                                            a); // Set Title to Bootstrap modal title

                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });

                                                                                                                }


                                                                                                            function ingresa(m, a) {

                                                                                                                $('#form')[0].reset(); // reset for m on modals
                                                                                                                var idv = $("#total" + m + "_" + a + "").val();
                                                                                                                var e = $('#id_empresa_guarda').val();
                                                                                                                var mes_español = $("#mes" + m + "").val();

                                                                                                                $('#id_mes').val(m);
                                                                                                                $('#id_ano').val(a);

                                                                                                                $('.date-picker').datepicker({
                                                                                                                    todayBtn: false,
                                                                                                                    language: "es",
                                                                                                                    autoclose: true,
                                                                                                                    todayHighlight: false,
                                                                                                                    daysOfWeekDisabled: "0,6",
                                                                                                                    weekStart: 1,
                                                                                                                    //startDate: '05/05/2008'
                                                                                                                    defaultViewDate: {
                                                                                                                        year: a,
                                                                                                                        month: m,
                                                                                                                        day: 1
                                                                                                                    }
                                                                                                                })

                                                                                                                $.ajax({
                                                                                                                    url: "<?php echo site_url('devuelve_venta_editar/')?>",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "JSON",
                                                                                                                    data: {
                                                                                                                        a: a,
                                                                                                                        m: m,
                                                                                                                        e: e
                                                                                                                    },
                                                                                                                    success: function(res4) {
                                                                                                                        var q = 1;
                                                                                                                        for (var i = 0; i < res4.length; i++) { 

                                                                                                                            var monto_quincena = res4[i].monto_quincena;
                                                                                                                            var lunes_quincena = res4[i].lunes_quincena;
                                                                                                                            var monto_iva = res4[i].monto_iva;
                                                                                                                            var lunes_iva = res4[i].lunes_iva;
                                                                                                                            var id_mes = res4[i].id_mes;
                                                                                                                            var id_ano = res4[i].id_ano;

                                                                                                                            $("#monto_quincena" + q).val(monto_quincena);
                                                                                                                            $("#lunes_quincena" + q).val(lunes_quincena);

                                                                                                                            $("#monto_iva_mostrar").val(monto_iva);
                                                                                                                            $("#monto_iva").val(monto_iva);
                                                                                                                            $("#lunes_iva").val(lunes_iva);

                                                                                                                            $("#id_mes").val(id_mes);
                                                                                                                            $("#id_ano").val(id_ano);
                                                                                                                            q++;
                                                                                                                        }

                                                                                                                        $('#modal_form').modal('show'); // show bootstrap modal
                                                                                                                        $('.modal-title').text('Ingresar montos para ' + mes_español + ' de ' +
                                                                                                                            a); // Set Title to Bootstrap modal title

                                                                                                                    },
                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al obtener los datos.');
                                                                                                                    }
                                                                                                                });

                                                                                                            }


                                                                                                            function cancel() {
                                                                                                                //$('.date-picker').val("").datepicker("update");
                                                                                                                //$(".date-picker").datepicker("clearDates");
                                                                                                                $('.date-picker').datepicker('update', '');
                                                                                                            }

                                                                                                            function save() {
                                                                                                                var id_e = $('#id_empresa_guarda').val();

                                                                                                                $('#btnSave').text('Guardando...'); //change button text
                                                                                                                $('#btnSave').attr('disabled', true); //set button disable
                                                                                                                var url;

                                                                                                                url = "<?php echo site_url('save_venta')?>";

                                                                                                                // ajax adding data to database
                                                                                                                $.ajax({
                                                                                                                    url: url,
                                                                                                                    type: "POST",
                                                                                                                    data: $('#form').serialize(),
                                                                                                                    dataType: "JSON",
                                                                                                                    success: function(data) {
                                                                                                                        $('#btnSave').text('Guardar'); //change button text
                                                                                                                        $('#btnSave').attr('disabled', false); //set button enable
                                                                                                                        $('#modal_form').modal('hide');
                                                                                                                        $(location).attr('href', '<?php echo base_url() ?>historico/' + id_e);
                                                                                                                    },

                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al guardar o actualizar los datos.');
                                                                                                                        $('#btnSave').text('Guardando...'); //change button text
                                                                                                                        $('#btnSave').attr('disabled', false); //set button enable
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            function save_tributario() {
                                                                                                                var id_e = $('#id_empresa_guarda').val();

                                                                                                                $('#btnSave').text('Guardando...'); //change button text
                                                                                                                $('#btnSave').attr('disabled', true); //set button disable
                                                                                                                var url;

                                                                                                                url = "<?php echo site_url('save_tributario')?>";

                                                                                                                // ajax adding data to database
                                                                                                                $.ajax({
                                                                                                                    url: url,
                                                                                                                    type: "POST",
                                                                                                                    data: $('#form_tributario').serialize(),
                                                                                                                    dataType: "JSON",
                                                                                                                    success: function(data) {
                                                                                                                        $('#btnSave').text('Guardar'); //change button text
                                                                                                                        $('#btnSave').attr('disabled', false); //set button enable
                                                                                                                        $('#modal_form_tributario').modal('hide');
                                                                                                                        $(location).attr('href', '<?php echo base_url() ?>historico/' + id_e);
                                                                                                                    },

                                                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                                                        alert('Error al guardar o actualizar los datos.');
                                                                                                                        $('#btnSave').text('Guardando...'); //change button text
                                                                                                                        $('#btnSave').attr('disabled', false); //set button enable
                                                                                                                    }
                                                                                                                });
                                                                                                            }
                                                                                                            </script>

                
            
                        <div class="modal fade" id="modal_form" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h3 class="modal-title">Person Form</h3>
                                    </div>
                                    <div class="modal-body form">
                                        <form action="#" id="form" class="form-horizontal">
                                            <input type="hidden" value="" name="id_mes" id="id_mes" />
                                            <input type="hidden" value="" name="id_ano" id="id_ano" />
                                            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda" />
                                            <input type="hidden" value="2" name="cant_lun" id="cant_lun" />
                                            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" />
                                            <input type="hidden" value="" id="monto_iva" name="monto_iva" />

                                            <div class="form-body">
                                                <?php for($m=1;$m<=2;$m++){?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Monto Quincena
                                                        <?php echo $m; ?></label>
                                                    <div class="col-md-8">
                                                        <input id="<?php echo "monto_quincena".$m ?>" name="monto_quincena[]"
                                                            placeholder="Monto Quincena"
                                                            class="form-control monto" type="text" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Fecha Quincena
                                                        <?php echo $m; ?></label>
                                                    <div class="col-md-8">
                                                        <input id="<?php echo "lunes_quincena".$m ?>" name="lunes_quincena[]"
                                                            class="form-control date-picker" type="text"
                                                            data-date-format="yyyy-mm-dd" value="" />
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <!--<div class="form-group">
                                                    <label class="control-label col-md-4">Monto IVA</label>
                                                    <div class="col-md-8">
                                                        <input name="monto_iva_mostrar" id="monto_iva_mostrar" placeholder="0"
                                                            class="form-control" type="text" autocomplete="off"
                                                            readonly="readonly">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Fecha IVA </label>
                                                    <div class="col-md-8">
                                                        <input id="lunes_iva" name="lunes_iva" class="form-control date-picker"
                                                            type="text" data-date-format="yyyy-mm-dd" value="" />
                                                    </div>
                                                </div>-->

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btnSave" onclick="save()"
                                            class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <div class="modal fade" id="modal_form_tributario" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h3 class="modal-title">Person Form</h3>
                                    </div>
                                    <div class="modal-body form">
                                        <form action="#" id="form_tributario" class="form-horizontal">
                                            <input type="hidden" value="" name="id_mes_trib" id="id_mes_trib" />
                                            <input type="hidden" value="" name="id_ano_trib" id="id_ano_trib" />
                                            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda" />
                                            <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" />

                                            <div class="form-body">

                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Monto </label>
                                                    <div class="col-md-8">
                                                        <input name="monto_tributario" id="monto_tributario" placeholder="Monto"
                                                            class="form-control" type="text" autocomplete="off">
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btnSave" onclick="save_tributario()"
                                            class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>
                </div>
            </div>

        </div>   
</div><!-- /.main-content-inner -->


                <script>
                function sumar() {

                    var total = 0;

                    $(".monto").each(function() {
                        if (isNaN(parseFloat($(this).val()))) {
                            total += 0;
                        } else {
                            total += parseFloat($(this).val());
                        }
                    });

                    total_iva = total * 0.19;
                    $('#monto_iva').val(total_iva);
                    $('#monto_iva_mostrar').val(total_iva);

                }
                </script>