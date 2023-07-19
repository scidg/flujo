<?php

 //esto no es obligatorio pero por un tema de seguridad que nos dice si BASEPATH no esta definido no va a cargar
if (!defined('BASEPATH')){exit('No direct script access allowed');}
//aqui es simple preguntamos si no existe la funcion urls_amigables la podemos crear de lo contrario no se crea
if (!function_exists('select_last')) {

    function select_last() {

             $CI= & get_instance(); 

            $num = $CI->db->select_max("id_cliente")->get("Table_OV_Cliente")->row_array();

            $fecha= $num["id_cliente"] + 1;

            return $fecha;

    }

}


?>