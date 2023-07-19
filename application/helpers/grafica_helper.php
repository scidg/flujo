<?php
if (!defined('BASEPATH')){exit('No direct script access allowed');}

if (!function_exists('devuelve_este_mes')) {
  function devuelve_este_mes($estemes,$ide) {
    
    $CI =& get_instance();
    if ($CI->db->get("venta")->num_rows()>0){
            $num=$CI->db
            ->select_sum("monto_quincena")
            ->where("id_empresa_guarda",$ide)
            ->where("id_mes",$estemes)
            ->get("venta")
            ->row_array();
            $monto_quincena= $num["monto_quincena"];
     

    }else{
      $monto_quincena= 0;
    }

    if ($CI->db->get("tributario")->num_rows()>0){
            $num=$CI->db
            ->select_sum("monto_tributario")
            ->where("id_empresa_guarda",$ide)
            ->where("id_mes",$estemes)
            ->get("tributario")
            ->row_array();
            $monto_tributario= $num["monto_tributario"];
            

    }else{
      $monto_tributario= 0;
    }

    return array($monto_quincena,$monto_tributario);

  }
}

if (!function_exists('devuelve_total_ano')) {
  function devuelve_total_ano($ide,$ano) {
    
    if($ide){

      $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_quincena")
              ->where("id_empresa_guarda",$ide)
              ->where("id_ano",$ano)
              ->get("venta")
              ->row_array();
              $monto_quincena= $num["monto_quincena"];
      
      }else{
        $monto_quincena= 0;
      }

      return array($monto_quincena);

  }else{

    $CI =& get_instance();
      if ($CI->db->get("venta")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_quincena")
              //->where("id_empresa_guarda",$ide)
              ->where("id_ano",$ano)
              ->get("venta")
              ->row_array();
              $monto_quincena= $num["monto_quincena"];
      
      }else{
        $monto_quincena= 0;
      }

      return array($monto_quincena);

  }

}
}


if (!function_exists('devuelve_tributario_ano')) {
  function devuelve_tributario_ano($ide,$ano) {
    
    if($ide){

      $CI =& get_instance();
      if ($CI->db->get("tributario")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_tributario")
              ->where("id_empresa_guarda",$ide)
              ->where("id_ano",$ano)
              ->get("tributario")
              ->row_array();
              $monto_tributario= $num["monto_tributario"];
      
      }else{
        $monto_tributario= 0;
      }

      return array($monto_tributario);

  }else{

    $CI =& get_instance();
      if ($CI->db->get("tributario")->num_rows()>0){
              $num=$CI->db
              ->select_sum("monto_tributario")
              //->where("id_empresa_guarda",$ide)
              ->where("id_ano",$ano)
              ->get("tributario")
              ->row_array();
              $monto_tributario= $num["monto_tributario"];
      
      }else{
        $monto_tributario= 0;
      }

      return array($monto_tributario);

  }

}
}

if (!function_exists('devuelve_ingresos_valor_lunes')) {
  function devuelve_ingresos_valor_lunes($lun,$dom,$ide) {
    $CI =& get_instance();
      if($CI->db->get("movimiento m")->num_rows()>0){
            
            $num=$CI->db
            ->select_sum("monto")
            ->select_sum("monto_cuenta_banco")
            ->select_sum("monto_cuenta_prestamo")
            ->join('movimiento_detalle md', 'm.id_movimiento = md.id_movimiento')
            ->where("md.fecha_ingreso  >=",$lun)
            ->where("md.fecha_ingreso  <=",$dom)
            ->where("m.id_empresa_guarda",$ide)
            ->where("m.id_tipo_movimiento",1)
            ->where("md.id_tipo_estado_movimiento",2)
            ->get("movimiento m")
            ->row_array();
            $montox= $num["monto"];
            if($montox){
              return $montox;
            }else{
              if($CI->db->get("venta v")->num_rows()>0){
                $numv=$CI->db
                ->select_sum("monto_quincena")
                ->where("v.lunes_quincena  >=",$lun)
                ->where("v.lunes_quincena  <=",$dom)
                ->where("v.id_empresa_guarda",$ide)
                ->get("venta v")
                ->row_array();
                $monto_quincena= $numv["monto_quincena"];
                if($monto_quincena){
                  return $monto_quincena;
                }else{
                  $montox = 0;
              return $montox;              
                }
              }

              
            }
    }else{
      $montox = 0;
      return $montox;
    }

  }
}

if (!function_exists('devuelve_egresos_valor_lunes')) {
  function devuelve_egresos_valor_lunes($lun,$dom,$ide) {
    $CI =& get_instance();
    if ($CI->db->get("movimiento m")->num_rows()>0){
            $num=$CI->db
            ->select_sum("monto")
            ->select_sum("monto_cuenta_banco")
            ->select_sum("monto_cuenta_prestamo")
            ->join('movimiento_detalle md', 'm.id_movimiento = md.id_movimiento')
            ->where("md.fecha_ingreso  >=",$lun)
            ->where("md.fecha_ingreso  <=",$dom)
            ->where("m.id_empresa_guarda",$ide)
            ->where("m.id_tipo_movimiento",2)
            ->where("md.id_tipo_estado_movimiento",2)
            ->get("movimiento m")
            ->row_array();
            $montox= $num["monto"];
            if($montox){
              return $montox;
            }else{

              
              $montox = 0;
              return $montox;

            }
    
    }else{
      
      $montox = 0;
      return $montox;
    }

  }
}