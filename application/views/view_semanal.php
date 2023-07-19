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

//echo $fecha_actual_2."<br>".$fecha_actual."<br>".$fechaaa;
// $anterior = strtotime('-' . $rango_anterior . ' month', strtotime($lunes[0]));

$un_mes_atras = strtotime("-1 month", strtotime($fechaaa));

//echo ">".$un_mes_atras."<br>".$fechaaa;

$fecha_un_mes_atras = date("Y-m-d", $un_mes_atras);
//echo $un_mes_atras;
//Muestra el calendario un mes atras
list($year, $month, $day) = explode('-', $fecha_un_mes_atras);

//Muestra el calendario deasde la fecha actual
//list($year, $month, $day) = explode('-', $fecha_actual);

/* $id_res_encript = strtr($id_res_encript,array('.' => '+', '-' => '=', '~' => '/'));
  $id_res_encript = $this->encryption->decrypt($id_res_encript); */

/*
  $year='2019';
  $month='02';
  $day='04';
 */
/*
  if(!empty($muestra_cuenta_subcuenta)){
  foreach ($muestra_cuenta_subcuenta as $mc)
  {
  echo $mc->id_cuenta.$mc->id_subcuenta."<br>";
  }
  } */

/* if(!empty($mostrar_subcuenta))
  {
  foreach ($mostrar_subcuenta as $ms)
  {

  echo $ms->id_subcuenta."<br>";
  }
  } */
/*
  echo "<pre>";
  print_r($mostrar_cuenta);
  echo "</pre>"; */
/*
  echo '
  <div class="alert alert-warning">
  <button type="button" class="close" data-dismiss="alert">
  <i class="icon-remove"></i>
  </button>
  <strong>
  Importante!
  </strong>
  Se encontraron cuentas sin subcuentas asignadas.
  Revise
  <strong>
  <a href="'.base_url()."cuenta"."/".$id_empresa.'">
  aqu&iacute;</a>
  </strong>
  </div>
  '; */

$primerDia = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
//echo $primerDia;
$fechaInicio = strtotime($primerDia);

if (!empty($mostrar_cuenta)) {


    $dias_lunes = '';
    $dias_domingo = '';
    $lunes = array();
    $domingo = '';
    $domingos = array();
    $dialunes = 0;
    $dialunesq = 0;
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

    $mes_fi = date("m", $fechaInicio);
    $año_fi = date("Y", $fechaInicio);
    $id_cuenta = array();
    $id_subcuenta = array();
    $idcarray = array();
    $idsarray = array();
    $idcsarray = array();
    $servicearray1 = array();
    $servicearray2 = array();

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

    //HAmestica: Mantener fecha al cargar detalles sub cuentas
    $mantener_fecha = $this->encryption->encrypt($fecha_actual);
    $mantener_fecha = strtr($mantener_fecha,array('+' => '.', '=' => '-', '/' => '~'));
    echo "<script>console.log('".$mantener_fecha."');</script>";

    echo "
    
    <table border='0px' width='100% 'id='tbfix'>
        <tr>
        <td style='border:0px solid #000; min-width:200px; max-width:200px;'>
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
              "; 

              if(!empty($mostrar_servicios_primera_quincena)){

                foreach ($mostrar_servicios_primera_quincena as $servicio1q) {
                    echo "<tr>
                    <td style='border:1px solid #000;text-align:right;font-size:14px;background-color:#f2f2f2;'>
                    ".$servicio1q->nombre_servicio."
                    </td>
                </tr>";
                }
            
               }
              
              echo "<tr>
                <td style='border:1px solid #000;text-align:right;font-weight:bold;background-color:#cde8ef;'>
                SEGUNDA QUINCENA
                </td>
              </tr>"; 

              if(!empty($mostrar_servicios_segunda_quincena)){

                foreach ($mostrar_servicios_segunda_quincena as $servicio2q) {
                    echo "<tr>
                    <td style='border:1px solid #000;text-align:right;font-size:14px;background-color:#f2f2f2;'>
                    ".$servicio2q->nombre_servicio."
                    </td>
                </tr>";
                }

                }
              
              echo "
             <tr>
                <td style='border:1px solid #000;text-align:right;font-weight:bold;background-color:#93cddd;'>
                  TOTAL QUINCENAS
                </td>
              </tr>
            </table>
          </td>";

    for ($i = $mes_fi; $i < $mes_fi + $rango; $i++) {

        
        $meses = date('m', mktime(0, 0, 0, $i, 1, $mes_fi));
        $mesesq = date('m', mktime(0, 0, 0, $i + 1, 1, $mes_fi));
        $año = date('Y', mktime(0, 0, 0, $i, 1, $año_fi));
        //echo ">".$mes_fi;
        $añoq = date('Y', mktime(0, 0, 0, $i, 1, $año_fi + 1));
        $timestamp = strtotime("01-" . $meses . "-" . $año);
        $diasdelmes = date("t", $timestamp);

        echo "<td valign='top'>
            <table border='0px' width='100%'>
                <tr>
                    <td style='border:1px solid #000;text-align:center;font-weight:bold;background-color:#f2f2f2;' colspan=" . $diasdelmes . ">" . devuelve_mes_espanol($meses) . " / " . $año . "</td>
                </tr>

                <tr>";

        for ($dias = 1; $dias <= $diasdelmes; $dias++) {

            $timestamp_dias = strtotime($dias . "-" . $meses . "-" . $año);
            $numerodia = date('N', $timestamp_dias);
            $numerosemana = date("W", $timestamp_dias);
            $timestamp_diashoy = strtotime(date("d-m-Y"));
            $numerosemanahoy = date("W", $timestamp_diashoy);

            $dias_lunes = date("Y-m-d", $timestamp_dias);
            $dias_lunes_ant = date("Y-m-d", strtotime($dias_lunes . "- 7 days"));

            $dias_domingo = date("Y-m-d", strtotime($dias_lunes . "+ 6 days"));
            (strlen($dias) == 1) ? $lun = "0" . $dias : $lun = $dias;
            $dom = date("d", strtotime($dias_lunes . "+ 6 days"));
            $dias_domingo_ant = date("Y-m-d", strtotime($dias_domingo . "- 7 days"));
            $isNow='';
            if ($numerosemana . $año == $numerosemanahoy . date("Y")) {
                $backgroundcolor = "#ff6961";
                $isNow="class='weeks_now' data-now='true'";
            } else {
                $backgroundcolor = "#f2f2f2";
                $isNow="class='weeks_now' data-now='false'";
            }

            if ($numerodia == 1) {
                $dialunes++;
                $lunes[] = $dias_lunes;
                $domingos[] = $dias_domingo;
                //echo ">".$domingos;
                $lunes_ant[]= $dias_lunes_ant;
                $domingo_ant[] = $dias_domingo_ant;
                echo "<td {$isNow} style='border:1px solid #000;text-align:center;font-weight:bold;background-color:" . $backgroundcolor . ";'>" . $lun . " al " . $dom . "</td>";
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

        if ($dialunes == 4) {
            $siguiente = date("Y-m-d", strtotime($domingos[3] . "- 1 month"));
        } else {
            $siguiente = date("Y-m-d", strtotime($domingos[4] . "- 1 month"));
        }

        $rango_anterior = 2;//(2 * $rango) - 1;
        
        $anterior = strtotime('-' . $rango_anterior . ' month', strtotime($lunes[0]));
        //echo "lunes[0]: ".$lunes;//////////por aqui va
        $anterior = date('Y-m-d', $anterior);
        
        
        $anterior = $this->encryption->encrypt($anterior);
        
        
        $anterior = strtr($anterior, array('+' => '.', '=' => '-', '/' => '~'));

        $siguiente = $this->encryption->encrypt($siguiente);
        $siguiente = strtr($siguiente, array('+' => '.', '=' => '-', '/' => '~'));

        $hoy = date('Y-m-d');
        $hoy = $this->encryption->encrypt($hoy);
        $hoy = strtr($hoy, array('+' => '.', '=' => '-', '/' => '~'));

        echo '</tr>';

        $total_quincnena = 0;
        $idq = 1;
        
        for ($q = 0; $q < 2; $q++) {

            $quincena = devuelve_quincena_new($ide, $meses, $año, $idq);
            $total_quincnena += $quincena[$q];
            $total_quincnena_mostrar = formato_precio('$', $total_quincnena, 'first');
            $colspan = $dialunes - 1;
            if (!empty($quincena[$q])) {
                $quincena[$q] = $quincena[$q];
            } else {
                $quincena[$q] = 0;
            }

            if($_SESSION['ing_mov_qui']==1){
                $onclick='onclick="selecciona_quincena(\''.$ide.'\', \''.$meses.'\', \''.$año.'\', \''.$q.'\');"';
                $style='style="cursor:pointer;border:1px solid #000;text-align:right;background-color:#cde8ef;font-weight:bold;"';
            }else{
                $onclick='&nbsp;';
                $style='style="border:1px solid #000;text-align:right;background-color:#cde8ef;font-weight:bold;"';
            }

            echo "<tr>  
                    <td colspan='" . $colspan . "'>&nbsp;
                    </td>";
            echo "  <td $style $onclick>" . formato_precio('$',$quincena[$q], 'first') . "
                    </td>
                  </tr>";

                  if($q == 0){
                    
                    if(!empty($mostrar_servicios_primera_quincena)){
                    $l = 1;
                    foreach ($mostrar_servicios_primera_quincena as $servicio1q) {
                        $ids = $servicio1q->id_servicio;
                        $quincena1 = devuelve_detalle_quincena1($ids, $meses, $año, $ide);
                        if($quincena1>0){$quincena1=$quincena1;}else{$quincena1=0;}
                        $servicearray1[] = $meses . "_" . $año . "_" . $ids;
                        echo "<tr>
                        <td colspan='" . $colspan . "'>&nbsp;</td>    
                        <td style='border:1px solid #000;' >
                            <div data-rel='popover' data-trigger='hover' data-placement='rigth' data-content='' style='text-align:right;background-color:#f2f2f2;' id='serv1_" . $ide . "_" . $meses . "_" . $año . "_" . $ids . "'>0</div>
                        </td>
                    </tr>";
                    $l++;
                    }
                
                    }  

                }else{

                    if(!empty($mostrar_servicios_segunda_quincena)){

                        foreach ($mostrar_servicios_segunda_quincena as $servicio2q) {
                            $ids = $servicio2q->id_servicio;
                            $quincena2 = devuelve_detalle_quincena2($ids, $meses, $año, $ide);
                            if($quincena2>0){$quincena2=$quincena2;}else{$quincena2=0;}
                            $servicearray2[] = $meses . "_" . $año . "_" . $ids;
                            echo "<tr>
                            <td colspan='" . $colspan . "'>&nbsp;</td>
                            <td style='border:1px solid #000;' >
                                <div data-rel='popover' data-trigger='hover' data-placement='rigth' data-content='' style='text-align:right;background-color:#f2f2f2;' id='serv2_" . $ide . "_" . $meses . "_" . $año . "_" . $ids . "'>0</div>
                            </td>
                        </tr>";
                        }
        
                        }
                }
        
            $idq++;

        }
        echo "<tr>
                <td colspan='" . $colspan . "'>&nbsp;</td>
                        <td style='border:1px solid #000;text-align:right;background-color:#93cddd;font-weight:bold;'>
                        " . $total_quincnena_mostrar . "
                        </td>
                      </tr>
                      
                  </table>
          </td>";


        $dialunes = 0;
        $dialunesq = 0;
        $diadomingo = 0;
        $lunes = array();
        $domingos = array();
        $lunes_ant = array();
        $domingo_ant = array();
    }

    echo '<tr>
            
            <td>&nbsp;</td>
            
            <td colspan="' . $colspan_totales . '">
                <table border=0px; width="100%">
                    <tr>
                        <td>
                            <div style="text-align:left;">
                                <button type="button" class="btn btn-xs btn-info" aria-label="Anterior" title="Anterior" onclick="anterior(\'' . $anterior . '\')">
                                <span class="icon icon-arrow-left" aria-hidden="true"></span>
                                </button>
                            </div>
                        </td>
                        <td>
                            <div style="text-align:center;">
                                <button type="button" class="btn btn-xs btn-info" aria-label="Semana actual" title="Semana actual" onclick="hoy(\'' . $hoy . '\')">
                                <span class="icon icon-calendar" aria-hidden="true"></span>
                                </button>
                            </div>
                        </td>
                        <td>
                            <div style="text-align:right;">
                                <button type="button" class="btn btn-xs btn-info" aria-label="Siguiente" title="Siguiente" onclick="siguiente(\'' . $siguiente . '\')">
                                <span class="icon icon-arrow-right" aria-hidden="true"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
        
    </table>';

    echo "
    <table id='tbcontent' border='0px' width='100%'>";

        foreach ($mostrar_cuenta as $mc) {
        
        echo "

        <tr>
            <td colspan=" . $colspan_totales . ">
                &nbsp;
            </td>
        </tr>

        <tr>
            <td colspan='1' style='background-color:#A9A9A9;border:1px solid #000;'>";
        echo "<strong>&nbsp;" . $mc->nombre_cuenta . "</strong>";

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
          <button type="button" class="btn btn-xs btn-info" onclick="cargarTotales(\''.$mantener_fecha.'\',\'subcuenta\',\''.$orden_subcuenta_direccion_aux.'\',\'\',\'\',\'1\')" style="position:inherit;">
            <span class="icon icon icon-sort'.$orden_subcuenta_icon.'" aria-hidden="true"></span>
          </button>
        ';

      echo "</td>";

        //HAmestica: crear botón para ordenar monto/semana
        for ($c = 0; $c < $rango; $c++) {
            echo '<td>';
            echo '
            <table border="1px" width="100%">
            <tr>';//echo $cantidad_lunes_array[$c];
        
            for ($l = 0; $l < $cantidad_lunes_array[$c]; $l++) {
                if ($cantidad_lunes_array[$c] == '4444') {
                    $porcentaje_celda = 'style="width:25%;"';
                } else {
                    $porcentaje_celda = 'style="width:20%;"';
                }
        
                echo '<td ' . $porcentaje_celda . '>';

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
                        <button type="button" class="btn btn-xs btn-info" style="width:29%;float:left;position:inherit !important;" onclick="cargarTotales(\''.$mantener_fecha.'\',\'semana\',\''.$orden_subcuenta_direccion_aux.'\',\''.$diasslunes[$c][$l].'\',\''.$diassdomingo[$c][$l].'\',\'1\')" style="position:inherit;">
                        <span class="icon icon icon-sort'.$orden_subcuenta_icon.'" aria-hidden="true"></span>
                        </button>
                    ';

                echo '</td>';
            }
        
            echo '</tr>
                </table>
                </td>';
        }
  
  echo "</tr>";

        if (!empty($mostrar_subcuenta)) {
            
            /*echo "<pre>";
            print_r($mostrar_cuenta);
            echo "</pre>";*/

            foreach ($mostrar_subcuenta as $ms) {
                $id_cuenta = $ms->id_cuenta;

                if ($mc->id_cuenta == $ms->id_cuenta) {

                    $id_subcuenta = $ms->id_subcuenta;
                    $idcsarray[] = $id_cuenta . "_" . $id_subcuenta;
                    //echo $mc->nombre_cuenta."<br>";
                    echo '
            <tr>
              <td style="border:1px solid #000;min-width: 200px;max-width: 200px;">&nbsp;' . $ms->nombre_subcuenta . '</td>';
              
                    for ($c = 0; $c < $rango; $c++) {
                        //echo $c;

                        echo '<td>';
                        echo '

              <table border="1px" width="100%">
                <tr>';//echo $cantidad_lunes_array[$c];
                
                        for ($l = 0; $l < $cantidad_lunes_array[$c]; $l++) {

                            $lunea_a_viernes = $diasslunes[$c][$l] . "n" . $diassdomingo[$c][$l] . "n";
                            $lunea_a_viernes_encrypted = $this->encryption->encrypt($lunea_a_viernes);
                            $lunea_a_viernes_encrypted = strtr($lunea_a_viernes_encrypted, array('+' => '.', '=' => '-', '/' => '~'));

                            $id_cero = $ms->id_cuenta . "n" . $ms->id_subcuenta . "n" . $diasslunes[$c][$l] . "n" . $diassdomingo[$c][$l] . "n";
                            $id_cero_encrypt = $this->encryption->encrypt($id_cero);
                            $id_cero_encrypt = strtr($id_cero_encrypt, array('+' => '.', '=' => '-', '/' => '~'));


                            if ($cantidad_lunes_array[$c] == '4444') {
                                $porcentaje_celda = 'style="width:25%;"';
                            } else {
                                $porcentaje_celda = 'style="width:20%;"';
                            }

                            echo '<td ' . $porcentaje_celda . '>

                            
                              <div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" style="text-align:center;cursor:pointer;" onclick="movimiento(\'' . $ms->id_cuenta . '\',\'' . $ms->id_subcuenta . '\',\'' . $diasslunes[$c][$l] . '\',\'' . $diassdomingo[$c][$l] . '\')" id="' . $ms->id_cuenta . "_" . $ms->id_subcuenta . "_" . $diasslunes[$c][$l] . "_" . $diassdomingo[$c][$l] . '">&nbsp;</div>
                              
                              <input type="hidden" value="" id="idm' . $ms->id_cuenta . "_" . $ms->id_subcuenta . "_" . $diasslunes[$c][$l] . "_" . $diassdomingo[$c][$l] . '"/>

                              <input type="hidden" value="" id="mont' . $ms->id_cuenta . "_" . $ms->id_subcuenta . "_" . $diasslunes[$c][$l] . "_" . $diassdomingo[$c][$l] . '"/>
                              <input type="hidden" value="' . $lunea_a_viernes_encrypted . '" id="idme' . $ms->id_cuenta . "_" . $ms->id_subcuenta . "_" . $diasslunes[$c][$l] . "_" . $diassdomingo[$c][$l] . '"/>
                              <input type="hidden" value="' . $id_cero_encrypt . '" id="id_cero' . $ms->id_cuenta . "_" . $ms->id_subcuenta . "_" . $diasslunes[$c][$l] . "_" . $diassdomingo[$c][$l] . '"/>
                            </td>';
                        }

                        echo '</tr>
        </table>
      </td>';
                    }
                    echo "</tr>";
                }
            }

        }
    }


//SALTO DE LINEA
echo "
<tr>
    <td colspan=" . $colspan_totales . ">&nbsp;
    </td>
</tr>";

echo "
<tr>
    <td colspan='1' style='background-color:#A9A9A9;border:1px solid #000;'>";
    echo "<strong>&nbsp;VENTAS</strong>";
    echo "
    </td>
  </tr>
  <tr>
    <td style='border:1px solid #000;background-color:#dbeef4;'>
      <strong>&nbsp;Quincenales proyectadas</strong>
    </td>";
    for ($f = 0; $f < $rango; $f++) {
        echo '<td>

          <table border="0px" width="100%">
          <tr>';

        for ($l = 0; $l < $cantidad_lunes_array[$f]; $l++) {

            if ($cantidad_lunes_array[$f] == '4444') {
                $porcentaje_celda = 'style="width:25%;border:1px solid #000;background-color:#dbeef4;"';
            } else {
                $porcentaje_celda = 'style="width:20%;border:1px solid #000;background-color:#dbeef4;"';
            }
            echo '<td ' . $porcentaje_celda . '>';
            echo '
                            <table align="center" border="0" width="85%">
                                <tr>
                                    <td class="num-con-check">
                                        <div data-rel="popover" data-trigger="hover" data-placement="rigth" data-content="" id="quincena' . $diasslunes[$f][$l] . '">&nbsp;</div>
                                    </td>
                                    <td class="vacio-con-check">
                                        &nbsp;
                                    </td>
                                    <td class="con-check">
                                        <div style="visibility:hidden;" id="check_box_quincena_' . $diasslunes[$f][$l] . '">
                                            <input onclick="nosuma(\'' . $diasslunes[$f][$l] . '\');" id="check_box_' . $diasslunes[$f][$l] . '" name="" class="ace ace-checkbox-2" type="checkbox"/>
                                            <span class="lbl">&nbsp;</span>
                                        </div> 
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" value="" id="lunreal' . $diasslunes[$f][$l] . '" name="lunreal' . $diasslunes[$f][$l] . '" />
                            <input type="hidden" value="" id="montoquin' . $diasslunes[$f][$l] . '" name="montoquin' . $diasslunes[$f][$l] . '" />
                            <input type="hidden" value="" id="idventa' . $diasslunes[$f][$l] . '" name="idventa' . $diasslunes[$f][$l] . '" />
                            <input type="hidden" value="" title="chekeado' . $diasslunes[$f][$l] . '" id="chekeado' . $diasslunes[$f][$l] . '" name="chekeado' . $diasslunes[$f][$l] . '" />';


            echo '</td>';
        }

        echo '</tr>
      </table>

           </td>';
    }
    echo "</tr>";
    //SALTO DE LINEA
    echo "
    <tr>
        <td colspan=" . $colspan_totales . ">&nbsp;
        </td>
    </tr>";
    
    echo "
  <tr>
    <td style='border:1px solid #000;min-width: 164px;max-width: 164px;'>
      <strong>&nbsp;TOTAL INGRESOS</strong>
    </td>";
    for ($ti = 0; $ti < $rango; $ti++) {
        echo '<td>

          <table border="1px" width="100%">
          <tr>';

        for ($l = 0; $l < $cantidad_lunes_array[$ti]; $l++) {

            if ($cantidad_lunes_array[$ti] == '4444') {
                $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
            } else {
                $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
            }
            echo '<td ' . $porcentaje_celda . '>';
            echo '      
                          <div style="text-align:center;" id="montingre' . $diasslunes[$ti][$l] . "_" . $diassdomingo[$ti][$l] . '">&nbsp;</div>
                          
                          <input type="hidden" id="montquintotal' . $diasslunes[$ti][$l] . '" value=""/>
                          
                          <input type="hidden" id="monting' . $diasslunes[$ti][$l] . "_" . $diassdomingo[$ti][$l] . '" value=""/>';

            echo '</td>';
        }

        echo '</tr>
      </table>

           </td>';
    }
    echo "</tr>
<tr>
    <td style='border:1px solid #000;min-width: 164px;max-width: 164px;'>
      <strong>&nbsp;INGRESOS ACUMULADOS</strong>
    </td>";

    /* FOR INICIA RANGO */
    for ($tia = 0; $tia < $rango; $tia++) {

        echo '<td>

          <table border="1px" width="100%">
          <tr>';

        for ($m = 0; $m < $cantidad_lunes_array[$tia]; $m++) {

            if ($cantidad_lunes_array[$tia] == '4444') {
                $porcentaje_celda = 'style="width:25%;border:1px solid #000;"';
            } else {
                $porcentaje_celda = 'style="width:20%;border:1px solid #000;"';
            }
            echo '<td ' . $porcentaje_celda . '>';
            echo '
                            <div style="text-align:center;" id="mont_acum' . $diasslunes_ant[$tia][$m] . "_" . $diassdomingo_ant[$tia][$m] . '">&nbsp;</div>
                            
                              <input type="hidden" id="montingant' . $diasslunes_ant[$tia][$m] . "_" . $diassdomingo_ant[$tia][$m] . '" value=""/>

                              <input type="hidden" id="montingact' . $diasslunes[$tia][$m] . "_" . $diassdomingo[$tia][$m] . '" value=""/>
                             
                              <input type="hidden" id="montingtot' . $diasslunes_ant[$tia][$m] . "_" . $diassdomingo_ant[$tia][$m] . '" value=""/>
                             
                              <input type="hidden" id="montingacum' . $diasslunes_ant[$tia][$m] . "_" . $diassdomingo_ant[$tia][$m] . '" value=""/>';

            echo '</td>';
        }
        echo '</tr>
      </table>
           </td>';
    }
    /* FOR TERMINA RANGO */

    echo "</tr>";
echo "</table>";

} else {
    echo '
  <div class="alert alert-danger">
    <strong>
      Atenci&oacute;n!
    </strong>
    No existen Cuentas y/o Subcuentas de Ingreso creadas o activas para esta la empresa <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong>.</span> Revise 
    <strong>
      <a href="' . base_url() . "cuenta" . "/" . $id_empresa . '">
      aqu&iacute;</a>
    </strong>
  </div>
  ';
}
?>



<script type="text/javascript">
    var total = 0;
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

    $(document).ready(function () {
      
        $('[data-rel=popover]').popover({html:true});

        $('#loading').hide();
       
        $("input").change(function(){
            $(this).parent().removeClass('has-error');
            $(this).next().empty();
        });

        var idcsarray = <?php echo json_encode($idcsarray); ?>;
//console.log(idcsarray);        
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


        var mesesarrayq = <?php echo json_encode($meses_arrayq); ?>;
//console.log(mesesarrayq);
        var añosarrayq = <?php echo json_encode($años_arrayq); ?>;
//console.log(añosarrayq);
        var lunesarrayq = <?php echo json_encode($cantidad_lunes_arrayq); ?>;
//console.log(lunesarrayq);

        let servicearray1 = <?php echo json_encode($servicearray1); ?>;
        //console.log(servicearray1);

        let servicearray2 = <?php echo json_encode($servicearray2); ?>;

        var cant_mesq = mesesarray.length;
        var cant_anoq = añosarray.length;
        

        var i = 0;
        /*for (var l = 0; l < cant_anoq; l++) {
         for (var m = 0; m < cant_mesq; m++) {
         //muestra_quincena(añosarray[l],mesesarray[m]);
         //console.log(añosarrayq[l],mesesarrayq[m],lunesarrayq[m]);
         /*}
         }*/

        var total_ingreso = 0;

        var cant_lun = diasslunes.length;
        var cant_dom = diassdomingo.length;
        var cant_idcs = idcsarray.length;
        var cant_s1 = servicearray1.length;
        var cant_s2 = servicearray2.length;
        
    

        var i = 0;
        //Creamos un array para ejecutar todas las consultas ajax en una sola.
        var arg = [];
        var arg_fortnight = [];
        var arg_day = [];
        var arg_increase = [];
        var arg_serv1 = [];
        var arg_serv2 = [];

        for (var l = 0; l < cant_lun; l++) {
            for (var m = 0; m < diasslunes[l].length; m++) {
                for (var cs = 0; cs < cant_idcs; cs++) {
                    i++;
                    var str = idcsarray[cs];
                    var idc = str.split("_");
                    arg.push({idc: idc[0], ids: idc[1], fi: diasslunes[l][m], ft: diassdomingo[l][m]});
                    //eliminamos las consultas ajax individuales agrupamos todos los datos
                    //devuelve_monto(idc[0], idc[1], diasslunes[l][m], diassdomingo[l][m]);
                }
                arg_fortnight.push({fi: diasslunes[l][m], ft: diassdomingo[l][m]});
                arg_day.push({fi: diasslunes[l][m], ft: diassdomingo[l][m]});
                arg_increase.push({fi_a: diasslunes_ant[l][m], ft_a: diassdomingo_ant[l][m], fi: diasslunes[l][m], ft: diassdomingo[l][m]});
            }
        }
        
        //QUINCENA 1
        for (var s = 0; s < cant_s1; s++) {           
            var strs = servicearray1[s];
            var ser = strs.split("_");
            arg_serv1.push({mes: ser[0], ano: ser[1], id_servicio: ser[2]});           
        }
        return_service1(arg_serv1);

        //QUINCENA 2
        for (var s2 = 0; s2 < cant_s2; s2++) {           
            var strs2 = servicearray2[s2];
            var ser2 = strs2.split("_");
            arg_serv2.push({mes: ser2[0], ano: ser2[1], id_servicio: ser2[2]});           
        }        
        return_service2(arg_serv2);
        
        return_amount(arg);
        show_fortnight(arg_fortnight);
       
        if (returns_total_income(arg_day)) {
            returns_cumulative_increase(arg_increase);
        }
    


    });

    function return_service1(arg_serv1) {
        //console.log(arg_serv1);
        $.ajax({
            url: "<?php echo site_url('devuelve_servicio_editar/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg_serv1), ide: $('#id_empresa_guarda').val()},
            success: function (res)
            {
                
                
               for (var i = 0; i < res.length; i++) {
                    
                var req = res[i];

                    for (var j = 0; j < req.length; j++) { 
                    
                        var mes = req[j].id_mes;
                        if(mes.length == 1){mes = "0"+mes;}else{mes = mes;}
                        var ano = req[j].id_ano;
                        var id_servicio = req[j].id_servicio;
                        var id_empresa_guarda = req[j].id_empresa_guarda;
                        var monto = req[j].monto_quincena;
                        var usuario_traza = req[j].usuario_guarda;
                        var fecha_traza = req[j].fecha_guarda;
                        
                        var fecha_traza_list = fecha_traza.split(" ");
                        var fecha_mostrar = fecha_traza_list[0];
                        var fecha_mostrar_list = fecha_mostrar.split("-");
                        var fecha_mostrar_list_2 = fecha_mostrar_list[2] + "-" + fecha_mostrar_list[1] + "-" + fecha_mostrar_list[0];


                        tabla_traza1 = '<table class="table table-striped table-bordered table-hover width="100%"><thead><th style="text-align:center;font-size:14px;text-decoration:underline;" colspan=4>Traza Monto ' +formatNumber(monto)+'</th><tr><th style="text-align:center;">&Uacute;ltimo usuario</th><th style="text-align:center;">Fecha</th></tr></thead><tbody>';

                        tabla_traza1 += "<tr><td style='text-align:center;'>"+usuario_traza+"</td><td style='text-align:center;'>"+fecha_mostrar_list_2+" "+fecha_traza_list[1]+"</td></tr>";

                        if (monto > 0) {
                            $("#serv1_" + id_empresa_guarda + "_" + mes + "_" + ano + "_" + id_servicio).html(formatNumber(monto)).attr('data-content', tabla_traza1 );
                        }
                    
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("Error al obtener los datos");
            }
        });
    }

    function return_service2(arg_serv2) {
            
            $.ajax({
                url: "<?php echo site_url('devuelve_servicio_editar/') ?>",
                type: "POST",
                dataType: "JSON",
                data: {arg: JSON.stringify(arg_serv2), ide: $('#id_empresa_guarda').val()},
                success: function (res)
                {
                    
    
                   for (var i = 0; i < res.length; i++) {
                        
                    var req = res[i];
    
                        for (var j = 0; j < req.length; j++) {
                        
                        var mes = req[j].id_mes;
                        if(mes.length == 1){mes = "0"+mes;}else{mes = mes;}
                        var ano = req[j].id_ano;
                        var id_servicio = req[j].id_servicio;
                        var id_empresa_guarda = req[j].id_empresa_guarda;
                        var monto = req[j].monto_quincena;
                        var usuario_traza = req[j].usuario_guarda;
                        var fecha_traza = req[j].fecha_guarda;

                        tabla_traza2 = '<table class="table table-striped table-bordered table-hover width="100%"><thead><th style="text-align:center;font-size:14px;text-decoration:underline;" colspan=4>Traza Monto ' +formatNumber(monto)+'</th><tr><th style="text-align:center;">&Uacute;ltimo usuario</th><th style="text-align:center;">Fecha</th></tr></thead><tbody>';

                        tabla_traza2 += "<tr><td style='text-align:center;'>"+usuario_traza+"</td><td style='text-align:center;'>"+fecha_traza+"</td></tr>";
    
                        if (monto > 0) {
                            $("#serv2_" + id_empresa_guarda + "_" + mes + "_" + ano + "_" + id_servicio).html(formatNumber(monto)).attr('data-content', tabla_traza2 );
                        }
    
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error al obtener los datos");
                }
            });
        }

    function nosuma(lunes){
        
        //console.log(lunes);
        var estado;
        var chequed = $('#check_box_'+lunes)[0].checked;
        var idventa = $('#idventa'+lunes).val();
        var lunreal = $('#lunreal'+lunes).val();

        var id_e = $('#id_empresa_guarda').val();
        var hoy_dia = "<?php echo $hoy ?>";
        //console.log(chequed);
        if(chequed==true){
            estado = 1;
            //$('#quincena'+lunes).attr("style","text-decoration: none");
        }else{
            estado = 0;
            //$('#quincena'+lunes).attr("style","text-decoration: line-through");
        }

        var url = "<?php echo site_url('update_ingreso_total')?>";
        
         // ajax adding data to database
        /*bootbox.confirm("¿Está seguro de <B>ELIMINAR</B> este Detalle?", function(result) {
            
            if(result) {*/

                $.ajax({
                    url : url,
                    type: "POST",
                    data: {estado: estado, lunes_quincena: lunreal, id_empresa_guarda: id_e},
                    dataType: "JSON",
                    success: function(data)
                    {
                        $(location).attr('href', '<?php echo base_url() ?>ingreso/' + id_e + '/' + hoy_dia);
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error al actualizar los datos.');

                    }
                });

            /*}
        })*/
    }

    function siguiente(siguiente) {
        var id_e = $('#id_empresa_guarda').val();
        $(location).attr('href', '<?php echo base_url() ?>ingreso/' + id_e + '/' + siguiente);
    }

    function hoy(hoy) {
        var id_e = $('#id_empresa_guarda').val();
        $(location).attr('href', '<?php echo base_url() ?>ingreso/' + id_e + '/' + hoy);
    }

    function anterior(anterior) {
        //alert(anterior);
        var id_e = $('#id_empresa_guarda').val();
        $(location).attr('href', '<?php echo base_url() ?>ingreso/' + id_e + '/' + anterior);
    }

    //HAmestica: Función que permite recargar la pantalla para ordenar sub cuentas
    function cargarTotales(fecha,orden,direccion,fecini,fecfin){
        var id_e = $('#id_empresa_guarda').val();

        $(location).attr('href', '<?php echo base_url() ?>ingreso/' + id_e + '/' + fecha + '/' + orden + '/' + direccion + '/' + fecini + '/' + fecfin);
    }

    function edit_ingreso(){

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

        $(location).attr('href','<?php echo base_url() ?>movimiento/' + id_e + '/' + id_movimiento);

}

    function movimiento(idc, ids, fi, ft) {
        
        var id_m = $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val();
        var id_me = $("#idme" + idc + "_" + ids + "_" + fi + "_" + ft).val();
        var id_cero = $("#id_cero" + idc + "_" + ids + "_" + fi + "_" + ft).val();
        var id_e = $('#id_empresa_guarda').val();

        if (id_m) {
            id_movimiento = id_m + "@" + id_me; //editar
        } else {
            id_movimiento = 0 + "@" + id_cero; //nuevo
        }

        $(location).attr('href', '<?php echo base_url() ?>movimiento/' + id_e + '/' + id_movimiento);

    }

    function levanta_detalle(idc,ids,fi,ft){

        var id_m = $("#idm"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();
        var lav_e = $("#idme"+idc+"_"+ids+"_"+fi+"_"+ft+"").val();

        $("#id_movimiento_up").val(id_m);
        $("#id_movimiento_e_up").val(lav_e);


          //Ajax Load data from ajax
if(id_m>0){
  $.ajax({
  url : "<?php echo site_url('get_up_detalle_egreso/')?>" + id_m,
  type: "GET",
  dataType: "JSON",
  success: function(data)
  {

    table_docs = '<table class="table table-striped table-bordered table-hover width="90%"><thead><tr><th style="text-align:center;">Tipo de Dcto.</th><th style="text-align:center;">Nro. Dcto.</th><th style="text-align:center;">Monto</th><th style="text-align:center;">Fecha Pago</th></tr></thead><tbody>';

    for (var i=0;i<data.length; i++){ //cuenta la cantidad de registros
              
              var nombre_tipo_documento = data[i].nombre_tipo_documento;
              var numero_tipo_documento = data[i].numero_tipo_documento;
              var monto = data[i].monto;
              var fecha_pago = data[i].fecha_pago;
              if(fecha_pago == '00-00-0000' || fecha_pago == '0000-00-00' || fecha_pago == '' ){
                fecha_pago = '';
              }else{
                fecha_pago =fecha_pago;
              }
              var nombre_tipo_estado_movimiento = data[i].nombre_tipo_estado_movimiento;

              if(nombre_tipo_estado_movimiento == 'PAGADO'){
                color_back = 'style="background-color:#FFFF00;"';
              }else{
                color_back = 'style="background-color:#EEEEEE;"';
              }

              table_docs += "<tr><td>"+nombre_tipo_documento+"</td><td style='text-align:center;'>"+numero_tipo_documento+"</td><td style='text-align:right;'>$ "+formatNumber(monto)+"</td><td style='text-align:center;'>"+fecha_pago+"</td></tr>";

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

    function returns_total_income(arg) {
         //console.log('w');
        $.ajax({
            url: "<?php echo site_url('returns_total_income/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg), idtm: 1, ide: $('#id_empresa_guarda').val()},
            async: false,
            success: function (req)
            {
                //console.log(req);
                var montquintotal;
                var monto_total_mts = 0;
                var monto_total_mbts = 0;
                var monto_total_mncts = 0;
                var total_semanal = 0;
                var fi;
                var ft;
                var res_total;
                for (var j = 0; j < req.length; j++) {
                    var obj = req[j];
                    monto_total_mts = 0;
                    monto_total_mbts = 0;
                    monto_total_mncts = 0;
                    total_semanal = 0;

                    //console.log(obj);
                    if (obj instanceof Array) {
                        for (var g = 0; g < obj.length; g++) {
                            montquintotal = obj[g].montquintotal;
                            fi = obj[g].data.fi;
                            ft = obj[g].data.ft;
                            res_total = obj[g].result;

                            if (res_total.id_tipo_estado_movimiento === '2') {
                                monto_total_mts = monto_total_mts + parseInt(res_total.monto);
                                monto_total_mbts = monto_total_mbts + parseInt(res_total.monto_cuenta_banco);
                                monto_total_mncts = monto_total_mncts + parseInt(res_total.monto_nota_credito);
                                total_semanal = (monto_total_mts + monto_total_mbts + (montquintotal + (montquintotal * 0.19)) ) - monto_total_mncts;
                            }
                        }
                    } else {
                        montquintotal = obj.montquintotal+ (obj.montquintotal * 0.19);
                        fi = obj.data.fi;
                        ft = obj.data.ft;
                    }
                   
                    if (total_semanal > 0) {
                        $("#montingre" + fi + "_" + ft).html(formatNumber(total_semanal)).css("font-weight", "bold");
                        $("#monting" + fi + "_" + ft).val(total_semanal);
                        $("#montingact" + fi + "_" + ft).val(total_semanal);
                        $("#montingant" + fi + "_" + ft).val(total_semanal);
                    } else if (total_semanal === 0) {
                        if (montquintotal > 0) {
                            $("#montingre" + fi + "_" + ft).html(formatNumber(montquintotal)).css("font-weight", "bold");
                            $("#monting" + fi + "_" + ft).val(montquintotal);
                            $("#montingact" + fi + "_" + ft).val(montquintotal);
                            $("#montingant" + fi + "_" + ft).val(montquintotal);
                        } else {
                            $("#montingre" + fi + "_" + ft).html(0).css("font-weight", "bold");
                            $("#monting" + fi + "_" + ft).val(0);
                            $("#montingact" + fi + "_" + ft).val(0);
                            $("#montingant" + fi + "_" + ft).val(0);
                        }
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos 2.');
            }
        });
        return true;
    }

    function show_fortnight(arg) {
        //console.log(arg[0].fi);

        $.ajax({
            url: "<?php echo site_url('return_sale/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {l: JSON.stringify(arg), e: $('#id_empresa_guarda').val()},
            success: function (req)
            {
                //var monto_quincena = 0;
                for (var j = 0; j < req.length; j++) { //cuenta la cantidad de registros
                    var res = req[j];
                    var lun1 = arg;
                    for (var i = 0; i < res.length; i++) { //cuenta la cantidad de registros
                        
                        var id_venta = parseInt(res[i].id_venta);
                        //monto_quincena = monto_quincena + parseInt(res[i].monto_quincena);
                        
                        var monto_quincena = parseInt(res[i].monto_quincena);
                        var monto_quincena = monto_quincena + (monto_quincena * 0.19);
                        var id_ano_mos = res[i].id_ano_quin;
                        var id_mes_mos = res[i].id_mes_quin;
                        var lunes_quincena = res[i].lunes_quincena;
                        var lunes_quincena_bd = res[i].lunes_quincena;
                        //console.log(typeof lunes_quincena_bd);
                        //console.log(lunes_quincena_bd);
                        //var lunes_quincena_string = res[i].lunes_quincena.toString();

                        
                        //console.log(lunes_quincena_string);
                        var lunes_iva = res[i].lunes_iva;
                        var monto_iva = res[i].monto_iva;
                        var estado = res[i].estado;
                        //console.log('lun1 ='+arg[j].fi+'lunes_quincena ='+lunes_quincena);
                        if( (lunes_quincena >= arg[j].fi) && (lunes_quincena <= arg[j].ft) ){
                            //console.log(lunes_quincena);
                            lunes_quincena=arg[j].fi;
                            
                        }
                        //console.log($("#quincena" + lunes_quincena).html());


                        if (monto_quincena > 0) {
                            //console.log(formatDate(new Date(lunes_quincena_bd)));
                            var lunes_quincena_list = lunes_quincena_bd.split("-");
                            var fecha_mostrar = "Fecha quincena: <strong>" + lunes_quincena_list[2] + "-" + lunes_quincena_list[1] + "-" + lunes_quincena_list[0] + "</strong>";

                            $("#quincena" + lunes_quincena).html(formatNumber(monto_quincena)).attr("data-content", fecha_mostrar);
                            $("#quincena" + lunes_iva).html(formatNumber(monto_iva));
                            $("#check_box_quincena_" + lunes_quincena).attr('style','visibility:show');
                            $("#montoquin" + lunes_quincena).val(monto_quincena);
                            $("#lunreal" + lunes_quincena).val(lunes_quincena_bd);
                            $("#idventa" + lunes_quincena).val(id_venta);
                            $("#chekeado" + lunes_quincena).val(estado);
                            if(estado == 1){
                                $("#check_box_" + lunes_quincena).attr('checked',true);
                                //$('#quincena'+lunes_quincena).attr("style","text-decoration: none");
                            }else{
                                $("#check_box_" + lunes_quincena).attr('checked',false);
                                //$('#quincena'+lunes_quincena).attr("style","text-decoration: line-through");
                                
                            }
                            $("#montquintotal" + lunes_quincena).val(monto_quincena);
                            $("#montquintotal" + lunes_iva).val(monto_iva);
                        }
                        
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos 3.');
            }
        });
    }
/*
    function returns_cumulative_increase(arg) {
        $.ajax({
            url: "<?php echo site_url('returns_cumulative_increase/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg), idtm: 1, ide: $('#id_empresa_guarda').val()},
            success: function (req)
            {
                var isfirst = true;
                for (var j = 0; j < req.length; j++) {
                    var obj = req[j];
                    var res_acum = obj.result;

                    var fi_a = obj.data.fi_a;
                    var ft_a = obj.data.ft_a;
                    var fi = obj.data.fi;
                    var ft = obj.data.ft;
                    //console.log(obj);
                    mbts = parseInt(res_acum.monto_banco_total_sem);
                    mncts = parseInt(res_acum.monto_nota_credito_total_sem);
                    var act = $("#montingact" + fi + "_" + ft).val() * 1;
                    var acum_ant = $("#montingacum" + fi_a + "_" + ft_a).val() * 1;
                    var provider = 0;
                    console.log( );
                    //console.log( fi_a + "_" + ft_a);
                    //2019-08-12
                    //console.log(acum_ant+' + '+act+' + '+parseInt(obj.lastamount));

                    if(isfirst){
                        provider = parseInt(obj.provider);
                    }

                    if(($('td.weeks_now[data-now="true"]').attr('data-now')==='true') || $('td.weeks_now').attr('data-now')==='true'){
                        act= $('#quincena'+ fi).html() === '&nbsp;' ? 0 : parseInt($('#quincena'+ fi).html());
                    }
                    acum_ant = acum_ant + act + parseInt(obj.lastamount)+ provider;
                    console.log(acum_ant+'  +  '+act+'  +  '+parseInt(obj.lastamount) +'  +  '+ provider);
                    let format = (acum_ant > 0) ? formatNumber(acum_ant) : acum_ant;
                    $("#mont_acum" + fi_a + "_" + ft_a).html(format).css("font-weight", "bold");
                    $("#montingacum" + fi + "_" + ft).val(acum_ant);
                    isfirst=false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //$("#mont_acum" + fi_a + "_" + ft_a + "").html();
            }
        });
    }
*/
function returns_cumulative_increase(arg) {
        $.ajax({
            url: "<?php echo site_url('returns_cumulative_increase/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg), idtm: 1, ide: $('#id_empresa_guarda').val()},
            success: function (req)
            {
                var isfirst = true;
                for (var j = 0; j < req.length; j++) {
                    var obj = req[j];
                    
                    var res_acum = obj.result;
                    var mts = parseInt(res_acum.monto_total_sem);

                    var fi_a = obj.data.fi_a;
                    var ft_a = obj.data.ft_a;
                    var fi = obj.data.fi;
                    var ft = obj.data.ft;
                    mbts = parseInt(res_acum.monto_banco_total_sem);
                    mncts = parseInt(res_acum.monto_nota_credito_total_sem);
                    
                    var monto_ingreso_actual = $("#montingact" + fi + "_" + ft).val() * 1;
                    var total = $("#montingacum" + fi_a + "_" + ft_a).val() * 1;
                    
                    let value = (total+monto_ingreso_actual+parseInt(obj.lastamount));
                    let format = (value > 0) ? formatNumber(value) : (value);
                    $("#mont_acum" + fi_a + "_" + ft_a).html(format).css("font-weight", "bold");
                    $("#montingacum" + fi + "_" + ft).val(value);

                    //console.log(total+"-"+monto_ingreso_actual+"-"+parseInt(obj.lastamount));
                    /*console.log('esta i = ' +  + '=' +total + ' + '+ monto_ingreso_actual + ' +' + parseInt(obj.lastamount));
                    var act = $("#montingact" + fi + "_" + ft).val() * 1;
                    var acum_ant = $("#montingacum" + fi_a + "_" + ft_a).val() * 1;
                    var provider = 0;
                    console.log('act antes '+act);
                    console.log('acum_ant'+acum_ant);

                    if(isfirst){
                        provider = parseInt(obj.provider);
                    }

                    if(($('td.weeks_now[data-now="true"]').attr('data-now')==='true') ||
                        $('td.weeks_now').attr('data-now')==='true'){
                        let old_act = act;
                        act= $('#quincena'+ fi).html() === '&nbsp;' ? 0 : parseInt($('#quincena'+ fi).html());
                        /*if(mts+act!==old_act){
                            act = old_act;
                }*//*
                    }
                    let vart = $('#quincena'+ fi).html() === '&nbsp;' ? 0 : parseInt($('#quincena'+ fi).html());
                    console.log('vart = '+vart);
                    console.log((acum_ant + act + parseInt(obj.lastamount)+ provider)+' = '+acum_ant+'  +  '+act+'  +  '+parseInt(obj.lastamount) +'  +  '+ provider);
                    acum_ant = acum_ant + act + parseInt(obj.lastamount)+ provider;
                    
                    let format = ((total+monto_ingreso_actual) > 0) ? formatNumber((total+monto_ingreso_actual)) : (total+monto_ingreso_actual);
                    $("#mont_acum" + fi_a + "_" + ft_a).html(format).css("font-weight", "bold");
                    $("#montingacum" + fi + "_" + ft).val(acum_ant);
                    isfirst=false;*/
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //$("#mont_acum" + fi_a + "_" + ft_a + "").html();
            }
        });
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

    function return_amount(arg) {

        $.ajax({
            url: "<?php echo site_url('query_amount/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {arg: JSON.stringify(arg), idtm: 1, ide: $('#id_empresa_guarda').val()},
            success: function (req)
            {
                for (var j = 0; j < req.length; j++) {
                    
                    var monto_total_cel = 0;
                    var monto_total_ncr = 0;
                    var monto_total_ban = 0;
                    var cant_id_det_mov = 0;
                    var fecga_cero = 0;
                    var pagado = 0;
                    var res = req[j];

                    for (var i = 0; i < res.length; i++) { //cuenta la cantidad de registros

                        var idc = res[i].idc;
                        var ids = res[i].ids;

                        var fi = res[i].fi;
                        var ft = res[i].ft;

                        var fecha_ingreso = res[i].fecha_ingreso;
                        var fecha_pago = res[i].fecha_pago;

                        var id_movimiento = res[i].id_movimiento;
                        var id_movimiento_detalle = res[i].id_movimiento_detalle;

                            tabla_detalle = '<table class="table table-striped table-bordered table-hover width="100%"><thead><th style="text-align:center;font-size:14px;text-decoration:underline;" colspan=4>Detalle del movimiento: '+id_movimiento+'</th><tr><th style="text-align:center;">Tipo de Dcto.</th><th style="text-align:center;">Nro. Dcto.</th><th style="text-align:center;">Monto</th><th style="text-align:center;">Fecha Pago</th></tr></thead><tbody>';
                    
                                for (var h=0;h<res.length; h++){ //cuenta la cantidad de registros
                                            
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

                                            if(nombre_tipo_estado_movimiento == 'PAGADO'){
                                            color_back = 'style="background-color:#FFFF00;"';
                                            }else{
                                            color_back = 'style="background-color:#EEEEEE;"';
                                            }

                                            tabla_detalle += "<tr><td>"+nombre_tipo_documento_detalle+"</td><td style='text-align:center;'>"+numero_tipo_documento_detalle+"</td><td style='text-align:right;'>$ "+formatNumber(monto_detalle)+"</td><td style='text-align:center;'>"+fecha_pago_detalle+"</td></tr>";
                                        }

                                tabla_detalle += '</tbody></table>';

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

                        //console.log(fi+"--"+ft);
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
                      

                        if (monto_total_mostrar > 0) {

                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_total_mostrar)).css("background", color_celda);
                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).attr("data-content", tabla_detalle);
                            $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                            $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);

                        } else if (monto_total_mostrar == 0) {

                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(monto_total_mostrar);
                            $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                            $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);

                        } else {

                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_total_mostrar)).css("color", "red");
                            $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                            $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);

                        }
                        if (monto_cuenta_banco > 0) {
                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_cuenta_banco));
                            $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                            $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_cuenta_banco);
                        } else {
                            $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html();
                        }

                    }

                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos.');
            }
        });
    }

    function devuelve_monto(idc, ids, fi, ft) {

        //console.log("#" + idc + "_" + ids + "_" + fi + "_" + ft + "");
        var ide = $('#id_empresa_guarda').val();
        $.ajax({
            url: "<?php echo site_url('consulta_movimiento/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {idc: idc, ids: ids, fi: fi, ft: ft, idtm: 1, ide: ide},
            success: function (res)
            {
                var monto_total_cel = 0;
                var monto_total_ncr = 0;
                var monto_total_ban = 0;
                var cant_id_det_mov = 0;

                for (var i = 0; i < res.length; i++) { //cuenta la cantidad de registros

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

                    //console.log(monto+"-"+monto_nota_credito);


                    /*if(prioritario == 1){
                     color_celda = color_tipo_documento;
                     }*/

                    /*}else{
                     if(id_tipo_estado_movimiento == 1){
                     color_celda = 'yellow';
                     }else{
                     color_celda = color_tipo_documento;
                     }
                     }*/

                    monto_total_cel = monto_total_cel + monto;
                    monto_total_ncr = monto_total_ncr + monto_nota_credito;
                    monto_total_ban = monto_total_ban + monto_cuenta_banco;
                    monto_total_mostrar = monto_total_cel - monto_total_ncr;
                     
                    if (cant_id_det_mov == 1) {
                        if (id_tipo_estado_movimiento == 1) {
                            color_celda = 'yellow';
                        } else {
                            color_celda = color_tipo_documento;
                        }
                    }

                    if (monto_total_mostrar > 0) {

                        $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_total_mostrar)).css("background", color_celda);
                        $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                        $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);
                        


                    } else if (monto_total_mostrar == 0) {

                        $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(monto_total_mostrar);
                        $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                        $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);

                    } else {

                        $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_total_mostrar)).css("color", "red");
                        $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                        $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_total_mostrar);

                    }
                    if (monto_cuenta_banco > 0) {
                        $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html(formatNumber(monto_cuenta_banco));
                        $("#idm" + idc + "_" + ids + "_" + fi + "_" + ft).val(id_movimiento);
                        $("#mont" + idc + "_" + ids + "_" + fi + "_" + ft).val(monto_cuenta_banco);
                    } else {
                        $("#" + idc + "_" + ids + "_" + fi + "_" + ft).html();
                    }

                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos.');
            }
        });
    }

    function muestra_quincena(l) {

        var e = $('#id_empresa_guarda').val();

        $.ajax({

            url: "<?php echo site_url('devuelve_venta/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {l: l, e: e},
            success: function (res)
            {

                for (var i = 0; i < res.length; i++) { //cuenta la cantidad de registros

                    var monto_quincena = parseInt(res[i].monto_quincena);
                    var id_ano_mos = res[i].id_ano_quin;
                    var id_mes_mos = res[i].id_mes_quin;
                    var lunes_quincena = res[i].lunes_quincena;
                    var lunes_iva = res[i].lunes_iva;
                    var monto_iva = res[i].monto_iva;

                    if (monto_quincena > 0) {
                        $("#quincena" + lunes_quincena).html(formatNumber(monto_quincena));
                        $("#quincena" + lunes_iva).html(formatNumber(monto_iva));
                        $("#montoquin" + lunes_quincena).val(monto_quincena);
                        $("#montquintotal" + lunes_quincena).val(monto_quincena);
                        $("#montquintotal" + lunes_iva).val(monto_iva);
                    }


                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos.');
            }
        });
    }

    function trae_euincena(fi) {

        var ide = $('#id_empresa_guarda').val();
        var mq = 0;
        $.ajax({

            url: "<?php echo site_url('trae_euincena/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {fi: fi, ide: ide},
            async: false,
            success: function (res_total)
            {
                for (var i = 0; i < res_total.length; i++) {
                    mq = res_total[i].monto_quincena;
                }


            }
        });

        return mq;
    }

    function trae_iba(fi) {

        var ide = $('#id_empresa_guarda').val();
        var mi = 0;
        $.ajax({

            url: "<?php echo site_url('trae_iba/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {fi: fi, ide: ide},
            async: false,
            success: function (res_iba)
            {
                for (var i = 0; i < res_iba.length; i++) {
                    mi = res_iba[i].monto_iva;
                }


            }
        });

        return mi;
    }

    function devuelve_ingreso_total(fi, ft, fi_a, ft_a) {

        var quin = trae_euincena(fi);
        var ide = $('#id_empresa_guarda').val();
        var fecha = fi.split("-");
        var fecha_2 = fecha[0] + '-' + fecha[1] + '-' + fecha[2];

        var iv = trae_iba(fi);

        if (fi == fecha_2) {
            if (parseInt(quin) > 0) {
                var montquintotal = parseInt(quin);
            } else {
                var montquintotal = parseInt(iv);
            }
        } else {
            var montquintotal = 0;
        }
        //console.log(montquintotal);
        $.ajax({
            url: "<?php echo site_url('consulta_ingreso_total/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {fi: fi, ft: ft, idtm: 1, ide: ide},
            success: function (res_total)
            {
                //console.log(res_total);
                var monto_total_mts = 0;
                var monto_total_mbts = 0;
                var monto_total_mncts = 0;
                var total_semanal = 0;

                for (var i = 0; i < res_total.length; i++) {
                    mts = parseInt(res_total[i].monto);
                    mbts = parseInt(res_total[i].monto_cuenta_banco);
                    mncts = parseInt(res_total[i].monto_nota_credito);
                    estado_mov = res_total[i].id_tipo_estado_movimiento;

                    if (estado_mov == 2) {
                        monto_total_mts = monto_total_mts + mts;
                        monto_total_mbts = monto_total_mbts + mbts;
                        monto_total_mncts = monto_total_mncts + mncts;
                        total_semanal = (monto_total_mts + monto_total_mbts + montquintotal) - monto_total_mncts;
                    }

                }

                //console.log("total_semanal: "+total_semanal);

                if (total_semanal > 0) {
                    $("#montingre" + fi + "_" + ft).html(formatNumber(total_semanal)).css("font-weight", "bold");
                    $("#monting" + fi + "_" + ft).val(total_semanal);
                    $("#montingact" + fi + "_" + ft).val(total_semanal);
                    $("#montingant" + fi + "_" + ft).val(total_semanal);
                } else if (total_semanal == 0) {
                    if (montquintotal > 0) {
                        $("#montingre" + fi + "_" + ft).html(formatNumber(montquintotal)).css("font-weight", "bold");
                        $("#monting" + fi + "_" + ft).val(montquintotal);
                        $("#montingact" + fi + "_" + ft).val(montquintotal);
                        $("#montingant" + fi + "_" + ft).val(montquintotal);
                    } else {
                        $("#montingre" + fi + "_" + ft).html(0).css("font-weight", "bold");
                        $("#monting" + fi + "_" + ft).val(0);
                        $("#montingact" + fi + "_" + ft).val(0);
                        $("#montingant" + fi + "_" + ft).val(0);
                    }
                }/*else{
                 $("#montingant"+fi+"_"+ft).val("hola");
                 }*/
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error al obtener los datos.');
            }
        });
    }

    /*function devuelve_ingreso_acum(fi,ft,fi_a,ft_a){
     
     var act = $("#montingact"+fi+"_"+ft).val() * 1;
     var acum_ant = $("#montingacum"+fi_a+"_"+ft_a).val() * 1;
     
     acum_ant = acum_ant + act;
     
     if(acum_ant>0){
     $("#mont_acum"+fi_a+"_"+ft_a).html(formatNumber(acum_ant)).css("font-weight", "bold");
     $("#montingacum"+fi+"_"+ft).val(acum_ant);
     }else{
     $("#mont_acum"+fi_a+"_"+ft_a).html(acum_ant).css("font-weight", "bold");
     $("#montingacum"+fi+"_"+ft).val(acum_ant);
     }
     
     }*/






    function devuelve_ingreso_acum(fi_a, ft_a, fi, ft) {

        var quin = trae_euincena(fi);
        var ide = $('#id_empresa_guarda').val();


        var fecha = fi.split("-");
        var fecha_2 = fecha[0] + '-' + fecha[1] + '-' + fecha[2];

        var iv = trae_iba(fi);

        if (fi == fecha_2) {
            if (parseInt(quin) > 0) {
                var montquintotal = parseInt(quin);
            } else {
                var montquintotal = parseInt(iv);
            }
        } else {
            var montquintotal = 0;
        }


        $.ajax({
            url: "<?php echo site_url('consulta_ingreso_acum/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {fi: fi_a, ft: ft, idtm: 1, ide: ide},
            success: function (res_acum)
            {
                //console.log(res_acum);
                //mts = parseInt(res_acum.monto_total_sem);
                //mbts = parseInt(res_acum.monto_banco_total_sem);
                // mncts = parseInt(res_acum.monto_nota_credito_total_sem);


                /** INICIA BIEN SUMA ACUMULADO, PERO NO AVANZA */

                var act = $("#montingact" + fi + "_" + ft).val() * 1;
                var acum_ant = $("#montingacum" + fi_a + "_" + ft_a).val() * 1;

                acum_ant = acum_ant + act;
                if (acum_ant > 0) {
                    $("#mont_acum" + fi_a + "_" + ft_a).html(formatNumber(acum_ant)).css("font-weight", "bold");
                    $("#montingacum" + fi + "_" + ft).val(acum_ant);
                } else {
                    $("#mont_acum" + fi_a + "_" + ft_a).html(acum_ant).css("font-weight", "bold");
                    $("#montingacum" + fi + "_" + ft).val(acum_ant);
                }

                /** TERMINA BIEN SUMA ACUMULADO, PERO NO AVANZA */


                /** INICIA MAL SUMA ACUMULADO, PERO SÍ AVANZA */
                /*
                 total_semanal = (mts + mbts + montquintotal) - mncts;
                 
                 if(total_semanal > 0){
                 $("#mont_acum"+fi_a+"_"+ft_a+"").html(formatNumber(total_semanal)).css("font-weight", "bold");
                 $("#montingacum"+fi+"_"+ft).val(total_semanal);
                 }else {
                 $("#mont_acum"+fi_a+"_"+ft_a+"").html("0").css("font-weight", "bold");
                 $("#montingacum"+fi+"_"+ft).val(total_semanal);
                 }
                 */
                /** TERMINA MAL SUMA ACUMULADO, PERO SÍ AVANZA */



            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#mont_acum" + fi_a + "_" + ft_a + "").html();
            }
        });

    }

    function selecciona_quincena(e,m,a,q) {
        if(q==0){
            ingresa_monto_quincena1(e,m,a,q)
        }else{
            ingresa_monto_quincena2(e,m,a,q)
        }
    }
    
    function ingresa_monto_quincena1(e,m,a,s) {

        $('#form_quincena1')[0].reset(); 

        m.toString().length == 1 ? m="0"+m : m=m; 
        s == 0 ? txt_quincena="Primera Quincena" : txt_quincena="Segunda Quincena"; 
        s == 0 ? s=1 : s=s; 

        $('#mes_q1').val(m);
        $('#ano_q1').val(a);
        $('#id_servicio_q1').val(s);

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
            month: m-1,
            day: 1
        }
    })

        $.ajax({
            url: "<?php echo site_url('devuelve_servicio_editar_popup/')?>",
            type: "POST",
            dataType: "JSON",
            data: {
                e: e,
                m: m,
                a: a,
                s: s
            },
            success: function(res4) {
                for (var i = 0; i < res4.length; i++) { 
                    var monto = res4[i].monto_quincena;
                    var id_quincena = res4[i].id_quincena;
                    var fecha = res4[i].lunes_quincena;
                    
                    var fecha_list = fecha.split("-");
                    var fecha_mostrar = fecha_list[2] + "-" + fecha_list[1] + "-" + fecha_list[0];


                    $("#monto_servicio1"+i).val(monto);
                    $("#fecha_quincena1").val(fecha_mostrar);

                }
                $('#modal_form_quincena1').modal('show'); // show bootstrap modal
                $('.modal-title').text('Valores para la '+txt_quincena+'\n de '+ m +" de " + a); // Set Title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener los datos.');
            }
        });

}

function ingresa_monto_quincena2(e,m,a,s) {
        
        $('#form_quincena2')[0].reset(); 

        m.toString().length == 1 ? m="0"+m : m=m; 
        s == 0 ? txt_quincena="Primera Quincena" : txt_quincena="Segunda Quincena"; 
        s == 1 ? s=2 : s=s; 

        $('#mes_q2').val(m);
        $('#ano_q2').val(a);
        $('#id_servicio_q2').val(s);

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
            month: m-1,
            day: 1
        }
    })

        $.ajax({
            url: "<?php echo site_url('devuelve_servicio_editar_popup/')?>",
            type: "POST",
            dataType: "JSON",
            data: {
                e: e,
                m: m,
                a: a,
                s: s
            },
            success: function(res4) {
                for (var i = 0; i < res4.length; i++) { 
                    var monto = res4[i].monto_quincena;
                    var id_quincena = res4[i].id_quincena;
                    var fecha = res4[i].lunes_quincena;

                    var fecha_list_2 = fecha.split("-");
                    var fecha_mostrar_2 = fecha_list_2[2] + "-" + fecha_list_2[1] + "-" + fecha_list_2[0];

                    $("#monto_servicio2"+i).val(monto);
                    $("#fecha_quincena2").val(fecha_mostrar_2);
                }
                $('#modal_form_quincena2').modal('show'); // show bootstrap modal
                $('.modal-title').text('Valores para la '+txt_quincena+'\n de '+ m +" de " + a); // Set Title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener los datos.');
            }
        });

}

function save_servicio_q() {

    let ide_q = $('#id_empresa_guarda').val();
    let mes_q = $('#mes_q1').val();
    let ano_q = $('#ano_q1').val();
    let idq_q = $('#id_quincena_q1').val();
    //let ids_q = $('#id_servicio_q1').val();

    $('#btnSave').text('Guardando...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    var url;

    url = "<?php echo site_url('save_servicio_quincena')?>";
    var hoy_dia = "<?php echo $hoy ?>";
    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_quincena1').serialize(),
        dataType: "JSON",
        success: function(data) {
            

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_quincena1').modal('hide');
                $(location).attr('href', '<?php echo base_url() ?>ingreso/' + ide_q + '/' + hoy_dia);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('#'+data.inputerror[i]).parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('#'+data.inputerror[i]).next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
            
        },

        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al guardar o actualizar los datos.');
            $('#btnSave').text('Guardando...'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        }
    });
}

function save_servicio_q2() {

let ide_q = $('#id_empresa_guarda').val();
let mes_q = $('#mes_q2').val();
let ano_q = $('#ano_q2').val();
let idq_q = $('#id_quincena_q2').val();
//let ids_q = $('#id_servicio_q1').val();

$('#btnSave').text('Guardando...'); //change button text
$('#btnSave').attr('disabled', true); //set button disable
var url;

url = "<?php echo site_url('save_servicio_quincena2')?>";
var hoy_dia = "<?php echo $hoy ?>";
// ajax adding data to database
$.ajax({
    url: url,
    type: "POST",
    data: $('#form_quincena2').serialize(),
    dataType: "JSON",
    success: function(data) {
        

        if(data.status) //if success close modal and reload ajax table
        {
            $('#modal_form_quincena2').modal('hide');
            $(location).attr('href', '<?php echo base_url() ?>ingreso/' + ide_q + '/' + hoy_dia);
        }
        else
        {
            for (var i = 0; i < data.inputerror.length; i++)
            {
                $('#'+data.inputerror[i]).parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('#'+data.inputerror[i]).next().text(data.error_string[i]); //select span help-block class set text error string
            }
        }
        $('#btnSave').text('Guardar'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
        
    },

    error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al guardar o actualizar los datos.');
        $('#btnSave').text('Guardando...'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable
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
        <button class="btn btn-success" type="button" id="btnEdit" onclick="edit_ingreso()">
            <i class="ace-icon icon icon-pencil bigger-110"></i>
            Editar
        </button>

        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>

    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_form_quincena1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_quincena1" class="form-horizontal">
                    <input type="hidden" value="" name="mes_q1" id="mes_q1" />
                    <input type="hidden" value="" name="ano_q1" id="ano_q1" />
                    <input type="hidden" value="1" name="id_quincena_q1" id="id_quincena_q1" />
                    <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" />
                    <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda" />
                    
                    

                    <div class="form-body">
                    
                    <?php 

                        if(!empty($mostrar_servicios_primera_quincena)){
                            
                            $boton_disabled1 = '';
                            
                            echo '
                            
                            <div class="form-group">
                                <label class="control-label col-md-4">Fecha</label>
                                <div class="col-md-8">
                                    <input id="fecha_quincena1" name="fecha_quincena1"
                                        class="form-control date-picker" type="text"
                                        data-date-format="dd-mm-yyyy" value="" />
                                        <span class="help-block"></span>
                                </div>
                            </div>';

                        
                            echo '<input type="hidden" value="'.count($mostrar_servicios_primera_quincena).'" name="cantidad_servicios1" id="cantidad_servicios1" />';

                            $q1=0;
                            foreach ($mostrar_servicios_primera_quincena as $servicio1q) {
                                $ids = $servicio1q->id_servicio;
                                $quincena1 = devuelve_detalle_quincena1($ids, $meses, $año, $ide);
                                $nombre_servicio = devuelve_nombre_servicio($ids);
                                
                                echo '
                                <input type="hidden" value="'.$ids.'" name="id_servicio_q1[]" id="id_servicio_q1'.$q1.'" />
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Monto '.$nombre_servicio.'</label>
                                            <div class="col-md-8">
                                                <input name="monto_servicio1[]" id="monto_servicio1'.$q1.'" placeholder="Monto '.$nombre_servicio.'" class="form-control" type="text"  value="">
                                                <span class="help-block"></span>
                                            </div>
                                    </div>';
                                $q1++;
                            }
                        } else {
                            
                            $boton_disabled1 = 'disabled="disabled"';
                            echo '
                            <div class="alert alert-danger">
                              <strong>
                                Atenci&oacute;n!
                              </strong>
                              No existen Servicios creados o activos para la primera quincena de la empresa <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong>.</span> Revise 
                              <strong>
                                <a href="' . base_url() . "servicio" . "/" . $id_empresa . '">
                                aqu&iacute;</a>
                              </strong>
                            </div>
                            ';
                        }
                        
                            ?>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_servicio_q()"
                    class="btn btn-primary" <?php echo $boton_disabled1;?> > Guardar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_form_quincena2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_quincena2" class="form-horizontal">
                    
                    <input type="hidden" value="" name="mes_q2" id="mes_q2" />
                    <input type="hidden" value="" name="ano_q2" id="ano_q2" />
                    <input type="hidden" value="2" name="id_quincena_q2" id="id_quincena_q2" />
                    <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" />
                    <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda" />
                    

                    <div class="form-body">

                    <?php 

                    if(!empty($mostrar_servicios_segunda_quincena)){
                                                
                        $boton_disabled2 = '';
                        
                        echo '
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Fecha</label>
                            <div class="col-md-8">
                                <input id="fecha_quincena2" name="fecha_quincena2"
                                    class="form-control date-picker" type="text"
                                    data-date-format="dd-mm-yyyy" value="" />
                                    <span class="help-block"></span>
                            </div>
                        </div>';


                        echo '<input type="hidden" value="'.count($mostrar_servicios_segunda_quincena).'" name="cantidad_servicios2" id="cantidad_servicios2" />';

                        $q2=0;
                        foreach ($mostrar_servicios_segunda_quincena as $servicio2q) {
                            $ids2 = $servicio2q->id_servicio;
                            $quincena2 = devuelve_detalle_quincena2($ids, $meses, $año, $ide);
                            $nombre_servicio = devuelve_nombre_servicio($ids2);
                            
                            echo '
                            <input type="hidden" value="'.$ids2.'" name="id_servicio_q2[]" id="id_servicio_q2'.$q2.'" />
                                <div class="form-group">
                                    <label class="control-label col-md-4">Monto '.$nombre_servicio.'</label>
                                        <div class="col-md-8">
                                            <input name="monto_servicio2[]" id="monto_servicio2'.$q2.'" placeholder="Monto '.$nombre_servicio.'" class="form-control" type="text"  value="">
                                            <span class="help-block"></span>
                                        </div>
                                </div>';
                            $q2++;
                        }
                    } else {
                        
                        $boton_disabled2 = 'disabled="disabled"';
                        echo '
                        <div class="alert alert-danger">
                        <strong>
                            Atenci&oacute;n!
                        </strong>
                        No existen Servicios creados o activos para la segunda quincena de la empresa <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong>.</span> Revise 
                        <strong>
                            <a href="' . base_url() . "servicio" . "/" . $id_empresa . '">
                            aqu&iacute;</a>
                        </strong>
                        </div>
                        ';
                    }
                    
                        ?>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_servicio_q2()"
                    class="btn btn-primary" <?php echo $boton_disabled2;?> >Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->