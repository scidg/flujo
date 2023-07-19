<?php

 //esto no es obligatorio pero por un tema de seguridad que nos dice si BASEPATH no esta definido no va a cargar
if (!defined('BASEPATH')){exit('No direct script access allowed');}
//aqui es simple preguntamos si no existe la funcion urls_amigables la podemos crear de lo contrario no se crea
if (!function_exists('rut_check')) {

		function rut_check($rut){

			$rut = preg_replace('/[^k0-9]/i', '', $rut);
		     $dv  = substr($rut, -1);
		     $numero = substr($rut, 0, strlen($rut)-1);
		     $i = 2;
		     $suma = 0;
		     foreach(array_reverse(str_split($numero)) as $v)
		     {
		         if($i==8)
		             $i = 2;
		         $suma += $v * $i;
		         ++$i;
		     }
		     $dvr = 11 - ($suma % 11);

		     if($dvr == 11)
		         $dvr = 0;
		     if($dvr == 10)
		         $dvr = 'K';
		     if($dvr == strtoupper($dv))
		         return true;
		     else
		         return false;


		}
}
?>
