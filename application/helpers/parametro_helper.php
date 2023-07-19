<?php
if (!defined('BASEPATH')){exit('No direct script access allowed');}

//obtiene parametro fecha ingreso, manual o automatica
if (!function_exists('devuelve_parametro_fi')) {
  function devuelve_parametro_fi($id_empresa) {
    $CI =& get_instance();
    if ($CI->db->get("empresa_parametro ep")->num_rows()>0){
            $num=$CI->db
            ->select("*")
            ->join('parametro_detalle pd', 'pd.id_parametro_detalle = ep.id_parametro_detalle')
            ->join('parametro p', 'p.id_parametro = pd.id_parametro')
            ->where("id_empresa",$id_empresa)
            ->where("p.grupo_parametro",2)
            ->get("empresa_parametro ep")
            ->row_array();
            $parametro_fecha= $num["opcion_parametro"];
            return $parametro_fecha;

    }
  }
}

//obtiene parametro tipo de calendario diario a mostrar.
if (!function_exists('devuelve_parametro_cal')) {
  function devuelve_parametro_cal($id_empresa) {
    $CI =& get_instance();
    if ($CI->db->get("empresa_parametro ep")->num_rows()>0){
            $num=$CI->db
            ->select("*")
            ->join('parametro_detalle pd', 'pd.id_parametro_detalle = ep.id_parametro_detalle')
            ->join('parametro p', 'p.id_parametro = pd.id_parametro')
            ->where("id_empresa",$id_empresa)
            ->where("p.grupo_parametro",1)
            ->get("empresa_parametro ep")
            ->row_array();
            $parametro_cal= $num["opcion_parametro"];
            return $parametro_cal;

    }
  }
}

//obtiene parametro cantidad de meses a mostrar en el tipo de calendario.
if (!function_exists('devuelve_parametro_mes')) {
  function devuelve_parametro_mes($id_empresa) {
    $CI =& get_instance();
    if ($CI->db->get("empresa_parametro ep")->num_rows()>0){
            $num=$CI->db
            ->select("*")
            ->join('parametro_detalle pd', 'pd.id_parametro_detalle = ep.id_parametro_detalle')
            ->join('parametro p', 'p.id_parametro = pd.id_parametro')
            ->where("id_empresa",$id_empresa)
            ->where("p.grupo_parametro",3)
            ->get("empresa_parametro ep")
            ->row_array();
            $parametro_cal= $num["opcion_parametro"];
            return $parametro_cal;

    }
  }
}

if (!function_exists('get_ultimo_eo_orden')) {
  function get_ultimo_eo_orden() {
    $CI =& get_instance();
    //$Query = $CI->db->get("empresa ep");
    $Query = $CI->db->select_max("orden")
                  ->where("id_holding" , 1)
                  ->get("empresa_orden eo")
                  ->row_array();
                  $orden_max = $Query["orden"];
                  $orden_next = $orden_max  + 1;
                  return $orden_next;
  }
}

if (!function_exists('get_ultimo_eo_mostrar')) {
  function get_ultimo_eo_mostrar() {
    $CI =& get_instance();
    //$Query = $CI->db->get("empresa ep");
    $Query = $CI->db->select_max("mostrar")
                  ->where("id_holding" , 1)
                  ->get("empresa_orden eo")
                  ->row_array();
                  $mostrar_max = $Query["mostrar"];
                  $mostrar_next = $mostrar_max  + 1;
                  return $mostrar_next;
  }
}

if (!function_exists('get_all_company')) {
  function get_all_company() {
    $CI =& get_instance();
    //$Query = $CI->db->get("empresa ep");
    $Query = $CI->db->select("*")
                  ->join('empresa_orden eo', 'ep.id_empresa = eo.id_empresa')
                  ->where("casa_central",0)
                  ->order_by("eo.orden", "asc")
                  ->get("empresa ep");
                  
                  
    if ($Query->num_rows()>0){
      return $Query->result();
    }
  }
}

/*$this->db->select('empresa.id_empresa, casa_central,rut_empresa,nombre_empresa,logo_empresa,eo.orden,eo.mostrar,telefono_empresa,direccion_empresa,empresa.estado');
//$this->db->order_by('e.orden', 'asc');
$this->db->join('empresa_orden eo', 'empresa.id_empresa = eo.id_empresa');
$this->db->where('empresa.id_empresa_guarda',$id_empresa);
$this->db->order_by('eo.orden', 'asc');*/


if (!function_exists('is_company_mother')) {
  function is_company_mother($id_empresa) {
    $CI =& get_instance();
    $Query = $CI->db->select("*")->where("id_empresa",$id_empresa)->get("empresa ep");
    if ($Query->num_rows()>0){
      $arg = $Query->row_array();
      return isset($arg['casa_central']) ? boolval($arg['casa_central']) : false;
    }
    return false;
  }
}
?>
