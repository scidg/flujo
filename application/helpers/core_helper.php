<?php
if (!defined('BASEPATH')){exit('No direct script access allowed');}

if (!function_exists('devuelve_monto_adeudado')) {
  function devuelve_monto_adeudado($ide) {
    
    $CI =& get_instance();
    if ($CI->db->get("prestamo")->num_rows()>0){
            $num=$CI->db
            ->select("nombre_empresa")
            ->where("id_empresa",$id_empresa)
            ->get("empresa")
            ->row_array();
            $nombre_empresa= $num["nombre_empresa"];
            return $nombre_empresa;

    }

  }
}
if (!function_exists('devuelve_max_id_subcuenta')) {
  function devuelve_max_id_subcuenta($ide) {
    $CI =& get_instance();
    //$Query = $CI->db->get("empresa ep");
    $Query = $CI->db->select_max("id_subcuenta")
                  //->where("id_empresa_guarda",$ide)
                  ->get("subcuenta s")
                  ->row_array();
                  $id_subcuenta_max = $Query["id_subcuenta"];
                  $id_subcuenta_next = $id_subcuenta_max  + 1;
                  return $id_subcuenta_next;
  }
}

if (!function_exists('devuelve_mes_espanol')) {
  function devuelve_mes_espanol($mes) {

    switch ($mes)
        {
        case "01":
        return "Enero";
        break;

        case "02":
        return "Febrero";
        break;

        case "03":
        return "Marzo";
        break;

        case "04":
        return "Abril";
        break;

        case "05":
        return "Mayo";
        break;

        case "06":
        return "Junio";
        break;

        case "07":
        return "Julio";
        break;

        case "08":
        return "Agosto";
        break;

        case "09":
        return "Septiembre";
        break;

        case "10":
        return "Octubre";
        break;

        case "11":
        return "Noviembre";
        break;

        case "12":
        return "Diciembre";
        break;

        }



  }
}

if (!function_exists('devuelve_nombre_empresa')) {
  function devuelve_nombre_empresa($id_empresa) {

    $CI =& get_instance();
    if ($CI->db->get("empresa")->num_rows()>0){
            $num=$CI->db
            ->select("nombre_empresa")
            ->where("id_empresa",$id_empresa)
            ->get("empresa")
            ->row_array();
            $nombre_empresa= $num["nombre_empresa"];
            return $nombre_empresa;

    }
  }
}

if (!function_exists('eliminar_subcuenta')) {
  function eliminar_subcuenta($id_subcuenta) {

    $CI =& get_instance();
    if ($CI->db->get("subcuenta")->num_rows()>0){
            $num=$CI->db
            ->select("nombre_empresa")
            ->where("id_empresa",$id_empresa)
            ->get("empresa")
            ->row_array();
            $nombre_empresa= $num["nombre_empresa"];
            return $nombre_empresa;

    }
  }
}

if (!function_exists('devuelve_nombre_cuenta')) {
    function devuelve_nombre_cuenta($id_empresa) {
  
      $CI =& get_instance();
      if ($CI->db->get("cuenta")->num_rows()>0){
              $num=$CI->db
              ->select("nombre_cuenta")
              ->where("id_cuenta",$id_empresa)
              ->get("cuenta")
              ->row_array();
              $nombre_cuenta= $num["nombre_cuenta"];
              return $nombre_cuenta;
  
      }
    }
  }

if (!function_exists('devuelve_logo_empresa_header')) {
    function devuelve_logo_empresa_header($id_empresa) {
  
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("logo_empresa")
              ->where("id_empresa",$id_empresa)
              ->get("empresa")
              ->row_array();
              $logo_empresa= $num["logo_empresa"];

              if($logo_empresa){
                $logo_empresa_mostrar = '<img src="'.base_url('upload/'.$logo_empresa).'" class="img-responsive" style="width:5%;height:5%"/>';
              }else{
                $logo_empresa_mostrar = '';
              }

              return $logo_empresa_mostrar;

  
      }
    }
  }

  if (!function_exists('devuelve_logo_empresa_cabecera')) {
    function devuelve_logo_empresa_cabecera($id_empresa) {
  
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("logo_empresa")
              ->where("id_empresa",$id_empresa)
              ->get("empresa")
              ->row_array();
              $logo_empresa= $num["logo_empresa"];
              
              if($logo_empresa){
                $logo_empresa_mostrar = 'src="'.base_url('upload/'.$logo_empresa).'"';
              }else{
                $logo_empresa_mostrar = '';
              }

              return $logo_empresa_mostrar;
  
      }
    }
  }


if (!function_exists('es_casa_central')) {
    function es_casa_central($id_empresa) {
  
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("casa_central")
              ->where("id_empresa",$id_empresa)
              ->get("empresa")
              ->row_array();
              $casa_central= $num["casa_central"];
              return $casa_central;
  
      }
    }
  }

if (!function_exists('es_multiempresa')) {
    function es_multiempresa($id_empresa) {
  
      $CI =& get_instance();
      if ($CI->db->get("tipo_registro_empresa")->num_rows()>0){
              $num=$CI->db
              ->select("tipo_registro_id")
              ->where("id_empresa",$id_empresa)
              ->get("tipo_registro_empresa")
              ->row_array();
              $tipo_registro_id= 0;//$num["tipo_registro_id"];
              return $tipo_registro_id;
  
      }
    }
  }  

if (!function_exists('existe_casa_central')) {
    function existe_casa_central($id_holding) {
      
      $id_holding = 1; //CCC
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("casa_central")
              ->where("casa_central",1)
              ->get("empresa")
              ->row_array();
              $casa_central= $num["casa_central"];
              return $casa_central;
  
      }
    }
  }

if (!function_exists('get_count_empresas')) {
    function get_count_empresas($id_holding) {
      
      $id_holding = 1; //CCC
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("id_empresa, COUNT(id_empresa) as total")
              ->where("id_holding",$id_holding)
              ->get("empresa")
              ->row_array();
              $total= $num["total"];
              return $total;
  
      }
    }
  }  

if (!function_exists('get_id_casa_central')) {
    function get_id_casa_central($id_holding) {
      
      $CI =& get_instance();
      if ($CI->db->get("empresa")->num_rows()>0){
              $num=$CI->db
              ->select("id_empresa")
              ->where("casa_central", 1)
              ->where("id_holding", 1)
              ->get("empresa")
              ->row_array();
              $id_empresa= $num["id_empresa"];
              
             return $id_empresa;
  
      }

    }
  }
if (!function_exists('devuelve_empresas_usuario')) {
    function devuelve_empresas_usuario($id_usuario) {
  
      $CI =& get_instance();
      if ($CI->db->get("usuario_empresa")->num_rows()>0){
              $num=$CI->db
              ->select("id_empresa")
              ->where("id_usuario",$id_usuario)
              ->get("usuario_empresa")
              ->result();
              $count=$num;
              return count($count);
  
      }
    }
  }
  
if (!function_exists('devuelve_rut_existente')) {
  function devuelve_rut_existente($r) {

    $CI =& get_instance();
    if ($CI->db->get("empresa")->num_rows()>0){
            $num=$CI->db
            ->select("rut_empresa")
            ->where("rut_empresa",$r)
            ->get("empresa")
            ->row_array();
            $rut_empresa= $num["rut_empresa"];
            if(!empty($rut_empresa)){
              return 1;
            }else{
              return 0;
            }

    }
  }
}

if (!function_exists('devuelve_quincena')) {
    function devuelve_quincena($ide,$meses,$año,$idq){
        
      if(is_company_mother($ide)){

        $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_quincena")
              //->where("id_empresa_guarda",$ide)
              ->where("id_mes",$meses)
              ->where("id_ano",$año)
              ->where("id_quincena",$idq)
              ->get("venta")
              ->row_array();
              $monto_quincena1 = $num["monto_quincena"];
              $monto_quincena2 = $monto_quincena1;
              if( (!empty($monto_quincena1)) || (!empty($monto_quincena2)) ){
                return array($monto_quincena1,$monto_quincena2);
              }else{
                return array(0,0);
              }
      }

      }else{

      $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_quincena")
              ->where("id_empresa_guarda",$ide)
              ->where("id_mes",$meses)
              ->where("id_ano",$año)
              ->where("id_quincena",$idq)
              ->get("venta")
              ->row_array();
              $monto_quincena1 = $num["monto_quincena"];
              $monto_quincena2 = $monto_quincena1;
              if( (!empty($monto_quincena1)) || (!empty($monto_quincena2)) ){
                return array($monto_quincena1,$monto_quincena2);
              }else{
                return array(0,0);
              }
      }
    }

    }
  }

  if (!function_exists('devuelve_quincena_new')) {
    function devuelve_quincena_new($ide,$meses,$año,$idq){
  
      $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_quincena")
              ->where("id_empresa_guarda",$ide)
              ->where("id_mes",$meses)
              ->where("id_ano",$año)
              ->where("id_quincena",$idq)
              ->get("venta")
              ->row_array();
              $monto_quincena1 = $num["monto_quincena"];
              $monto_quincena2 = $monto_quincena1;
              if( (!empty($monto_quincena1)) || (!empty($monto_quincena2)) ){
                return array($monto_quincena1,$monto_quincena2);
              }else{
                return array(0,0);
              }
      }
    }
  }

  if (!function_exists('devuelve_detalle_quincena1')) {
    function devuelve_detalle_quincena1($ids, $meses, $año, $ide){
  
      $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num1=$CI->db
              ->select("monto_quincena")
              ->where("id_servicio",$ids)
              ->where("id_quincena",1)
              ->where("id_mes",$meses)
              ->where("id_ano",$año)              
              ->where("id_empresa_guarda",$ide)
              ->get("venta")
              ->row_array();
              $monto_quincena1 = $num1["monto_quincena"];
              return $monto_quincena1;

      }
    }
  }  

  if (!function_exists('devuelve_cuotas_pendientes')) {
    function devuelve_cuotas_pendientes($idc, $ids){
  
      $CI =& get_instance();
      if ($CI->db->get("movimiento")->num_rows()>0){
              $num1=$CI->db
              //->select("fecha_ingreso")
              ->select("movimiento.id_movimiento, COUNT(id_tipo_estado_movimiento) as total")
              ->join('movimiento_detalle md', 'movimiento.id_movimiento = md.id_movimiento')
              ->where("id_cuenta",$idc)
              ->where("id_subcuenta",$ids)
              ->where("id_tipo_estado_movimiento", 2)
              ->get("movimiento")
              ->row_array();
              $id_cuenta = $num1["total"];
              return $id_cuenta;

      }
    }
  }  

  if (!function_exists('devuelve_cuotas_canceladas')) {
    function devuelve_cuotas_canceladas($idc, $ids){
  
      $CI =& get_instance();
      if ($CI->db->get("movimiento")->num_rows()>0){
              $num1=$CI->db
              //->select("fecha_ingreso")
              ->select("movimiento.id_movimiento, COUNT(id_tipo_estado_movimiento) as total")
              ->join('movimiento_detalle md', 'movimiento.id_movimiento = md.id_movimiento')
              ->where("id_cuenta",$idc)
              ->where("id_subcuenta",$ids)
              ->where("id_tipo_estado_movimiento", 1)
              ->get("movimiento")
              ->row_array();
              $id_cuenta = $num1["total"];
              return $id_cuenta;

      }
    }
  }  


  if (!function_exists('devuelve_cantidad_mantenedor')) {
    function devuelve_cantidad_mantenedor($man,$ide) {

      $CI =& get_instance();

      if($man == 'cuenta' || $man == 'subcuenta' || $man == 'servicio'){
        
        if(!es_casa_central($ide)){
          if ($CI->db->get($man)->num_rows()>0){
                  $num=$CI->db
                  ->select("id_".$man.", COUNT(id_".$man.") as total")
                  ->where("id_empresa_guarda",$ide)
                  ->get($man)
                  ->row_array();
                  $total= $num["total"];
                  return $total;
          }else{
            $total= 0;
            return $total;
          }

        }else{

          if ($CI->db->get($man)->num_rows()>0){
            $num=$CI->db
            ->select("id_".$man.", COUNT(id_".$man.") as total")
            //->join('empresa e', $man.'.id_empresa_guarda = e.id_empresa_guarda1')
            //->where("id_holding",1)
            ->get($man)
            ->row_array();
            $total= $num["total"];
            return $total;
          }else{
            $total= 0;
            return $total;
          }
          
        }
      
      
      }else if($man == 'prestamo'){
        if(!es_casa_central($ide)){
          if ($CI->db->get($man)->num_rows()>0){
                  $num=$CI->db
                  ->select("id_".$man.", COUNT(id_".$man.") as total")
                  ->where("id_empresa",$ide)
                  ->get($man)
                  ->row_array();
                  $total= $num["total"];
                  return $total;
          }else{
            $total= 0;
            return $total;
          }

        }else{

          if ($CI->db->get($man)->num_rows()>0){
            $num=$CI->db
            ->select("id_".$man.", COUNT(id_".$man.") as total")
            //->join('empresa e', $man.'.id_empresa_guarda = e.id_empresa_guarda1')
            //->where("id_holding",1)
            ->get($man)
            ->row_array();
            $total= $num["total"];
            return $total;
          }else{
            $total= 0;
            return $total;
          }
          
        }

      }else if($man == 'usuario'){
      
        if(!es_casa_central($ide)){
          if ($CI->db->get($man)->num_rows()>0){
            $num=$CI->db
            ->select("ue.id_".$man.", COUNT(ue.id_".$man.") as total")
            ->join('usuario_empresa ue', $man.'.id_usuario = ue.id_usuario')
            ->where("ue.id_empresa",$ide)
            ->get($man)
            ->row_array();
            $total= $num["total"];
            return $total;
            }else{
              $total= 0;
              return $total;
            }
          }else{

            if ($CI->db->get($man)->num_rows()>0){
              $num=$CI->db
              ->select("usuario.id_".$man.", COUNT(usuario.id_".$man.") as total")
              //->join('usuario_empresa ue', $man.'.id_usuario = ue.id_usuario')
              //->where("ue.id_empresa",$ide)
              ->get($man)
              ->row_array();
              $total= $num["total"];
              return $total;
              }else{
                $total= 0;
                return $total;
              }

          }
      }

    }
  }  

  if (!function_exists('devuelve_simbolo_moneda')) {
    function devuelve_simbolo_moneda($ids){
  
      $CI =& get_instance();
      if ($CI->db->get("moneda")->num_rows()>0){
              $num1=$CI->db
              ->select("simbolo_moneda")
              ->where("id_moneda",$ids)
              ->get("moneda")
              ->row_array();
              $nombre_servicio = $num1["simbolo_moneda"];
              return $nombre_servicio;

      }
    }
  }  

  if (!function_exists('devuelve_posicion_moneda')) {
    function devuelve_posicion_moneda($ids){
  
      $CI =& get_instance();
      if ($CI->db->get("moneda")->num_rows()>0){
              $num1=$CI->db
              ->select("posicion_moneda")
              ->where("id_moneda",$ids)
              ->get("moneda")
              ->row_array();
              $nombre_servicio = $num1["posicion_moneda"];
              return $nombre_servicio;

      }
    }
  }  


  if (!function_exists('devuelve_nombre_servicio')) {
    function devuelve_nombre_servicio($ids){
  
      $CI =& get_instance();
      if ($CI->db->get("servicio")->num_rows()>0){
              $num1=$CI->db
              ->select("nombre_servicio")
              ->where("id_servicio",$ids)
              ->get("servicio")
              ->row_array();
              $nombre_servicio = $num1["nombre_servicio"];
              return $nombre_servicio;

      }
    }
  }  

  if (!function_exists('devuelve_titulo_modulo')) {
    function devuelve_titulo_modulo($idm){
  
      $CI =& get_instance();
      if ($CI->db->get("modulo")->num_rows()>0){
              $num1=$CI->db
              ->select("titulo_modulo")
              ->where("id_modulo",$idm)
              ->get("modulo")
              ->row_array();
              $titulo_modulo = $num1["titulo_modulo"];
              return $titulo_modulo;

      }
    }
  }  

  if (!function_exists('devuelve_uf')) {
    function devuelve_uf($fecha){
      
      $CI =& get_instance();
      if ($CI->db->get("indicador_economico")->num_rows()>0){
              $num1=$CI->db
              ->select("valor")
              ->where("fecha",$fecha)
              ->where("nombre",'uf')
              ->get("indicador_economico")
              ->row_array();

              //HAmestica: Resolución valores vacios
              if(!isset($num1["valor"])){
                $valor_uf = 0;
              }else{
                $valor_uf = $num1["valor"];
              }
              
              return $valor_uf;

      }else{
        $valor_uf = 0;
        return $valor_uf;
      }
    }
  }  

  if (!function_exists('devuelve_dolar')) {
    function devuelve_dolar($fecha){
  
      $CI =& get_instance();
      if ($CI->db->get("indicador_economico")->num_rows()>0){
              $num1=$CI->db
              ->select("valor")
              ->where("fecha",$fecha)
              ->where("nombre",'dolar')
              ->get("indicador_economico")
              ->row_array();
              
              //HAmestica: Resolución valores vacios
              if(!isset($num1["valor"])){
                $valor_dolar = 0;
              }else{
                $valor_dolar = $num1["valor"];
              }
              
              return $valor_dolar;

      }else{
        $valor_dolar = 0;
        return $valor_dolar;
      }
    }
  } 

  if (!function_exists('devuelve_euro')) {
    function devuelve_euro($fecha){
  
      $CI =& get_instance();
      if ($CI->db->get("indicador_economico")->num_rows()>0){
              $num1=$CI->db
              ->select("valor")
              ->where("fecha",$fecha)
              ->where("nombre",'euro')
              ->get("indicador_economico")
              ->row_array();

              //HAmestica: Resolución valores vacios
              if(!isset($num1["valor"])){
                $valor_euro = 0;
              }else{
                $valor_euro = $num1["valor"];
              }
              
              return $valor_euro;

      }else{
        $valor_euro = 0;
        return $valor_euro;
      }
    }
  }  

  if (!function_exists('devuelve_utm')) {
    function devuelve_utm($fecha){
  
      $CI =& get_instance();
      if ($CI->db->get("indicador_economico")->num_rows()>0){
              $num1=$CI->db
              ->select("valor")
              ->where("fecha",$fecha)
              ->where("nombre",'utm')
              ->get("indicador_economico")
              ->row_array();
              
              //HAmestica: Resolución valores vacios
              if(!isset($num1["valor"])){
                $valor_utm = 0;
              }else{
                $valor_utm = $num1["valor"];
              }
              
              return $valor_utm;

      }else{
        $valor_utm = 0;
        return $valor_utm;
      }
    }
  } 


  if (!function_exists('devuelve_titulo_submodulo')) {
    function devuelve_titulo_submodulo($idm){
  
      $CI =& get_instance();
      if ($CI->db->get("submodulo")->num_rows()>0){
              $num1=$CI->db
              ->select("titulo_submodulo")
              ->where("id_submodulo",$idm)
              ->get("submodulo")
              ->row_array();
              $titulo_submodulo = $num1["titulo_submodulo"];
              return $titulo_submodulo;

      }
    }
  }  


  if (!function_exists('devuelve_detalle_quincena2')) {
    function devuelve_detalle_quincena2($ids, $meses, $año, $ide){
  
      $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
        $num1=$CI->db
        ->select("monto_quincena")
        ->where("id_servicio",$ids)
        ->where("id_quincena",2)
        ->where("id_mes",$meses)
        ->where("id_ano",$año)              
        ->where("id_empresa_guarda",$ide)
        ->get("venta")
        ->row_array();
        $monto_quincena1 = $num1["monto_quincena"];
        return $monto_quincena1;

}
    }
  }    
  
if (!function_exists('check_rut')) {

  function check_rut($r)
  {
    if((!$r) or (is_array($r)))
        return false; /* Hace falta el rut */

    if(!$r = preg_replace('|[^0-9kK]|i', '', $r))
        return false; /* Era código basura */

    if(!((strlen($r) == 8) or (strlen($r) == 9)))
        return false; /* La cantidad de carácteres no es válida. */

    $v = strtoupper(substr($r, -1));
    if(!$r = substr($r, 0, -1))
        return false;

    if(!((int)$r > 0))
        return false; /* No es un valor numérico */

    $x = 2; $s = 0;
    for($i = (strlen($r) - 1); $i >= 0; $i--){
        if($x > 7)
            $x = 2;
        $s += ($r[$i] * $x);
        $x++;
    }
    $dv=11-($s % 11);
    if($dv == 10)
        $dv = 'K';
    if($dv == 11)
        $dv = '0';
    if($dv == $v)
        return number_format($r, 0, '', '.').'-'.$v; /* Formatea el RUT */
    return false;

  }

}



if (!function_exists('devuelve_cant_lunes')) {

    function devuelve_cant_lunes($month,$year)
    {
       

        $day="01";
        $primerDia=date("Y-m-d",mktime(0,0,0,$month,$day,$year));
        $fechaInicio=strtotime($primerDia);
        $dialunes = 0;
        $rango = 1;
        $mes_fi = date ("m", $fechaInicio);
        $año_fi = date ("Y", $fechaInicio);




for ($i=$mes_fi;$i<$mes_fi+$rango;$i++){
  
    $meses=date('m', mktime(0, 0, 0, $i, 1, $mes_fi ) );

    $año=date('Y', mktime(0, 0, 0, $i, 1, $año_fi ) );

    $timestamp = strtotime( "01-".$meses."-".$año );
    $diasdelmes = date( "t", $timestamp );



                for ($dias=1;$dias<=$diasdelmes;$dias++){

                  $timestamp_dias = strtotime( $dias."-".$meses."-".$año );
                  $numerodia = date('N', $timestamp_dias);
                  $numerosemana = date ("W", $timestamp_dias);

                  
                  if($numerodia==1){
                      $dialunes++;

                  }
                  
                }

}



return $dialunes;


    }
}

if (!function_exists('get_primera_ultima_semana')) {

    function get_primera_ultima_semana($year,$month)
    {
        # Obtenemos el ultimo dia del mes
        $ultimoDiaMes=date("t",mktime(0,0,0,$month,1,$year));

        # Obtenemos la semana del primer dia del mes
        $primeraSemana=date("W",mktime(0,0,0,$month,1,$year));

        # Obtenemos la semana del ultimo dia del mes
        $ultimaSemana=date("W",mktime(0,0,0,$month,$ultimoDiaMes,$year));


        # Devolvemos en un array los dos valores
        return array($primeraSemana,$ultimaSemana);
    }
}

if (!function_exists('get_ultimo_dia_domngo')) {

    function get_ultimo_dia_domngo($year,$week)
    {

    $timestamp=mktime(0, 0, 0, 1, 1, $year);

    $timestamp+=$week*7*24*60*60;

    $ultimoDia=$timestamp-date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60;

    $primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);

    return date("Y-m-d",$ultimoDia);

    }
}


if (!function_exists('get_lunes_domingo')) {

    function get_lunes_domingo($year,$month,$day)
    {

        # Obtenemos el numero de la semana

        $semana=date("W",mktime(0,0,0,$month,$day,$year));


        # Obtenemos el día de la semana de la fecha dada

        $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));


        # el 0 equivale al domingo...

        if($diaSemana==0)

            $diaSemana=7;


        # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes

        $primerDia=date("d-m-Y",mktime(0,0,0,$month,$day-$diaSemana+1,$year));


        # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo

        $ultimoDia=date("d-m-Y",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));

        return array($semana,$primerDia,$ultimoDia);

    }
}





?>
