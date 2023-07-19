<?php
$ALLEmpresas = get_all_company();

$IsMother = is_company_mother($id_empresa);

$fecha_actual_2 = date("Y-m-d");
$canitdad_meses = devuelve_parametro_mes($id_empresa);
if($fecha_actual_2==$fecha_actual){
  $fechaaa = $fecha_actual;
  //echo "iguales";
}else{
  $fechaaa = $fecha_actual;
  //echo "no iguales";
}

//echo $fecha_actual;

// $anterior = strtotime('-' . $rango_anterior . ' month', strtotime($lunes[0]));

$un_mes_atras = strtotime("-1 month", strtotime($fechaaa));

//echo ">".$un_mes_atras."<br>".$fechaaa;

$fecha_un_mes_atras = date("Y-m-d", $un_mes_atras);

//Muestra el calendario un mes atras
list($a, $m, $d) = explode('-', $fecha_un_mes_atras);


/*$id_res_encript = strtr($id_res_encript,array('.' => '+', '-' => '=', '~' => '/'));
$id_res_encript = $this->encryption->decrypt($id_res_encript);*/

$year=$a;
$month=$m;
$day=$d;

/*
$year='2019';
$month='02';
$day='04';
*/

$primerDia=date("Y-m-d",mktime(0,0,0,$month,$day,$year));
$fechaInicio=strtotime($primerDia);

$anterior = '';
$siguiente = '';
$dias_lunes = '';
$dias_domingo = '';
$lunes = array();
$domingos = array();
$domingo = '';
$dialunes = 0;
$dialunesq = 0;
$lun_dom_x = array();
$diasslunes = array();
$diassdomingo = array();
$diasslunes_ant = array();
$diassdomingo_ant = array();
$diadomingo = array();
$lunes_ant = array();
$domingo_ant = array();
$meses_array = array();
$años_array = array();
$cantidad_lunes_array = array();
$meses_arrayq = array();
$años_arrayq = array();
$cantidad_lunes_arrayq = array();
$rango = $canitdad_meses;
$colspan_totales = $rango + 1;

$mes_fi = date ("m", $fechaInicio);
$año_fi = date ("Y", $fechaInicio);
$id_cuenta = array();
$id_subcuenta = array();
$idcarray = array();
$idsarray = array();
$idcsarray = array();


echo "<table id='tbfix' border='0px' width='100%'>

        <tr>
          <td style='border:0px solid #000;min-width:150px; max-width:150px;'>
            <table border='0px' width='100%'>
              <tr>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                &nbsp;
                </td>
              </tr>
              <tr>
                <td style='border:1px solid #000;text-align:right;font-weight:bold;background-color:#cde8ef;'>
                PRIMERA QUINCENA
              </td>
              </tr>
              <tr>
                <td style='border:1px solid #000;text-align:right;font-weight:bold;background-color:#cde8ef;'>
                SEGUNDA QUINCENA
                </td>
              </tr>
              <tr>
                <td style='border:1px solid #000;text-align:right;font-weight:bold;background-color:#93cddd;'>
                  TOTAL
                </td> 
              </tr>
            </table>
          </td>";

for ($i=$mes_fi;$i<$mes_fi+$rango;$i++){
  
    $meses=date('m', mktime(0, 0, 0, $i, 1, $mes_fi ) );
    $mesesq=date('m', mktime(0, 0, 0, $i+1, 1, $mes_fi ) );
    $año=date('Y', mktime(0, 0, 0, $i, 1, $año_fi ) );
    $añoq=date('Y', mktime(0, 0, 0, $i, 1, $año_fi+1) );
    $timestamp = strtotime( "01-".$meses."-".$año );
    $diasdelmes = date( "t", $timestamp );

    echo "<td>
            <table border='0px' width='100%'>
                <tr>
                    <td class='colspan-xls' style='border:1px solid #000;text-align:center;font-weight:bold;background-color:#f2f2f2;' colspan=".$diasdelmes.">".devuelve_mes_espanol($meses)." / ".$año."</td>
                </tr>

                <tr>";

                for ($dias=1;$dias<=$diasdelmes;$dias++){

                  $timestamp_dias = strtotime( $dias."-".$meses."-".$año );
                  $numerodia = date('N', $timestamp_dias);
                  $numerosemana = date ("W", $timestamp_dias);
                  $timestamp_diashoy = strtotime( date("d-m-Y") );
                  $numerosemanahoy = date ("W", $timestamp_diashoy);

                  $dias_lunes = date("Y-m-d", $timestamp_dias);
                  $dias_lunes_ant = date("Y-m-d",strtotime($dias_lunes."- 7 days"));

                  $dias_domingo = date("Y-m-d",strtotime($dias_lunes."+ 6 days"));
                  (strlen($dias) == 1)? $lun="0".$dias:$lun=$dias;
                  $dom = date("d",strtotime($dias_lunes."+ 6 days"));
                  $dias_domingo_ant = date("Y-m-d",strtotime($dias_domingo."- 7 days"));

                  if($numerosemana == $numerosemanahoy){
                    $backgroundcolor="#ff6961";
                  }else{
                    $backgroundcolor="#f2f2f2";
                  }
                  
                  if($numerodia==1){
                      $dialunes++;
                      $lunes[] = $dias_lunes;
                      $domingos[] = $dias_domingo;
                      $lun_dom_x[] = $dias_lunes." ".$dias_domingo;
                      $lunes_ant[] = $dias_lunes_ant;
                      $domingo_ant[] = $dias_domingo_ant;
                      echo "<td style='border:1px solid #000;text-align:center;font-weight:bold;background-color:".$backgroundcolor.";'>".$lun." al ".$dom."</td>";
                  }
                  
                }

                $diasslunes[] = $lunes;
                $diasslunes_ant[] = $lunes_ant;
                $diassdomingo[] = $domingos;
                

                $diassdomingo_ant[] = $domingo_ant;
                $meses_array[] = $meses;
                $meses_arrayq[] = $mesesq;
                $años_array[] = $año;
                $años_arrayq[] = $añoq;
                $cantidad_lunes_array[] = $dialunes;
                $cantidad_lunes_arrayq[] = $dialunesq;
                $ide = $id_empresa;
                //echo $dialunes;
                if($dialunes==4){
                  $siguiente = date("Y-m-d",strtotime($domingos[3]."- 1 month"));
                }else{
                  $siguiente = date("Y-m-d",strtotime($domingos[4]."- 1 month"));
                }

                $rango_anterior = 2;//(2 * $rango) - 1;
                //echo "lunes[0]-".$lunes;

                $anterior = strtotime ( '-'.$rango_anterior.' month' , strtotime ( $lunes[0] ) ) ;
                //echo "1".$anterior."-";
                $anterior = date ( 'Y-m-d' , $anterior );
                //echo $anterior;
                $anterior = $this->encryption->encrypt($anterior);
                $anterior = strtr($anterior,array('+' => '.', '=' => '-', '/' => '~'));

                $siguiente = $this->encryption->encrypt($siguiente);
                $siguiente = strtr($siguiente,array('+' => '.', '=' => '-', '/' => '~'));

                $hoy = date ( 'Y-m-d' );
                $hoy = $this->encryption->encrypt($hoy);
                $hoy = strtr($hoy,array('+' => '.', '=' => '-', '/' => '~'));

                echo '</tr>';

                $total_quincnena=0;
                $idq=1;
                for($q=0;$q<2;$q++){
                  $quincena = devuelve_quincena($ide,$meses,$año,$idq);
                  if(!empty($quincena[$q])){
                    $quincena[$q]=$quincena[$q];
                  }else{
                    $quincena[$q]=0;
                  }
                  $total_quincnena += $quincena[$q];
                  $colspan = $dialunes - 1;
                echo "<tr>
                        <td colspan='".$colspan."'>&nbsp;</td>";
                      echo "<td style='border:1px solid #000;text-align:right;background-color:#cde8ef;font-weight:bold;'>".formato_precio("$", $quincena[$q], 'first')."</td>
                      </tr>";
                      $idq++;
                }
                echo "<tr>
                <td colspan='".$colspan."'>&nbsp;</td>
                        <td style='border:1px solid #000;text-align:right;background-color:#93cddd;font-weight:bold;'>
                        ".formato_precio("$", $total_quincnena,'first')."
                        </td>
                      </tr>
                  </table>
          </td>";
          

    $dialunes = 0;
    $dialunesq = 0;
    $diadomingo = 0;
    $lunes =array();
    $domingos =array();
    $lunes_ant =array();
    $domingo_ant =array();
}

echo '<tr class="btn-control"><td>&nbsp;</td><td colspan="'.$colspan_totales.'"><table border=0px; width="100%">

<tr>
<td>
<div style="text-align:left;">
<button type="button" class="btn btn-xs btn-info" aria-label="Anterior" title="Anterior" onclick="anterior(\''.$anterior.'\')">
  <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
</button>
</div>
</td>
<td>
<div style="text-align:center;">
<button type="button" class="btn btn-xs btn-info" aria-label="Hoy" title="Hoy" onclick="hoy(\''.$hoy.'\')">
  <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
</button>
</div>
</td>
<td>
<div style="text-align:right;">
<button type="button" class="btn btn-xs btn-info" aria-label="Siguiente" title="Siguiente" onclick="siguiente(\''.$siguiente.'\')">
  <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
</button>
</div>
</td>
</tr>
</table></tr></td></tr></table>';


echo "<table id='tabresumen' border='0px' width='100%'>";
  if($IsMother){
    echo '<tr>
            <td align="center" colspan='.$colspan_totales.'>
            <div style="visibility:hidden;">'.devuelve_nombre_empresa($id_empresa).'</div>
            <div class="name-company">
              <img '.devuelve_logo_empresa_cabecera($id_empresa).' class="img-responsive" style="width:10%;height:10%" alt=""/>
            </div>
    </td></tr>';
    
    echo '<tr><td style="border:1px solid #000; !important;text-align:right;min-width:150px; max-width:150px">Ingresos&nbsp;</td>';
      for ($d=0;$d<$rango;$d++){
        echo '<td><table border="1px" width="100%"><tr>';
        for($m=0;$m<$cantidad_lunes_array[$d];$m++){
              if($cantidad_lunes_array[$d]== '4444'){
                $porcentaje_celda = 'style="width:25%;"';
              }else{
                $porcentaje_celda = 'style="width:20%;"';
              }
              echo '<td '.$porcentaje_celda.'>';
              echo '<div id="ingreso_ccg_'.$diasslunes[$d][$m]."_".$diassdomingo[$d][$m].'" style="text-align:center;">&nbsp;</div></td>';
        }
        echo '</tr></table></td>';
      }
    echo '</tr>';
    
    echo '<tr><td style="border:1px solid #000; !important;text-align:right;">Egresos&nbsp;</td>';
      for ($c=0;$c<$rango;$c++){
        echo '<td><table border="1px" width="100%"><tr>';
        for($l=0;$l<$cantidad_lunes_array[$c];$l++){
              if($cantidad_lunes_array[$c]== '4444'){
                $porcentaje_celda = 'style="width:25%;"';
              }else{
                $porcentaje_celda = 'style="width:20%;"';
              }
              
              echo '<td '.$porcentaje_celda.'>';
              echo '<div id="egreso_ccg_'.$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" style="text-align:center;">&nbsp;</div></td>';
        }

        echo '</tr></table></td>';
      }
    echo '</tr>';

    echo '<tr><td style="border:1px solid #000; !important;text-align:right;">Saldos&nbsp;</td>';
      for ($c=0;$c<$rango;$c++){
        echo '<td><table border="1px" width="100%"><tr>';
        for($l=0;$l<$cantidad_lunes_array[$c];$l++){
              if($cantidad_lunes_array[$c]== '4444'){
                $porcentaje_celda = 'style="width:25%;"';
              }else{
                $porcentaje_celda = 'style="width:20%;"';
              }
              echo '<td '.$porcentaje_celda.'>';
              echo '<div  id="saldo_ccg_'.$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" style="text-align:center;">&nbsp;</div></td>';
        }
        echo '</tr></table></td>';
      }
    echo '</tr>';
    echo '<tr>
      <td style="border:1px solid #000;!important; text-align:right;">Acumulados&nbsp;</td>';
      for ($tia=0;$tia<$rango;$tia++){
        echo '<td>
              <table border="0px" width="100%">
              <tr>';
              for($m=0;$m<$cantidad_lunes_array[$tia];$m++){
                        if($cantidad_lunes_array[$tia]== '4444'){
                          $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
                        }else{
                          $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
                        }
                    echo '<td '.$porcentaje_celda.'>';
                    echo '<div id="acumulado_ccg_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'" style="text-align:center;" class="accg">&nbsp;</div></td>';
              }
            echo '</tr>
          </table>
        </td>';
      }
    echo '</tr>';
  }




    /*foreach ($ALLEmpresas as $key => $empresa) {
      if($IsMother || $cl->id_empresa===$id_empresa){*/
        foreach ($mostrar_empresas_usuario_sin_em as $cl){ 
          $empresass_usuario[] = $cl->id_empresa;
          if($IsMother || $cl->id_empresa===$id_empresa){
        echo '
        <tr>
                <td align="center" colspan='.$colspan_totales.'>
                  <div style="visibility:hidden;">'.devuelve_nombre_empresa($cl->id_empresa).'</div>
                  <div class="name-company-individual"><img '.devuelve_logo_empresa_cabecera($cl->id_empresa).' class="img-responsive" style="width:10%;height:10%" alt="'.$cl->nombre_empresa.'" title="'.$cl->nombre_empresa.'"/></div>
                </td>
              </tr>';
        
        echo '<tr>
                <td style="border:1px solid #000;  !important;text-align:right;min-width:150px; max-width:150px;">Ingresos&nbsp;</td>';
          for ($c=0;$c<$rango;$c++){
            echo '<td><table border="1px" width="100%"><tr>';
            for($l=0;$l<$cantidad_lunes_array[$c];$l++){
                  if($cantidad_lunes_array[$c]== '4444'){
                    $porcentaje_celda = 'style="width:25%;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;"';
                  }
                  echo '<td '.$porcentaje_celda.'>';
                  echo '<div id="ing_'.$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'_'.$cl->id_empresa.'"
                          class="ingreso" 
                          data-empresa="'.$cl->id_empresa.'"
                          data-lunes="'.$diasslunes[$c][$l].'"
                          data-domingo="'.$diassdomingo[$c][$l].'"
                          data-lunesAnt="'.$diasslunes_ant[$c][$l].'"
                          data-domingoAnt="'.$diassdomingo_ant[$c][$l].'" style="text-align:center;">&nbsp;</div>
                        <input value="" type="hidden" value="0" id="monto_ingreso_'.$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'_'.$cl->id_empresa.'"/>
                        <input value="" type="hidden" value="0" id="monto_ingreso_acum'.$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'_'.$cl->id_empresa.'"/>
                        <input type="hidden" value="" id="montoquin' . $diasslunes[$c][$l] .'_'.$cl->id_empresa . '" />';
                  echo '</td>';
            }
            echo '</tr></table></td>';
          }
        echo '</tr>';
        echo '<tr><td style="border:1px solid #000;  !important; text-align:right;">Egresos&nbsp;</td>';
          for ($cc=0;$cc<$rango;$cc++){

            echo '<td><table border="1px" width="100%"><tr>';

            for($ll=0;$ll<$cantidad_lunes_array[$cc];$ll++){

                  if($cantidad_lunes_array[$cc]== '4444'){
                    $porcentaje_celda = 'style="width:25%;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;"';
                  }
                  
                  echo '<td '.$porcentaje_celda.'>';
                  echo '
                  <div id="egr_'.$diasslunes[$cc][$ll]."_".$diassdomingo[$cc][$ll].'_'.$cl->id_empresa.'"
                  class="egreso" 
                  data-empresa="'.$cl->id_empresa.'"
                  data-lunes="'.$diasslunes[$cc][$ll].'"
                  data-domingo="'.$diassdomingo[$cc][$ll].'"
                  data-lunesAnt="'.$diasslunes_ant[$cc][$ll].'"
                  data-domingoAnt="'.$diassdomingo_ant[$cc][$ll].'"
                  style="text-align:center;"
                  >&nbsp;</div>
                  
                  <input type="hidden" value="0" id="monto_egreso_'.$diasslunes[$cc][$ll]."_".$diassdomingo[$cc][$ll].'_'.$cl->id_empresa.'" value=""/>';


                  echo '</td>';


            }

            echo '</tr></table></td>';
          }
        echo '</tr>';
        echo '<tr><td style="border:1px solid #000;  !important; text-align:right;">Saldo&nbsp;</td>';
          for ($ccc=0;$ccc<$rango;$ccc++){
            echo '<td><table border="1px" width="100%"><tr>';
            for($lll=0;$lll<$cantidad_lunes_array[$ccc];$lll++){

                  if($cantidad_lunes_array[$ccc]== '4444'){
                    $porcentaje_celda = 'style="width:25%;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;"';
                  }
                  
                  echo '<td '.$porcentaje_celda.'>';
                  //$ID_SALDO = uniqid().uniqid().strtotime($diasslunes[$ccc][$lll]);
                  echo '
                  <div  id="sal_'.$diasslunes[$ccc][$lll]."_".$diassdomingo[$ccc][$lll].'_'.$cl->id_empresa.'"
                  class="saldo" 
                  data-empresa="'.$cl->id_empresa.'"
                  data-lunes="'.$diasslunes[$ccc][$lll].'"
                  data-domingo="'.$diassdomingo[$ccc][$lll].'"
                  data-lunesAnt="'.$diasslunes_ant[$ccc][$lll].'"
                  data-domingoAnt="'.$diassdomingo_ant[$ccc][$lll].'" style="text-align:center;">&nbsp;</div>
                  
                  <input type="hidden" value="0" data-id="sal_'.$diasslunes[$ccc][$lll]."_".$diassdomingo[$ccc][$lll].'_'.$cl->id_empresa.'" id="monto_saldo_'.$diasslunes[$ccc][$lll]."_".$diassdomingo[$ccc][$lll].'_'.$cl->id_empresa.'" value=""/>
                  
                  <input type="hidden" value="0" data-id="sal_'.$diasslunes[$ccc][$lll]."_".$diassdomingo[$ccc][$lll].'_'.$cl->id_empresa.'" id="monto_saldo_actual_'.$diasslunes[$ccc][$lll]."_".$diassdomingo[$ccc][$lll].'_'.$cl->id_empresa.'" value=""/>';

                  echo '</td>';


            }
            echo '</tr></table></td>';
          }
        echo "</tr>";
        echo '<tr><td style="border:1px solid #000;  !important; text-align:right;">Acumulado&nbsp;</td>';
          for ($tia=0;$tia<$rango;$tia++){
            echo '<td>
                  <table border="0px" width="100%">
                  <tr>';
                  for($m=0;$m<$cantidad_lunes_array[$tia];$m++){

                            if($cantidad_lunes_array[$tia]== '4444'){
                              $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
                            }else{
                              $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
                            }
echo '<td '.$porcentaje_celda.'>';
                        //$ID_ACUMULATE =uniqid().uniqid().strtotime($diasslunes[$tia][$m]);
                        echo '<div id="acu_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'_'.$cl->id_empresa.'"
                                      class="acumulate" 
                                      data-empresa="'.$cl->id_empresa.'"
                                      data-lunes="'.$diasslunes[$tia][$m].'"
                                      data-domingo="'.$diassdomingo[$tia][$m].'"
                                      data-lunesAnt="'.$diasslunes_ant[$tia][$m].'"
                                      data-domingoAnt="'.$diassdomingo_ant[$tia][$m].'"
                                      style="text-align:center;">&nbsp;</div>
                                      
                                      <input data-id="acu_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'_'.$cl->id_empresa.'" id="monto_acumulado_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'_'.$cl->id_empresa.'" type="hidden" value="0" value=""/>
                                      <input data-id="acu_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'_'.$cl->id_empresa.'" id="monto_acumulado_ant_'.$diasslunes[$tia][$m]."_".$diassdomingo[$tia][$m].'_'.$cl->id_empresa.'" type="hidden" value="0" value=""/>';
                        echo '</td>';
                  }
                echo '</tr>
              </table>
            </td>';
          }
        echo "</tr>";
      }
    }
  
echo "</table>";
if(!es_casa_central($id_empresa)){ ?>
<div class="hr hr14 hr-dotted"></div>
  <div class="row">
  <div class="col-sm-0">
  </div><!-- /.col -->
  <div class="col-sm-12">
    <figure class='highcharts-figure'>
        <div id='container'></div>
        <p class='highcharts-description'>
            <?php 

            for($l=0;$l<count($lun_dom_x);$l++){
                list($lunx,$domx)=explode(" ",$lun_dom_x[$l]);
                $lunesx[]="'".$lunx."'";
                $valorx_ingresos[] = devuelve_ingresos_valor_lunes($lunx,$domx,$id_empresa);
                $valorx_egresos[] = devuelve_egresos_valor_lunes($lunx,$domx,$id_empresa);
            }

            ?>
        </p>
    </figure>
  </div><!-- /.row --> 
  <div class="col-sm-0">
  </div><!-- /.col -->
  </div><!-- /.row -->  
          <?php } ?>
<script type="text/javascript">
var id_empresa = $('#id_empresa_guarda').val();
(function() {
    Date.prototype.toMySQL = (evt) =>{
        var year, month, day;
        year = String(evt.getFullYear());
        month = String(evt.getMonth() + 1);
        month = month.length === 1 ? "0" + month : month;
        day = String(evt.getDate());
        day = day.length === 1 ? "0" + day : day;
        return year + "-" + month + "-" + day;
    }
})();
$(document).ready(function() {

  <?php if(!es_casa_central($id_empresa)){ ?>
  
  Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },
    xAxis: {
        categories: [<?php echo join($lunesx, ',') ?>],
        allowDecimals: false
    },
    yAxis: {
        title: {
            text: null
        },
        labels: {
            formatter: function () {
                return this.value / 1000 + 'k';
            }
        }
    },
    tooltip: {
        pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
    },
    series: [{
        name: 'Ingresos',
        data: [<?php echo join($valorx_ingresos, ',') ?>],
        //data: [110000, 0, 0, 0, 0, 200, 700000, 666666, 0, 0, 0, 650000, 0],
        color: '#69aa46'
    }, {
        name: 'Egresos',
        data: [<?php echo join($valorx_egresos, ',') ?>],
        //data: [55000, 0, 0, 0, 0, 100, 351161, 333333, 0, 0, 0, 351161, 0],
        color: '#dd5a43'
    }]
});
<?php } ?>

    var idcsarray = <?php echo json_encode($idcsarray); ?>;
    //console.log(idcsarray);
    var diasslunes = <?php echo json_encode($diasslunes); ?>;
    //console.log(diasslunes);
    var diassdomingo = <?php echo json_encode($diassdomingo); ?>;
    //console.log(diassdomingo);
    var diasslunes_ant = <?php echo json_encode($diasslunes_ant); ?>;
    //console.log(diasslunes_ant);
    var diassdomingo_ant = <?php echo json_encode($diassdomingo_ant); ?>;
    //console.log(diassdomingo_ant);
    var mesesarray = <?php echo json_encode($meses_array); ?>;
    //console.log(mesesarray);
    var añosarray = <?php echo json_encode($años_array); ?>;
    //console.log(añosarray);
    var lunesarray = <?php echo json_encode($cantidad_lunes_array); ?>;
    //console.log(lunesarray);
    var mesesarrayq = <?php echo json_encode($meses_arrayq); ?>;
    //console.log(mesesarrayq);
    var añosarrayq = <?php echo json_encode($años_arrayq); ?>;
    //console.log(añosarrayq);
    var lunesarrayq = <?php echo json_encode($cantidad_lunes_arrayq); ?>;
    //console.log(lunesarrayq);
    
    let fortnight = [];
    $('.ingreso').each((e,o)=>{
      fortnight.push({
          id_empresa_guarda: $(o).data('empresa'),
          lunes_quincena: $(o).data('lunes'),
          ft: $(o).data('domingo'),
          id: $(o).attr('id')
        });
    });
    return_all_fortnight(fortnight);
    
    let increase = [];
    $('.ingreso').each((e,o)=>{
      increase.push({
          id_empresa_guarda: $(o).data('empresa'),
          fi: $(o).data('lunes'),
          ft: $(o).data('domingo'),
          fi_a: $(o).data('lunesAnt'),
          ft_a: $(o).data('domingoAnt'),
          id: $(o).attr('id')
        });
    });
    return_all_ingreso(increase);
    
    let egreso = [];
    $('.egreso').each((e,o)=>{
      egreso.push({
          id_empresa_guarda: $(o).data('empresa'),
          fi: $(o).data('lunes'),
          ft: $(o).data('domingo'),
          fi_a: $(o).data('lunesAnt'),
          ft_a: $(o).data('domingoAnt'),
          id: $(o).attr('id')
        });
    });
    return_all_egreso(egreso);

    let acumulate = [];
    let last_empresa = null;
    let last_acumulate = null;
    $('.acumulate').each((e,o)=>{
      if(last_empresa!==null){
        if(last_empresa !== $(o).data('empresa')){
          let fi_ = new Date(last_acumulate.ft);
          let ft_ = new Date(last_acumulate.ft);
          fi_.setDate(fi_.getDate() + 2);
          ft_.setDate(ft_.getDate() + 8);
          last_acumulate.fi =  fi_.toMySQL(fi_);
          last_acumulate.ft =  ft_.toMySQL(ft_);
          acumulate.push(JSON.parse(JSON.stringify(last_acumulate)));
        }
      }
      last_acumulate = {
        id_empresa_guarda: $(o).data('empresa'),
        fi: $(o).data('lunes'),
        ft: $(o).data('domingo'),
        fi_a: $(o).data('lunesant'),
        ft_a: $(o).data('domingoant'),
        id: $(o).attr('id')
      };
      acumulate.push(JSON.parse(JSON.stringify(last_acumulate)));
      
      last_empresa = $(o).data('empresa');
    });
    let fi_ = new Date(last_acumulate.ft);
    let ft_ = new Date(last_acumulate.ft);
    fi_.setDate(fi_.getDate() + 2);
    ft_.setDate(ft_.getDate() + 8);
    last_acumulate.fi =  fi_.toMySQL(fi_);
    last_acumulate.ft =  ft_.toMySQL(ft_);
    acumulate.push(last_acumulate);
    return_all_accumulated(acumulate);
});

var id_u = <?php echo $id_usuario; ?>;
var id_e = $('#id_empresa_guarda').val();

function siguiente(siguiente) {
    $(location).attr('href', '<?php echo base_url() ?>home_empresa/' + id_e + '/' + id_u + '/' + siguiente);
}

function hoy(hoy) {
    $(location).attr('href', '<?php echo base_url() ?>home_empresa/' + id_e + '/' + id_u + '/' + hoy);
}

function anterior(anterior) {
    $(location).attr('href', '<?php echo base_url() ?>home_empresa/' + id_e + '/' + id_u + '/' + anterior);
}

function return_all_fortnight(arg) {
  //console.log(arg);
  $.ajax({
        url: "<?php echo site_url('return_sale_resumen/')?>",
        type: "POST",
        dataType: "JSON",
        data: {
          arg: JSON.stringify(arg)
        },  
        success: function(rest) {
          
          for (var j = 0; j < rest.length; j++) { //cuenta la cantidad de registros

                    var monto_quincena = parseInt(rest[j].monto_quincena);
                    var lunes_quincena = rest[j].lunes_quincena;
                    var id_empresa = rest[j].id_empresa_guarda;

                    $("#montoquin" + lunes_quincena + "_" + id_empresa).val(monto_quincena);

                }
          //$('#loading_resumen_i').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Check log quincena.');//Error al obtener los datos
        }
    });
    }


function return_all_ingreso(arg) {
  //console.log(arg);
    $.ajax({
        url: "<?php echo site_url('return_all_increase/')?>",
        type: "POST",
        dataType: "JSON",
        data: {
            arg: JSON.stringify(arg),
            idtm: 1
        },
        beforeSend: function() {
        $('#loading_resumen_i').show();
    },   
        success: function(res) {

          for (var i = 0; i < res.length; i++) {
              let ID = res[i].id;
              let fn = $("#montoquin" + res[i].fi+"_"+res[i].id_empresa_guarda).val();
              let monto = parseInt(res[i].monto) + parseInt(fn);
              let get = res[i].fi+"_"+res[i].ft+"_"+res[i].id_empresa_guarda;
              let ccg = $("#ingreso_ccg_"+res[i].fi+"_"+res[i].ft);
              
              if(monto>0){
                ccg.attr("formet","false");
                //POR EMPRESA MADRE
                if(ccg.html() === '&nbsp;'){
                  ccg.html((monto));
                }else{
                  ccg.html((parseInt(ccg.html())+monto));
                }

                //POR EMPRESA
                $("#ing_" + get).html(formatNumber(monto));
                $("#monto_ingreso_" + get).val(monto);
                $("#monto_saldo_"+get).val(monto);
              
              }else{
                
                $("#ing_"+get).html('&nbsp;');
                $("#monto_ingreso_"+get).val(0);
                $("#monto_saldo_"+get).val(0);

              }}
              setTimeout(() => {
              for (var i = 0; i < res.length; i++) {
                let ccg = $("#ingreso_ccg_"+res[i].fi+"_"+res[i].ft);
                if(ccg.attr("formet") === 'false'){
                  ccg.attr("formet","true");
                  ccg.html(formatNumber(ccg.html()));
                }
              }
            }, 100);
          $('#loading_resumen_i').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener los datos.');//Error al obtener los datos
        }
    });
}

function return_all_egreso(arg) {
  //console.log(arg);
    $.ajax({
        url: "<?php echo site_url('return_all_egress/')?>",
        type: "POST",
        dataType: "JSON",
        data: {
            arg: JSON.stringify(arg),
            idtm: 2
        },
        beforeSend: function() {
        $('#loading_resumen_e').show();
        },  
        success: function(res) {
          //console.log(res);
            for (var i = 0; i < res.length; i++) {
              let ID = res[i].id;
              let monto = parseInt(res[i].monto);
              let get = res[i].fi+"_"+res[i].ft+"_"+res[i].id_empresa_guarda;
              let ccg = $("#egreso_ccg_"+res[i].fi+"_"+res[i].ft);
              //console.log(formatNumber(parseInt(ccg.html())+monto));
              
              if(monto>0){
                
                ccg.attr("formet","false");
                if(ccg.html() === '&nbsp;'){
                  ccg.html((monto));
                }else{
                  ccg.html((parseInt(ccg.html())+monto));
                }

                //POR EMPRESA
                $("#egr_" + get).html(formatNumber(monto));
                $("#monto_egreso_" + get).val(monto);

                 let ingreso = parseInt($("#monto_ingreso_" + get).val());
                let saldo = parseInt(ingreso) - parseInt(monto);

                let input_saldo_actual = $("#monto_saldo_actual_" + get);
                if (saldo > 0) {
                  $(input_saldo_actual.data('id')).html(formatNumber(saldo));
                  input_saldo_actual.val(saldo);
                } else {
                  $(input_saldo_actual.data('id')).html(formatNumber(saldo)).css("color", "red");
                  input_saldo_actual.val(saldo);
                }
                
                let input_acumulado_ant = $("#monto_acumulado_ant_" + get);
                let saldo_anterior = input_acumulado_ant.val(); // traigo saldo anterior
                saldo_anterior = saldo_anterior === undefined ? 0 : saldo_anterior;

                let acumulado = (saldo_anterior * 1) + (saldo * 1);
                
                if (acumulado > 0) {
                  $(input_acumulado_ant.data('id')).html(formatNumber(acumulado));
                  input_acumulado_ant.val(acumulado);
                } else {
                  $(input_acumulado_ant.data('id')).html(formatNumber(acumulado)).css("color", "red");
                  input_acumulado_ant.val(acumulado);
                }

              }else{
                
                $("#egr_" + get).html('&nbsp;');
                $("#monto_egreso_" + get).val(monto);
              }
            }
            setTimeout(() => {
              for (var i = 0; i < res.length; i++) {
                let ccg = $("#egreso_ccg_"+res[i].fi+"_"+res[i].ft);
                if(ccg.attr("formet") === 'false'){
                  ccg.attr("formet","true");
                  ccg.html(formatNumber(ccg.html()));
                }
              }
            }, 100);
            $('#loading_resumen_e').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener los datos');//Error al obtener los datos.
        }
    });
}

function return_all_accumulated(arg) {
  //return;
    $.ajax({
        url: "<?php echo site_url('return_accumulated/')?>",
        type: "POST",
        dataType: "JSON",
        data: {
          arg: JSON.stringify(arg),
          idtm: 2
        },
        beforeSend: function() {
        $('#loading_resumen_sa').show();
        },
        success: function(res) {
          for (var i = 0; i < res.length; i++) {
            let ID = res[i].id;
            let monto = parseInt(res[i].monto);
            let get = res[i].fi+"_"+res[i].ft+"_"+res[i].id_empresa_guarda;
            
            //POR EMPRESA
            let ingreso = isNaN(parseInt($("#monto_ingreso_" + get).val())) ? 0:parseInt($("#monto_ingreso_" + get).val());
            let egreso = isNaN(parseInt($("#monto_egreso_" + get).val())) ? 0:parseInt($("#monto_egreso_" + get).val());
            let saldo =  ingreso - (egreso);
            let input_saldo_actual = $("#monto_saldo_actual_" + get);
            let div_saldo_actual = $("#sal_" + get);
            
            if (saldo > 0) {
                $(input_saldo_actual.data('id')).html(formatNumber(saldo));
                input_saldo_actual.val(saldo);
                div_saldo_actual.html(formatNumber(saldo));
            
            }else if(saldo == 0){
              $(input_saldo_actual.data('id')).html(0);
              input_saldo_actual.val(saldo);
              div_saldo_actual.html(0);
            
            } else {
              $(input_saldo_actual.data('id')).html(formatNumber(saldo)).css("color", "red");
              input_saldo_actual.val(saldo);
              div_saldo_actual.html(formatNumber(saldo)).css("color", "red");
            }

            if($(input_saldo_actual.data('id')).html()==='0' || $(input_saldo_actual.data('id')).html()==='-'){
              $(input_saldo_actual.data('id')).html('0');
            }
            
            let ccg = $("#saldo_ccg_"+res[i].fi+"_"+res[i].ft);
            ccg.attr("formet","false");
            if(ccg.html() === '&nbsp;'){
              ccg.html(saldo);
            }else{
              ccg.html(parseInt(ccg.html())+saldo);
            }
            if(ccg.html()==='0' || ccg.html()==='-'){
              ccg.html('&nbsp;');
            }
            if(parseInt(ccg.html())<0){
              ccg.css("color", "red");
            }

            let input_acumulado_ant = $("#monto_acumulado_ant_" + get);
            let div_acumulado_ant = $("#acu_" + get);
            let saldo_anterior = input_acumulado_ant.val(); // traigo saldo anterior
            saldo_anterior = saldo_anterior === undefined ? 0 : saldo_anterior;
            let accg = $("#acumulado_ccg_"+res[i].fi+"_"+res[i].ft);
            let acumulado = monto;
            if (acumulado > 0) {
              $(input_acumulado_ant.data('id')).html(formatNumber(acumulado));
              input_acumulado_ant.val(acumulado);
              div_acumulado_ant.html(formatNumber(acumulado));

            }else if(acumulado == 0){
              $(input_acumulado_ant.data('id')).html(0);
              input_acumulado_ant.val(acumulado);
              div_acumulado_ant.html(0);

            } else {
              $(input_acumulado_ant.data('id')).html(formatNumber(acumulado)).css("color", "red");
              input_acumulado_ant.val(acumulado);
              div_acumulado_ant.html(formatNumber(acumulado)).css("color", "red");
            }
            
            if(accg.html() === '&nbsp;'){
              accg.html(acumulado);
            }else{
              accg.html(parseInt(accg.html())+parseInt(acumulado));
            }

            if(parseInt(accg.html())<0){
              accg.css("color", "red");
            }

            if($(input_acumulado_ant.data('id')).html()==='0' || $(input_acumulado_ant.data('id')).html()==='-' || $(input_acumulado_ant.data('id'))===''){
              $(input_acumulado_ant.data('id')).html('0');
            }
            if(accg.html()==='0' || accg.html()==='-' || accg.html()===''){
              accg.html('&nbsp;');
            }
          }
          $('.accg').each((o,evt)=>{
            evt = $(evt);
            evt.html(formatNumber($(evt).html()));
            if(evt.html()==='0' || evt.html()==='-' || evt.html()===''){
              evt.html('0');
            }
          });
          setTimeout(() => {
              for (var i = 0; i < res.length; i++) {
                let ccg = $("#saldo_ccg_"+res[i].fi+"_"+res[i].ft);
                if(ccg.attr("formet") === 'false'){
                  ccg.attr("formet","true");
                  ccg.html(formatNumber(ccg.html()));
                }
              }
            }, 100);
          $('#loading_resumen_sa').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener los datos.');//Error al obtener los datos.
        }
    });
}

</script>