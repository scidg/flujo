<?php

$canitdad_meses = devuelve_parametro_mes($id_empresa);
$fecha_actual_2 = date("Y-m-d");

if($fecha_actual_2==$fecha_actual){
  $fechaaa = $fecha_actual;
  //echo "iguales";
}else{
  $fechaaa = $fecha_actual;
  //echo "no iguales";
}


// $anterior = strtotime('-' . $rango_anterior . ' month', strtotime($lunes[0]));

$un_mes_atras = strtotime("-1 month", strtotime($fechaaa));

//echo ">".$un_mes_atras."<br>".$fechaaa;

$fecha_un_mes_atras = date("Y-m-d", $un_mes_atras);

//Muestra el calendario un mes atras
list($a, $m, $d) = explode('-', $fecha_un_mes_atras);

//Muestra el calendario deasde la fecha actual
//list($year, $month, $day) = explode('-', $fecha_actual);

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

if(!empty($mostrar_cuenta_egreso)){


$dias_lunes = '';
$dias_domingo = '';
$lunes = array();
$domingo = '';
$domingos = array();
$dialunes = 0;
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
$rango = $canitdad_meses;
$colspan_totales = $rango + 1;

$mes_fi = date ("m", $fechaInicio);
$año_fi = date ("Y", $fechaInicio);
$id_cuenta = array();
$id_subcuenta = array();
$idcarray = array();
$idsarray = array();
$idcsarray = array();

//HAmestica: Array cuentas a dibujar detalles
$ids_cuenta_mostrar="";

if(isset($_SESSION['ids_cuenta_mostrar'])){
  $ids_cuenta_mostrar=$_SESSION['ids_cuenta_mostrar'];
}

$array_cuentas_mostrar = explode(",",$ids_cuenta_mostrar);

//HAmestica: Array variables orden subcuentas
$orden_subcuenta="subcuenta";
$orden_subcuenta_direccion="asc";
$orden_subcuenta_fecini="";
$orden_subcuenta_fecfin="";

if(isset($_SESSION['orden_subcuenta'])){
  $orden_subcuenta=$_SESSION['orden_subcuenta'];
}

if(isset($_SESSION['orden_subcuenta_direccion'])){
  $orden_subcuenta_direccion=$_SESSION['orden_subcuenta_direccion'];
}

if(isset($_SESSION['orden_subcuenta_fecini'])){
  $orden_subcuenta_fecini=$_SESSION['orden_subcuenta_fecini'];
}

if(isset($_SESSION['orden_subcuenta_fecfin'])){
  $orden_subcuenta_fecfin=$_SESSION['orden_subcuenta_fecfin'];
}


echo "

<table id='tbfix' border='0px' width='100%'>
        <tr>
          <td style='border:0px solid #000;min-width:450px; max-width:450px;'>
            <table border='0px' width='100%'>
              <tr>
                <td>
                  <table border=0px; width='100%'>
                    <tr>
                      <td style='border:1px solid #000;width:15%;text-align:center;font-weight:bold;background-color:#f2f2f2;'>
                        Gasto Proy. ".date("Y")."
                      </td>
                      <td style='border:1px solid #000;width:15%;text-align:center;font-weight:bold;background-color:#f2f2f2;'>
                        Gasto Real ".date("Y")."
                      </td>
                      <td class='gtd' style='border:1px solid #000;text-align:center;font-weight:bold;background-color:#f2f2f2;'>
                        EGRESO
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
          </td>";

          for ($i=$mes_fi;$i<$mes_fi+$rango;$i++){
            
              $meses=date('m', mktime(0, 0, 0, $i, 1, $mes_fi ) );
              $año=date('Y', mktime(0, 0, 0, $i, 1, $año_fi ) );
              $timestamp = strtotime( "01-".$meses."-".$año );
              $diasdelmes = date( "t", $timestamp );

          echo "<td>
                      
                      <table border='0px' width='100%'>
                          
                          <tr>
                              <td style='border:1px solid #000;text-align:center;font-weight:bold;background-color:#f2f2f2;' colspan=".$diasdelmes.">".devuelve_mes_espanol($meses)." / ".$año."</td>
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
                              $hoy = date('d-m-Y');
                              $hoy_des = date('d-m-Y');
                              if($numerosemana == $numerosemanahoy){
                                $backgroundcolor="#ff6961";
                              }else{
                                $backgroundcolor="#f2f2f2";
                              }

                              if($numerodia==1){
                                  
                                  $dialunes++;
                                  $lunes[] = $dias_lunes;
                                  $domingos[] = $dias_domingo;
                                  
                                  $lunes_ant[]= $dias_lunes_ant;
                                  $domingo_ant[] = $dias_domingo_ant;
                                  
                                  echo "<td style='border:1px solid #000;text-align:center;font-weight:bold;background-color:".$backgroundcolor.";'>
                                          ".$lun." al ".$dom."
                                        </td>";
                              }
                              
                            }

                            $diasslunes[] = $lunes;
                            $diasslunes_ant[] = $lunes_ant;
                            $diassdomingo[] = $domingos;
                            $diassdomingo_ant[] = $domingo_ant;
                            $meses_array[] = $meses;
                            $años_array[] = $año;
                            $cantidad_lunes_array[] = $dialunes;
                            $ide = $id_empresa;
                            if($dialunes==4){
                              $siguiente = date("Y-m-d",strtotime($domingos[3]."- 1 month"));
                            }else{
                              $siguiente = date("Y-m-d",strtotime($domingos[4]."- 1 month"));
                            }

                            $rango_anterior = 2;//(2 * $rango) - 1;
                            $anterior = strtotime ( '-'.$rango_anterior.' month' , strtotime ( $lunes[0] ) ) ;
                            $anterior = date ( 'Y-m-d' , $anterior );

                            $siguiente = $this->encryption->encrypt($siguiente);
                            $siguiente = strtr($siguiente,array('+' => '.', '=' => '-', '/' => '~'));

                            $anterior = $this->encryption->encrypt($anterior);
                            $anterior = strtr($anterior,array('+' => '.', '=' => '-', '/' => '~'));


                            $hoy = date ( 'Y-m-d' );
                            $hoy = $this->encryption->encrypt($hoy);
                            $hoy = strtr($hoy,array('+' => '.', '=' => '-', '/' => '~'));

                          echo '</tr>

                      </table>
              </td>';
          

    $dialunes = 0;
    $diadomingo = 0;
    $lunes =array();
    $domingos =array();
    $lunes_ant =array();
    $domingo_ant =array();
}

echo '<tr>  
          <td>&nbsp;</td>  
          <td colspan="'.$colspan_totales.'">
            <table border=0px; width="100%">
              <tr>
                <td>
                  <div style="text-align:left;">
                    <button type="button" class="btn btn-xs btn-info" aria-label="Anterior" title="Anterior" onclick="anterior(\''.$anterior.'\',\''.$ids_cuenta_mostrar.'\')">
                      <span class="icon icon-arrow-left" aria-hidden="true"></span>
                    </button>
                  </div>
                </td>
                <td>
                  <div style="text-align:center;">
                    <button type="button" class="btn btn-xs btn-info" aria-label="Semana actual" title="Semana actual" onclick="hoy(\''.$hoy.'\',\''.$ids_cuenta_mostrar.'\')">
                      <span class="icon icon-calendar" aria-hidden="true"></span>
                    </button>
                  </div>
                </td>
                <td>
                  <div style="text-align:right;">
                    <button type="button" class="btn btn-xs btn-info" aria-label="Siguiente" title="Siguiente" onclick="siguiente(\''.$siguiente.'\',\''.$ids_cuenta_mostrar.'\')">
                      <span class="icon icon-arrow-right" aria-hidden="true"></span>
                    </button>
                  </div>
                </td>
              </tr>
            </table>
        </td>
      </tr>
</table>';

echo "<table border='0px' width='100%' id='tbcontent'>";

foreach ($mostrar_cuenta_egreso as $mc){
  //HAmestica: Llenar array cuentas a totalizar
  $idcarray[] = $mc->id_cuenta;
  
  //HAmestica: Mantener fecha al cargar detalles sub cuentas
  $mantener_fecha = $this->encryption->encrypt($fecha_actual);
  $mantener_fecha = strtr($mantener_fecha,array('+' => '.', '=' => '-', '/' => '~'));

  //HAmestica: Crear botón +/- para mostrar/ocultar detalles sub cuentas
  echo "
        <tr>
          <td colspan=".$colspan_totales." >
            &nbsp;
          </td>
        </tr>

        <tr>
          <td style='min-width:450px; max-width:450px;'>
            <table border=1px; width='100%'>
              <tr>
                <td title=".$mc->id_cuenta." colspan=".$colspan_totales." style='background-color:#93cddd;border:1px solid #000;cursor:pointer;'>
                  <strong>&nbsp;".strtoupper($mc->nombre_cuenta)."</strong>&nbsp;";

                  if(in_array($mc->id_cuenta, $array_cuentas_mostrar)){
                    echo '
                    <button type="button" class="btn btn-xs btn-info" aria-label="-" title="-" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')" style="position:inherit;">
                      <span class="icon icon-minus" aria-hidden="true"></span>
                    </button>';
                  }else{
                    echo '
                    <button type="button" class="btn btn-xs btn-info" aria-label="+" title="+" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')" style="position:inherit;">
                      <span class="icon icon-plus" aria-hidden="true"></span>
                    </button>';
                  }

                  //HAmestica: Ordenar sub cuentas alfabeticamente
                  $orden_subcuenta_icon='';
                  $orden_subcuenta_direccion_aux='';
                  
                  if($orden_subcuenta=='subcuenta'){
                    if($orden_subcuenta_direccion=='asc'){
                      $orden_subcuenta_direccion_aux='desc';
                      $orden_subcuenta_icon='-down';
                    }else{
                      $orden_subcuenta_direccion_aux='asc';
                      $orden_subcuenta_icon='-up';
                    }
                  }else{
                    $orden_subcuenta_direccion_aux='asc';
                  }

                  echo '
                    <button type="button" class="btn btn-xs btn-info" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\'subcuenta\',\''.$orden_subcuenta_direccion_aux.'\',\'\',\'\',\'1\')" style="position:inherit;">
                      <span class="icon icon icon-sort'.$orden_subcuenta_icon.'" aria-hidden="true"></span>
                    </button>
                  ';
                  
                  
                  //echo '<span class="icon icon-sort" aria-hidden="true"></span>';
                  //echo '<span class="icon icon-sort-up" aria-hidden="true"></span>';
                  //echo '<span class="icon icon-sort-down" aria-hidden="true"></span>';
              
              echo "
                </td>
              </tr>
            </table>   
          </td>";

          //HAmestica: Crear Tabla Totales Cuentas/Semana
          for ($c=0;$c<$rango;$c++){
            echo "
            <td style='background-color:#93cddd;border:1px solid #000;cursor:pointer;'>
              <table border='1px' width='100%'>
                <tr>";
                
                
                for($l=0;$l<$cantidad_lunes_array[$c];$l++){
                  if($cantidad_lunes_array[$c]== "4444"){
                    $porcentaje_celda = "style='width:25%;'";
                    $tamaño_celda='40%';
                  }else{
                    $porcentaje_celda = "style='width:20%;'";
                  }
                  
                  echo "<td ".$porcentaje_celda.">";
                    //HAmestica: Ajustar tamaño del total para incluir botón de ordenar subcuentas
                    if(in_array($mc->id_cuenta, $array_cuentas_mostrar)){
                      // echo '<div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;background-color:#FFF;font-weight:bold;" id="'.$mc->id_cuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')">0</div>';
                      echo '<div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;background-color:#93cddd;font-weight:bold;width:70.5%;font-size:10px !important;float:left;height:100%;" id="'.$mc->id_cuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')">0</div>';
                    }else{
                      // echo '<div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;background-color:#FFF;font-weight:bold;" id="'.$mc->id_cuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')">0</div>';
                      echo '<div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;background-color:#93cddd;font-weight:bold;width:70.5%;font-size:10px !important;float:left;height:100%;" id="'.$mc->id_cuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\''.$orden_subcuenta.'\',\''.$orden_subcuenta_direccion.'\',\''.$orden_subcuenta_fecini.'\',\''.$orden_subcuenta_fecfin.'\')">0</div>';
                    }

                  //HAmestica: Ordenar sub cuentas por semana/monto
                  $orden_subcuenta_icon='';
                  $orden_subcuenta_direccion_aux='';
                  
                  if($orden_subcuenta=='semana'){
                    //HAmestica: if para saber si es esta semana o no
                    if($orden_subcuenta_fecini==$diasslunes[$c][$l] && $orden_subcuenta_fecfin==$diassdomingo[$c][$l]){
                      if($orden_subcuenta_direccion=='asc'){
                        $orden_subcuenta_direccion_aux='desc';
                        $orden_subcuenta_icon='-up';
                      }else{
                        $orden_subcuenta_direccion_aux='asc';
                        $orden_subcuenta_icon='-down';
                      }
                    }else{
                      $orden_subcuenta_direccion_aux='desc';
                    }
                  }else{
                    $orden_subcuenta_direccion_aux='desc';
                  }

                  echo '
                    <button type="button" class="btn btn-xs btn-info" style="width:29%;float:left;position:inherit !important;" onclick="mostrar_detalle_subcuentas(\''.$mantener_fecha.'\',\''.$ids_cuenta_mostrar.'\',\''.$mc->id_cuenta.'\',\'semana\',\''.$orden_subcuenta_direccion_aux.'\',\''.$diasslunes[$c][$l].'\',\''.$diassdomingo[$c][$l].'\',\'1\')" style="position:inherit;">
                      <span class="icon icon icon-sort'.$orden_subcuenta_icon.'" aria-hidden="true"></span>
                    </button>
                  ';

                  echo "</td>";
                }

                echo "</tr>
              </table>
            </td>";
          }
          
        
        echo "</tr>";

//if(!empty($mostrar_subcuenta_egreso))
//{
  foreach ($mostrar_subcuenta_egreso as $ms)
    {
      $id_cuenta = $ms->id_cuenta;
      $id_subcuenta = $ms->id_subcuenta;

      //HAmestica: If que determina si se dibuja el detalle de las sub cuentas segun variable $idcuemostrar
      // if($mc->id_cuenta == $ms->id_cuenta){
      if(($mc->id_cuenta == $ms->id_cuenta) && in_array($ms->id_cuenta, $array_cuentas_mostrar)){
        $idcsarray[] = $id_cuenta."_".$id_subcuenta;
        
        if($_SESSION['egr_gas_agr']==1){
          $onclick='onclick="gas_proy(\''.$id_cuenta.'\',\''.$id_subcuenta.'\');"';
          $style='style="cursor:pointer;border:1px solid #000;width:15%;text-align:center;"';
        }else{
            $onclick='&nbsp;';
            $style='style="border:1px solid #000;width:15%;text-align:center;"';
        }


        echo '
          <tr>
            <td style="border:0px solid #000;">
              <table border=1px; width="100%">
                <tr>
                  <td '.$style.'>
                    <div '.$onclick.' id="proy_'.$id_cuenta."_".$id_subcuenta.'">&nbsp;</div>
                  </td>
                  <td style="border:1px solid #000;width:15%;text-align:center;">
                    <div id="real_'.$id_cuenta."_".$id_subcuenta.'">&nbsp;</div>
                  </td>
                  <td style="border:1px solid #000;">
                    &nbsp;'.$ms->nombre_subcuenta.'
                  </td>
                </tr>
              </table>
            </td>';

        for ($c=0;$c<$rango;$c++){

          /*$id_mov = $ms->id_cuenta."_".$ms->id_subcuenta."_".$lunes[$c]."_".$viernes[$c];
          $id_mov_encrypt = urlencode($this->encryption->encrypt($id_mov);*/
      echo '<td>
            ';
            //print_r($diasslunes[$c]);
            echo '

            <table border="1px" width="100%">
        <tr>';

        //diasslunes[meses-rango][dia lunes];
        for($l=0;$l<$cantidad_lunes_array[$c];$l++){
          //diasslunes[$c][$l]."_".$diassdomingo[$c][$l]
          /*$id_mov = $diasslunes[$c][$l]."n".$diassdomingo[$c][$l]."n";
          $id_mov_encrypt = $this->encryption->encrypt($id_mov);
          $id_mov_encrypt = strtr($id_mov_encrypt,array('+' => '.', '=' => '-', '/' => '~'));*/

          $lunea_a_viernes = $diasslunes[$c][$l] . "n" . $diassdomingo[$c][$l] . "n";
          $lunea_a_viernes_encrypted = $this->encryption->encrypt($lunea_a_viernes);
          $lunea_a_viernes_encrypted = strtr($lunea_a_viernes_encrypted, array('+' => '.', '=' => '-', '/' => '~'));

          $id_cero = $ms->id_cuenta."n".$ms->id_subcuenta."n".$diasslunes[$c][$l]."n".$diassdomingo[$c][$l]."n";
          $id_cero_encrypt = $this->encryption->encrypt($id_cero);
          $id_cero_encrypt = strtr($id_cero_encrypt,array('+' => '.', '=' => '-', '/' => '~'));


              if($cantidad_lunes_array[$c]== '4444'){
                $porcentaje_celda = 'style="width:25%;"';
              }else{
                $porcentaje_celda = 'style="width:20%;"';
              }
              
              echo '<td '.$porcentaje_celda.'>';
     
              echo '
              <div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;" onclick="movimiento(\''.$ms->id_cuenta.'\',\''.$ms->id_subcuenta.'\',\''.$diasslunes[$c][$l].'\',\''.$diassdomingo[$c][$l].'\')" id="'.$ms->id_cuenta."_".$ms->id_subcuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'" onmouseover="get_movimiento_detalle(\''.$ms->id_cuenta.'\',\''.$ms->id_subcuenta.'\',\''.$diasslunes[$c][$l].'\',\''.$diassdomingo[$c][$l].'\');">&nbsp;</div>
              <input type="hidden" value="" id="idm'.$ms->id_cuenta."_".$ms->id_subcuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'"/>
              <input type="hidden" value="" id="mont'.$ms->id_cuenta."_".$ms->id_subcuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'"/>
              <input type="hidden" value="'.$lunea_a_viernes_encrypted.'" id="idme'.$ms->id_cuenta."_".$ms->id_subcuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'"/>
              <input type="hidden" value="'.$id_cero_encrypt.'" id="id_cero'.$ms->id_cuenta."_".$ms->id_subcuenta."_".$diasslunes[$c][$l]."_".$diassdomingo[$c][$l].'"/>';


              echo '</td>';


        }

        echo '</tr>
      </table>

           </td>';
        }
      echo "</tr>";
      }

      //HAmestica: Si no existe cuenta desplegada llena con una por defecto para calcular totales
      if(empty($idcsarray)){
        if($mc->id_cuenta == $ms->id_cuenta){
          $idcsarray[] = $id_cuenta."_".$id_subcuenta;
        }
      }
    }
  //}
}

//echo "<tr><td>otro tr</td></tr>";

echo "<tr><td colspan=".$rango.">&nbsp;</td>";
echo "<td colspan=".$colspan_totales.">&nbsp;</td></tr>";

echo "<tr>
    <td style='border:1px solid #000;'>
      <strong>TOTAL PAGOS</strong>
    </td>";
    for ($ti=0;$ti<$rango;$ti++){
        echo '<td>
                 <table border="0px" width="100%">
                 <tr>';
        for($l=0;$l<$cantidad_lunes_array[$ti];$l++){

                  if($cantidad_lunes_array[$ti]== '4444'){
                    $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
                  }
              echo '<td '.$porcentaje_celda.'>';
              echo '
                            <div style="text-align:center;" id="row_total_pagos'.$diasslunes[$ti][$l]."_".$diassdomingo[$ti][$l].'">&nbsp;</div>';

              echo '</td>';


        }

        echo '</tr>
      </table>

           </td>';

    }


echo "</tr>";//fin
echo "
  <tr>
    <td style='border:1px solid #000;'>
      <strong>TOTAL EGRESOS</strong>
    </td>";
      for ($ti=0;$ti<$rango;$ti++){
  echo '<td>

          <table border="0px" width="100%">
          <tr>';

        for($l=0;$l<$cantidad_lunes_array[$ti];$l++){

                  if($cantidad_lunes_array[$ti]== '4444'){
                    $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
                  }
              echo '<td '.$porcentaje_celda.'>';
              echo '
                            <div style="text-align:center;" id="monts'.$diasslunes[$ti][$l]."_".$diassdomingo[$ti][$l].'">&nbsp;</div>';

              echo '</td>';


        }

        echo '</tr>
      </table>

           </td>';
  }
echo "</tr>";


echo "<tr>
    <td style='border:1px solid #000;'>
      <strong>SALDO PENDIENTE</strong>
    </td>";
    for ($ti=0;$ti<$rango;$ti++){
        echo '<td>
                 <table border="0px" width="100%">
                 <tr>';
        for($l=0;$l<$cantidad_lunes_array[$ti];$l++){

                  if($cantidad_lunes_array[$ti]== '4444'){
                    $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
                  }else{
                    $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
                  }
              echo '<td '.$porcentaje_celda.'>';
              echo '
                            <div style="text-align:center;" id="row_total_pagos_pendiente'.$diasslunes[$ti][$l]."_".$diassdomingo[$ti][$l].'">&nbsp;</div>';

              echo '</td>';


        }

        echo '</tr>
      </table>

           </td>';

    }



echo "<tr>
    <td style='border:1px solid #000;'>
      <strong>EGRESOS ACUMULADOS</strong>
    </td>";
    /*egresos acumulados*/
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
              echo '
                            <div style="text-align:center;" id="mont_acum'.$diasslunes_ant[$tia][$m]."_".$diassdomingo_ant[$tia][$m].'">&nbsp;</div>';

              echo '</td>';


        }

        echo '</tr>
      </table>

           </td>';
  }
echo "</tr>";
echo "</table>";

}else {
  echo '
  <div class="alert alert-danger">
  <strong>
  Atenci&oacute;n!
</strong>
No existen Cuentas y/o Subcuentas de Egreso creadas o activas para esta la empresa <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong>.</span> Revise 
<strong>
      <a href="'.base_url()."cuenta"."/".$id_empresa.'">
      aqu&iacute;</a>
    </strong>
  </div>
  ';
}

?>



<script type="text/javascript">

var id_empresa = $('#id_empresa_guarda').val();

function move(e){
        if(e.scrollTop()>160){
            e.addClass("fixed");
            $(".fixed #tbfix").attr("style","max-width: "+$("#tbcontent").width()+"px; background-color:#fff;");
        } else {
            $(".fixed #tbfix").removeAttr("style");
            e.removeClass("fixed");    
        }

       
    }

/*function move(e){
  if(e.scrollTop()>100){
    e.addClass("fixed");
  } else {
    e.removeClass("fixed");    
  }
  //console.log(e.scrollLeft());
  if(e.scrollLeft()>5 && e.scrollTop()>100){
    //$(".fixedL #tbfix").attr("style","left: -"+(e.scrollLeft())+"px");
    $(".fixedL #tbfix").attr("style","right: 4px");
    e.addClass("fixedL");
  } else {
    $(".fixedL #tbfix").removeAttr("style");
    e.removeClass("fixedL");    
  }
}*/

$(document).ready(function() {

  /*$(".page-content").scroll(function(){
    if ($(this).pageYOffset > 120) {

    }
  });*/


  $('[data-rel=popover]').popover({html:true});
  
var idcarray = <?php echo json_encode($idcarray); ?>;
// console.log(idcarray);

var idcsarray = <?php echo json_encode($idcsarray); ?>;
// console.log(idcsarray);
var diasslunes = <?php echo json_encode($diasslunes); ?>;
//console.log(diasslunes);
var diassdomingo = <?php echo json_encode($diassdomingo); ?>;
//console.log(diassdomingo);
var diasslunes_ant = <?php echo json_encode($diasslunes_ant); ?>;
//console.log(diasslunes_ant);
var diassdomingo_ant = <?php echo json_encode($diassdomingo_ant); ?>;

var mesesarray = <?php echo json_encode($meses_array); ?>;
//console.log(mesesarray);
var añosarray = <?php echo json_encode($años_array); ?>;
//console.log(añosarray);
var lunesarray = <?php echo json_encode($cantidad_lunes_array); ?>;
//console.log(lunesarray);

var cant_mes = mesesarray.length;
var cant_ano = añosarray.length;
var arg = [];
var i=0;
/*for(var l=0;l<cant_ano;l++){
    for(var m=0;m<cant_mes;m++){
        arg.push({a:añosarray[l], m: mesesarray[m], cl: lunesarray[m]});
    }
}*/

//devuelve_quincena(arg);

var total_egreso = 0;

var cant_lun = diasslunes.length;
var cant_dom = diassdomingo.length;
var cant_idcs = idcsarray.length;
/*
var i=0;

for(var l=0;l<cant_lun;l++){
    for(var m=0;m<diasslunes[l].length;m++){
        for(var cs=0; cs<cant_idcs;cs++){
            i++;
            var str = idcsarray[cs];
            var idc = str.split("_");
            
            arg.push({idc: idc[0], ids: idc[1],ft: diassdomingo[l][m], fi: diasslunes[l][m], fi_a: diasslunes_ant[l][m], ft_a: diassdomingo_ant[l][m]})
        }
    }
}*/
//sebastian cid 2703 0042
var i=0;
for(var l=0;l<cant_lun;l++){
    for(var m=0;m<diasslunes[l].length;m++){
            arg.push({ft: diassdomingo[l][m], fi: diasslunes[l][m], fi_a: diasslunes_ant[l][m], ft_a: diassdomingo_ant[l][m]})
    }
}

// console.log(arg)

let arg_2 = [];
for(var cs2=0; cs2<cant_idcs;cs2++){
    i++;
    var str2 = idcsarray[cs2];
    var idc2 = str2.split("_");
    arg_2.push({idc: idc2[0], ids: idc2[1]})
}

/*devuelve_total_pagados(arg);
devuelve_egreso_total(arg);
devuelve_monto(arg);
devuelve_saldo_pendiente(arg);
devuelve_egreso_acum(arg);*/

//return_egreso_full(arg);
devuelve_gasto_proy(arg_2);
devuelve_gasto_real(arg_2);
devuelve_monto(arg);

//HAmestica: Argumentos para consulta totales Cuenta/Semana
var args_total_cuenta_semana=[];
args_total_cuenta_semana.push({fi: diasslunes[0][0], ft: diassdomingo[cant_dom-1][diassdomingo[cant_dom-1].length-1]});
// console.log(args_total_cuenta_semana)

//HAmestica: Llamado funcion para consulta totales Cuenta/Semana
devuelve_montos_cuenta_semana(args_total_cuenta_semana,idcarray,diasslunes,diassdomingo);

//HAmestica: Botón recalcular Totales
// $("#clear-view").click(()=>{
//   //return_egreso_full(arg, f_i+'-'+f_f, $("#clear-view").attr("data-file"));
//   //devuelve_gasto_real(arg_2);
//   devuelve_egreso_total(arg);
//   devuelve_total_pagados(arg);
//   devuelve_saldo_pendiente(arg);
//   devuelve_egreso_acum(arg);
// });

//HAmestica: Actualizar los totales
actualizarTotales(arg);

});

//HAmestica: Función que actualiza los totales
function actualizarTotales(arg){
  devuelve_egreso_total(arg);
  devuelve_total_pagados(arg);
  devuelve_saldo_pendiente(arg);
  devuelve_egreso_acum(arg);
}

 function siguiente(siguiente,id_cuenta){
  var id_e = $('#id_empresa_guarda').val();
  $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e + '/' + siguiente + '/' + id_cuenta);
}

function hoy(hoy,id_cuenta){
  var id_e = $('#id_empresa_guarda').val();
  $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e + '/' + hoy + '/' + id_cuenta);
}

function anterior(anterior,id_cuenta){
  var id_e = $('#id_empresa_guarda').val();
  $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e + '/' + anterior + '/' + id_cuenta);
}

//HAmestica: funcion que muestra/oculta detalles sub cuentas al hacer clic al botón +/-
function mostrar_detalle_subcuentas(fecha,ids_cuentas,id_cuenta,orden,direccion,fecini,fecfin,es_orden='0'){
  var id_e = $('#id_empresa_guarda').val();
  
  if(es_orden=='0'){
    var ids_aux=ids_cuentas.split(",");
    var existe_id=false;

    for(i=0;i<ids_aux.length;i++){
      if(ids_aux[i]==id_cuenta){
        ids_aux.splice(i,1);
        existe_id=true;
      }
    }
    
    if(!existe_id){
      ids_aux.push(id_cuenta);
    }

    ids_cuentas="";

    for(i=0;i<ids_aux.length;i++){
      if(ids_cuentas==""){
        ids_cuentas+=ids_aux[i];
      }else{
        ids_cuentas+=','+ids_aux[i];
      }
    }
  }

  if(ids_cuentas==''){
    ids_cuentas='-';
  }
  
  if(orden=='subcuenta'){
    $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e + '/' + fecha + '/' + ids_cuentas + '/' + orden + '/' + direccion);
  }else{
    $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e + '/' + fecha + '/' + ids_cuentas + '/' + orden + '/' + direccion + '/' + fecini + '/' + fecfin);
  }
}

function edit_egreso(){

  $('#loading_gr').hide(); 
  $('#loading_dm').hide(); 
  $('#loading_dtp').hide(); 
  $('#loading_et').hide(); 
  $('#loading_dsp').hide(); 
  $('#loading_ea').hide(); 


  var id_m = $("#id_movimiento_up").val();
  var id_me =  $("#id_movimiento_e_up").val();
  var id_e = $('#id_empresa_guarda').val();

  if(id_m){
    id_movimiento = id_m+"@"+id_me;//editar
  }

  $(location).attr('href','<?php echo base_url() ?>movimiento_egreso/' + id_e + '/' + id_movimiento);
}

function movimiento(idc,ids,fi,ft){

  $('#loading_gr').hide(); 
  $('#loading_dm').hide(); 
  $('#loading_dtp').hide(); 
  $('#loading_et').hide(); 
  $('#loading_dsp').hide(); 
  $('#loading_ea').hide(); 


  var id_m = $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();
  var id_me = $("#idme"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();
  var id_cero = $("#id_cero"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();
  var id_e = $('#id_empresa_guarda').val();

  if(id_m){
    id_movimiento = id_m+"@"+id_me;//editar
  }else {
    id_movimiento = 0+"@"+id_cero;
  }

  $(location).attr('href','<?php echo base_url() ?>movimiento_egreso/' + id_e + '/' + id_movimiento);

}

function getWeekDates(f){

var day_milliseconds = 24*60*60*1000;
var dates = [];
var current_date = f;//new Date();
var monday = new Date(current_date.getTime()-(current_date.getDay()-1)*day_milliseconds);
var sunday = new Date(monday.getTime()+6*day_milliseconds);
dates.push(monday);
dates.push(sunday);
return dates;

}


function levanta_detalle(idc,ids,fi,ft){

      var id_m = $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();
      var id_me = $("#idme"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();

      $("#id_movimiento_up").val(id_m);
      $("#id_movimiento_e_up").val(id_me);


                //Ajax Load data from ajax
      if(id_m>0){
        $.ajax({
        url : "<?php echo site_url('get_up_detalle_egreso/')?>" + id_m,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

          table_docs = '<table class="table table-striped table-bordered table-hover width="90%"><thead><tr><th>Tipo de Dcto.</th><th>Nro. Dcto.</th><th>Monto</th></tr></thead><tbody>';

          for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
                    
                    var nombre_tipo_documento = data[i].nombre_tipo_documento;
                    var numero_tipo_documento = data[i].numero_tipo_documento;
                    var monto = data[i].monto;
                    var nombre_tipo_estado_movimiento = data[i].nombre_tipo_estado_movimiento;

                    if(nombre_tipo_estado_movimiento == 'PAGADO'){
                      color_back = 'style="background-color:#FFFF00;"';
                    }else{
                      color_back = 'style="background-color:#EEEEEE;"';
                    }

                    table_docs += "<tr><td>"+nombre_tipo_documento+"</td><td>"+numero_tipo_documento+"</td><td>$ "+formatNumber(monto)+"</td></tr>";

                  }

                  table_docs += '</tbody></table>';
                  $("#table_docs").html(table_docs);
            
            $('#modal_form_detalle').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detalle Movimiento: '+id_m); // Set title to Bootstrap modal title

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos 1.');
          }
        });
      }
}

function devuelve_gasto_proy(arg){
  $.ajax({
    url : "<?php echo site_url('consulta_gasto_proy_json/')?>",
    type: "POST",
    dataType: "JSON",
    data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
    beforeSend: function() {
      //$('#loading_gr').show();
    },  
    success: function(req)
    {
      for(j=0;j<req.length;j++){
        var res = req[j].request;
        var idc=req[j].data.idc, ids=req[j].data.ids;
        for (var i=0;i<res.length; i++){ //cuenta la cantidad de registros
          var monto_real = parseInt(res[i].monto_gas_proy);
          if(monto_real > 0){
            $("#proy_"+idc+"_"+ids).html(formatNumber(monto_real));
          }else{
            $("#proy_"+idc+"_"+ids).html("&nbsp;");
          }
        }
      }
      //$('#loading_gr').hide();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error al obtener los datos 1.');
    }
  });
}

  function devuelve_gasto_real(arg){
  $.ajax({
    url : "<?php echo site_url('consulta_gasto_real_json/')?>",
    type: "POST",
    dataType: "JSON",
    data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
    beforeSend: function() {
      //$('#loading_gr').show();
    },  
    success: function(req)
    {
      for(j=0;j<req.length;j++){
        var res = req[j].request;
        var idc=req[j].data.idc, ids=req[j].data.ids;
        var monto = 0;
        for (var i=0;i<res.length; i++){ //cuenta la cantidad de registros
          var monto_bd = parseInt(res[i].monto);
          var fecha_ingreso = res[i].fecha_ingreso;
          var fecha_pago = res[i].fecha_pago;
          
          var fecha_hoy = new Date();
          var fecha_ingreso_1 = new Date(fecha_ingreso);
          var fecha_pago_1 = new Date(fecha_pago);

          var ano_hoy = fecha_hoy.getFullYear();
          var ano_fecha_ingreso = fecha_ingreso_1.getFullYear();
          var ano_fecha_pago = fecha_pago_1.getFullYear();
          //console.log(monto+"--"+fecha_ingreso+"--"+ano_fecha_ingreso+"--"+fecha_pago+"--"+ano_fecha_pago+"--"+ano_hoy);

          if( ano_fecha_ingreso == ano_hoy || ano_fecha_pago == ano_hoy){
            // console.log(monto+"--"+fecha_ingreso+"--"+ano_fecha_ingreso+"--"+fecha_pago+"--"+ano_fecha_pago+"--"+ano_hoy);
            monto = monto + monto_bd;

          }

          if(monto > 0){
            $("#real_"+idc+"_"+ids).html(formatNumber(monto));//
          }else{
            $("#real_"+idc+"_"+ids).html("&nbsp;");
          }
        }
      }
      //$('#loading_gr').hide();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error al obtener los datos 1.');
    }
  });
}

function return_egreso_full(arg){
  $.ajax({
    url : "<?php echo site_url('consulta_egreso_simplifycate_json/')?>",
    type: "POST",
    dataType: "JSON",
    data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
    beforeSend: function() {
      $('#loading_gr').show();
    },  
    success: function(req)
    {
      for(j=0;j<req.length;j++){
        var fi=req[j].data.fi, ft=req[j].data.ft;
        var fi_a=req[j].data.fi_a, ft_a=req[j].data.ft_a;
        var idc= req[j].data.idc, ids= req[j].data.ids;
        var res_total;
        var total_semanal;
        //TOTAL PAGADOS
        res_total = req[j].request.total_pagados;
        total_semanal = parseInt(res_total.monto_total_sem);
        if(total_semanal > 0){
          $("#row_total_pagos"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
        }else {
          $("#row_total_pagos"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
        }
        //FIN TOTAL PAGADOS
        res_total = null;
        total_semanal = null;
        //EGRESO TOTAL
        res_total = req[j].request.egreso_total;
        total_semanal = parseInt(res_total.monto_total_sem);
        if(total_semanal > 0){
          $("#monts"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
        }else {
          $("#monts"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
        }
        //FIN EGRESO TOTAL
        res_total = null;
        total_semanal = null;
        //NOVIMIENTO
        var monto_total_cel = 0;
        var monto_total_ncr = 0;
        var monto_total_ban = 0;
        var cant_id_det_mov = 0;
        var res=req[j].request.movimiento;
        for (var i=0;i<res.length; i++){ //cuenta la cantidad de registros
          var id_movimiento = res[i].id_movimiento;
          var id_movimiento_detalle = res[i].id_movimiento_detalle;

          var monto = parseInt(res[i].monto);
          var monto_nota_credito = parseInt(res[i].monto_nota_credito);
          var monto_cuenta_banco = parseInt(res[i].monto_cuenta_banco);
          var id_tipo_estado_movimiento = res[i].id_tipo_estado_movimiento;
          var color_tipo_documento = res[i].color_tipo_documento;
          var prioritario = res[i].es_prioritario;
          var color_tipo_documento = res[i].color_tipo_documento;
          cant_id_det_mov = cant_id_det_mov + 1;

          monto_total_cel = monto_total_cel + monto;
          monto_total_ncr = monto_total_ncr + monto_nota_credito;
          monto_total_ban = monto_total_ban + monto_cuenta_banco;
          monto_total_mostrar = monto_total_cel - monto_total_ncr;

          //if (cant_id_det_mov == 1) {
            if (id_tipo_estado_movimiento == 1) {
                                pagado++;
                                //color_celda = 'yellow';
                            } 
                            /*else {
                                //color_celda = color_tipo_documento;
                            }*/
                        //}
                        
                        if(res.length == pagado){
                            color_celda = 'yellow';
                        }else{
                            color_celda = color_tipo_documento;
                        }

          if(monto_total_mostrar > 0){

            $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_total_mostrar)).css("background", color_celda);
            $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
            $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);
          }else if(monto_total_mostrar == 0){

            $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(monto_total_mostrar).attr("title", cant_id_det_mov);
            $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
            $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);

          }else{

            $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_total_mostrar)).css("color", "red").attr("title", cant_id_det_mov);
            $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
            $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);

          }
          if(monto_cuenta_banco > 0){
            $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_cuenta_banco));
            $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
            $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_cuenta_banco);
          }else{
            $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html();
          }

        }
        //FIN NOVIMIENTO
        res_total = null;
        total_semanal = null;
        //TOTAL PAGADOS PENDIENTES
        res_total = req[j].request.total_pagados_pendientes;
        total_semanal = parseInt(res_total.monto_total_sem);
        if(total_semanal > 0){
          $("#row_total_pagos_pendiente"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
        }else {
          $("#row_total_pagos_pendiente"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
        }
        //FIN TOTAL PAGADOS PENDIENTES
        res_total = null;
        total_semanal = null;
        //TOTAL EGRESO ACUMULADO
        res_acum = req[j].request.total_egreso_acumulado;
        total_semanal = (parseInt(res_acum.monto_total_sem) + parseInt(res_acum.monto_banco_total_sem)) - parseInt(res_acum.monto_nota_credito_total_sem);
        if(total_semanal > 0){
          $("#mont_acum"+fi_a+"_"+ft_a+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
        }else {
          $("#mont_acum"+fi_a+"_"+ft_a+"").html(0).css("font-weight", "bold");
        }
        //FIN TOTAL EGRESO ACUMULADO
      }
      $('#loading_gr').hide();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error al obtener los datos 1.');
    }
  });
}

function devuelve_total_pagados(arg){

        $.ajax({
          url : "<?php echo site_url('consulta_total_pagados_json/')?>",
          type: "POST",
          dataType: "JSON",
          data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
          beforeSend: function() {
            $('#loading_dtp').show();
          },  
          success: function(req)
            {
                for(j=0;j<req.length;j++){
                var res_total = req[j].request;
                var fi=req[j].data.fi, ft=req[j].data.ft;


                   var total_semanal = parseInt(res_total.monto_total_sem);
                    if(total_semanal > 0){
                      $("#row_total_pagos"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
                    }else {
                      $("#row_total_pagos"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
                    }
            }  
             $('#loading_dtp').hide();      
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos 2.');
          }
        });
      }

    function devuelve_egreso_total(arg){

        $.ajax({
          url : "<?php echo site_url('consulta_egreso_total_json/')?>",
          type: "POST",
          dataType: "JSON",
          data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()}, 
          beforeSend: function() {
            $('#loading_et').show();
          },  
            success: function(req){
                for(var j = 0; j<req.length;j++){
                   var res_total = req[j].request;
                   var fi = req[j].data.fi, ft = req[j].data.ft;
                   var total_semanal = parseInt(res_total.monto_total_sem);
                    if(total_semanal > 0){
                        $("#monts"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
                    }else {
                        $("#monts"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
                    }
                }   
                $('#loading_et').hide();                    
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error al obtener los datos 3.');
            }
        });
    }

  //HAmestica: Funcion para consulta totales Cuenta/Semana
  function devuelve_montos_cuenta_semana(args_total_cuenta_semana,idcarray,diaslunes,diasdomingos){
    var args=JSON.stringify(args_total_cuenta_semana);
    // console.log(args);

    $.ajax({
        url : "<?php echo site_url('consulta_totales_movimiento_cuenta_semana_json/')?>",
        type: "POST",
        dataType: "JSON",
        data: {args: args, idtm: 2, ide: $('#id_empresa_guarda').val()},  
        beforeSend: function() {
          $('#loading_dm').show();
        },  
        success: function(req)
        {
          for(let z=0;z<idcarray.length;z++){
            let idcue=idcarray[z];
            
            for(let j = 0; j<req.length;j++){
              let res=req[j];
              
              for (let i=0;i<res.length; i++){
                if(res[i].id_cuenta==idcue){
                  for(let x=0;x<diaslunes.length;x++){
                    for(let y=0;y<diaslunes[x].length;y++){
                      let dialunes=diaslunes[x][y];
                      let diadomingo=diasdomingos[x][y];

                      if(res[i].fecha_pago=='0000-00-00'){
                        if(res[i].fecha_ingreso>=dialunes && res[i].fecha_ingreso<=diadomingo){
                          $("#" + idcue + "_" + dialunes + "_" + diadomingo).html(formatNumber(res[i].Monto));
                        }
                      }else{
                        if(res[i].fecha_pago>=dialunes && res[i].fecha_pago<=diadomingo){
                          $("#" + idcue + "_" + dialunes + "_" + diadomingo).html(formatNumber(res[i].Monto));
                        }
                      }
                    }
                  }
                }
              }
            }

            
          }

          $('#loading_dm').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert(errorThrown);
        }
      });
  }

  function get_movimiento_detalle(idc, ids, fi, ft){
    
    tabla_detalle = '';
    fecha_pago_detalle = '';
    
    var id_movi = $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();

    if(id_movi > 0) {

      $.ajax({
          url : "<?php echo site_url('consulta_detalle_movimiento/')?>",
          type: "POST",
          dataType: "JSON",
          data: {id_movi: id_movi},   
          success: function(res)
          {
            tabla_detalle += '<table class="table table-striped table-bordered table-hover width="100%"><thead><th style="text-align:center;font-size:14px;text-decoration:underline;" colspan=5>Detalle del movimiento: '+id_movi+'</th><tr><th style="text-align:center;">ID Detalle</th><th style="text-align:center;">Tipo de Dcto.</th><th style="text-align:center;">Nro. Dcto.</th><th style="text-align:center;">Monto</th><th style="text-align:center;">Fecha Pago</th></tr></thead><tbody>';
                      
            for (var h=0;h<res.length; h++){ //cuenta la cantidad de registros
                        
                        var id_movimiento_detalle = res[h].id_movimiento_detalle;
                        var nombre_tipo_documento_detalle = res[h].nombre_tipo_documento;
                        var numero_tipo_documento_detalle = res[h].numero_tipo_documento;
                        var monto_detalle = res[h].monto;
                        var fecha_pago_detalle = res[h].fecha_pago;

                        if(fecha_pago_detalle == '00-00-0000' || fecha_pago_detalle == '0000-00-00' || fecha_pago_detalle == '' ){
                            fecha_pago_detalle = '';
                        }else{
                            fecha_pago_detalle =fecha_pago_detalle;
                        }

                        var nombre_tipo_estado_movimiento = res[h].nombre_tipo_estado_movimiento;

                        tabla_detalle += "<tr><td style='text-align:center;'>"+id_movimiento_detalle+"</td><td>"+nombre_tipo_documento_detalle+"</td><td style='text-align:center;'>"+numero_tipo_documento_detalle+"</td><td style='text-align:right;'>$ "+monto_detalle+"</td><td style='text-align:center;'>"+fecha_pago_detalle+"</td></tr>";
                    }

            tabla_detalle += '</tbody></table>';

            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).attr("data-content", tabla_detalle);

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos.');
          }
          
        });

    }
      
      
  }
  
  function devuelve_monto(arg){

    var suma_montos_egreso = 0;
      $.ajax({
        url : "<?php echo site_url('consulta_movimiento_egreso_json/')?>",
        type: "POST",
        dataType: "JSON",
        data: {arg: JSON.stringify(arg), ide: $('#id_empresa_guarda').val()},  
        beforeSend: function() {
          $('#loading_dm').show();
        },  
        success: function(req)
        {
          
          for(var i = 0; i < req.length; i++){

            for(var j = 0; j < req[i].length; j++){
              
              var monto_total_cel = 0;
              var monto_total_ncr = 0;
              var monto_total_ban = 0;
              var monto_total_pre = 0;
              var cant_id_det_mov = 0;
              var monto_total_mostrar = 0;

              var idc = req[i][j].idc;
              var ids = req[i][j].ids;
              var fi = req[i][j].fi;
              var ft = req[i][j].ft;
              var fecha_ingreso = req[i][j].fecha_ingreso;
              var fecha_pago = req[i][j].fecha_pago;
              var id_movimiento = req[i][j].id_movimiento;
              var id_movimiento_detalle = req[i][j].id_movimiento_detalle;
              //var dataMD = traeDataIdMD(id_movimiento);
              var monto = req[i][j].monto;    

              var monto_nota_credito = req[i][j].monto_nota_credito;
              var monto_cuenta_banco = req[i][j].monto_cuenta_banco;
              var monto_cuenta_prestamo = req[i][j].monto_cuenta_prestamo;
              var id_tipo_estado_movimiento = req[i][j].id_tipo_estado_movimiento;
              var color_tipo_documento = req[i][j].color_tipo_documento;
              var prioritario = req[i][j].prioritario;
              var cantidad_md = req[i][j].cantidad_md;
              cant_id_det_mov = cant_id_det_mov + 1;            
              monto_total_cel = Number(monto_total_cel) + Number(monto);
              monto_total_ncr = Number(monto_total_ncr) + Number(monto_nota_credito);
              monto_total_ban = Number(monto_total_ban) + Number(monto_cuenta_banco);
              monto_total_pre = Number(monto_total_pre) + Number(monto_cuenta_prestamo);
              monto_total_mostrar = Number(monto_total_cel) - Number(monto_total_ncr);



            //SI NO HAY FECHA DE PAGO
            if(fecha_pago == '0000-00-00'){

            fi = fi;
            ft = ft;

            }else{

            //SI LA FECHA DE PAGO ES MAYOR AL LUNES Y MENOR AL DOMINGO DE LA SEMANA SELECCIONADA
            if( (fecha_pago > fi) && (fecha_pago < ft) ){
                
                fi = fi;
                ft = ft;

            }else{
                
                //SI LA FECHA DE PAGO ES MAYOR AL DOMINGO DE LA SEMANA SELECCIONADA
                if(fecha_pago > ft){
                    
                    var dias = getWeekDates(new Date(fecha_pago));

                    if(dias[0].getDate().toString().length == 1){dias0 = "0"+dias[0].getDate().toString();}else{dias0 = dias[0].getDate();}
                    if(dias[1].getDate().toString().length == 1){dias1 = "0"+dias[1].getDate().toString();}else{dias1 = dias[1].getDate();}

                    fi = dias[0].getFullYear() + "-" + (dias[0].getMonth() + 1) + "-" + dias0;
                    ft = dias[1].getFullYear() + "-" + (dias[1].getMonth() + 1) + "-" + dias1;

                }else if(fecha_pago < fi){

                    var dias = getWeekDates(new Date(fecha_pago));

                    if(dias[0].getDate().toString().length == 1){dias0 = "0"+dias[0].getDate().toString();}else{dias0 = dias[0].getDate();}
                    if(dias[1].getDate().toString().length == 1){dias1 = "0"+dias[1].getDate().toString();}else{dias1 = dias[1].getDate();}

                    fi = dias[0].getFullYear() + "-" + (dias[0].getMonth() + 1) + "-" + dias0;
                    ft = dias[1].getFullYear() + "-" + (dias[1].getMonth() + 1) + "-" + dias1;
                    
                }
                /*fi = dias[0];
                ft = dias[1]*/
            }

            /*fi = fecha_pago;
            ft = ft;*/

            }

                if(cant_id_det_mov == 1){
                  if(id_tipo_estado_movimiento == 1){
                    color_celda = 'yellow';
                  }else{
                    color_celda = color_tipo_documento;
                  }
                }

                if(monto_total_mostrar > 0){

                  $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_total_mostrar)).css("background", color_celda);
                  $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
                  $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);

                }else if(monto_total_mostrar == 0){

                  $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(monto_total_mostrar).attr("title", cant_id_det_mov);
                  $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
                  $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);

                }else{

                  $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_total_mostrar)).css("color", "red").attr("title", cant_id_det_mov);
                  $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
                  $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_total_mostrar);

                }
                  if(monto_cuenta_banco > 0){
                    $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_cuenta_banco));
                    $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
                    $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_cuenta_banco);
                  
                  }else{
                    
                    $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html();
                  }

                  if(monto_cuenta_prestamo > 0){
                    $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html(formatNumber(monto_cuenta_prestamo));
                    $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(id_movimiento);
                    $("#mont"+idc+"_"+ids+"_"+fi+"_"+ft+"").val(monto_cuenta_prestamo);
                  
                  }else{
                    
                    $("#"+idc+"_"+ids+"_"+fi+"_"+ft+"").html();
                  }

            }
          }

          $('#loading_dm').hide();  
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error al obtener los datos 4.');
        }
      });
    }

      function devuelve_saldo_pendiente(arg){
        
        $.ajax({
          url : "<?php echo site_url('consulta_total_pagados_pendiente_json/')?>",
          type: "POST",
          dataType: "JSON",
          data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
                           beforeSend: function() {
            $('#loading_dsp').show();
          },  
          success: function(req)
            {
                for(j=0;j<req.length;j++){
                var res_total = req[j].request;
                var fi=req[j].data.fi, ft=req[j].data.ft;
                var total_semanal = parseInt(res_total.monto_total_sem);

            if(total_semanal > 0){
              $("#row_total_pagos_pendiente"+fi+"_"+ft+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
            }else {
              $("#row_total_pagos_pendiente"+fi+"_"+ft+"").html(0).css("font-weight", "bold");
            }
                }
               $('#loading_dsp').hide();  
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al obtener los datos 6.');
          }
        });

   
      }



      function devuelve_egreso_acum(arg){

          $.ajax({
            url : "<?php echo site_url('consulta_egreso_acum_json/')?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg), idtm: 2, ide: $('#id_empresa_guarda').val()},
            beforeSend: function() {
              $('#loading_ea').show();
            },                      
            success: function(req)
            {
                for(j=0;j<req.length;j++){
                var res_acum = req[j].request;
                var fi_a=req[j].data.fi_a, ft_a=req[j].data.ft_a;
              var total_semanal = (parseInt(res_acum.monto_total_sem) + parseInt(res_acum.monto_banco_total_sem)) - parseInt(res_acum.monto_nota_credito_total_sem);

              if(total_semanal > 0){
                $("#mont_acum"+fi_a+"_"+ft_a+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
              }else {
                $("#mont_acum"+fi_a+"_"+ft_a+"").html(0).css("font-weight", "bold");
              }
            }
              $('#loading_ea').hide();  
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error al obtener los datos 7.');
                }
          });
        }

function gas_proy(c,s){
  
  $('#form')[0].reset();
  var e = $('#id_empresa_guarda').val();
  
  $('#id_cuenta').val(c);
  $('#id_subcuenta').val(s);

  $.ajax({
    url : "<?php echo site_url('devuelve_gas_proy_edit/')?>",
    type: "POST",
    dataType: "JSON",
    data: {c: c, s: s, e: e},
    
    success: function(res4)
    {
      for (var i=0; i<res4.length; i++){
        var monto_gas_proy = res4[i].monto_gas_proy;
        var nombre_subcuenta = res4[i].nombre_subcuenta;
        var nombre_cuenta = res4[i].nombre_cuenta;
        if(monto_gas_proy>0){
          $("#monto_gas_proy").val(monto_gas_proy);   
        }   
      }
      $('#modal_form').modal('show');
      $('.modal-title').text(nombre_cuenta + ": " + nombre_subcuenta); 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error al obtener los datos 8.');
    }
  });
  
}

function save()
      {
        var id_e = $('#id_empresa_guarda').val();
        var hoy = $('#hoy').val();

        $('#btnSave').text('Guardando...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
          var url;

         url = "<?php echo site_url('save_gas_proy')?>";
        
         // ajax adding data to database
         $.ajax({
          url : url,
          type: "POST",
          data: $('#form').serialize(),
          dataType: "JSON",
          success: function(data)
            {
              $('#btnSave').text('Guardar'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
              $('#modal_form').modal('hide');
              
              //HAmestica: Llamada a url manteniendo cuentas abiertas
              // $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e +'/'+ hoy);
              $(location).attr('href','<?php echo base_url() ?>egreso/' + id_e +'/'+ hoy + '/0');
            },

            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error al guardar o actualizar los datos 9.');
              $('#btnSave').text('Guardando...'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
          }
        });
       }


</script>


<div class="modal fade" id="modal_form_detalle" role="dialog">
      <input type="hidden" value="" name="id_movimiento_up" id="id_movimiento_up"/>
      <input type="hidden" value="" name="id_movimiento_e_up" id="id_movimiento_e_up"/>  

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
      <button class="btn btn-success" type="button" id="btnEdit" onclick="edit_egreso()">
        <i class="ace-icon icon icon-pencil bigger-110"></i>
        Editar
      </button>

      <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
    </div>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

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
      <input type="hidden" value="" name="id_cuenta" id="id_cuenta"/>
      <input type="hidden" value="" name="id_subcuenta" id="id_subcuenta"/>  
      <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda"/>
      <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda"/>
      <input type="hidden" value="<?php echo $hoy;?>" name="hoy" id="hoy"/>
      
      <div class="form-body">

        <div class="form-group">
          <label class="control-label col-md-4">Monto</label>
          <div class="col-md-8">
            <input name="monto_gas_proy" id="monto_gas_proy" placeholder="0" class="form-control" type="text" autocomplete="off">
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