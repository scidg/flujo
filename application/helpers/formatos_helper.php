<?php

 //esto no es obligatorio pero por un tema de seguridad que nos dice si BASEPATH no esta definido no va a cargar
if (!defined('BASEPATH')){exit('No direct script access allowed');}

//aqui es simple preguntamos si no existe la funcion urls_amigables la podemos crear de lo contrario no se crea
if (!function_exists('formato_precio')) {

	function formato_precio($simbolo="",$valor, $posicion) {

        if(!empty($simbolo)){
            
            if($posicion == 'first'){
                return $simbolo." ".number_format( ($valor * 1), 0, ",", ".");
            }else if($posicion == 'last'){
                return number_format( ($valor * 1), 0, ",", ".")." ".$simbolo;               
            }

        }else{

            return number_format( ($valor * 1), 0, ",", ".");
        }
	}

}

if (!function_exists('fecha_espanol')) {

	function fecha_espanol($fecha) {
        if(!empty($fecha)){
            list($a,$m,$d) = explode("-", $fecha);
            $fecha_espanol = $d."-".$m."-".$a;
            return $fecha_espanol;
        }else if($fecha == '00-00-0000'){
            $fecha_espanol = '0000-00-00';
            return $fecha_espanol;
        }else{
            $fecha_espanol = '0000-00-00';
            return $fecha_espanol;
        }
    }

}

if (!function_exists('fecha_espanol2')) {

	function fecha_espanol2($fecha) {
        if(!empty($fecha)){
            list($d,$m,$a) = explode("-", $fecha);
            $fecha_espanol = $d."/".$m."/".$a;
            return $fecha_espanol;
        }else if($fecha == '00-00-0000'){
            $fecha_espanol = '0000-00-00';
            return $fecha_espanol;
        }else{
            $fecha_espanol = '0000-00-00';
            return $fecha_espanol;
        }
    }

}

if (!function_exists('fecha_ingles')) {

	function fecha_ingles($fecha) {
        if(!empty($fecha)){
            list($d,$m,$y) = explode("-", $fecha);
            $fecha_ingles = $y."-".$m."-".$d;
            return $fecha_ingles;
        }else if($fecha == '00-00-0000'){
            $fecha_ingles = '0000-00-00';
            return $fecha_ingles;
        }else{
            $fecha_ingles = '0000-00-00';
            return $fecha_ingles;
        }
    }

}


if (!function_exists('formato_rut')) {

	function formato_rut($rut_param){

        if(!empty($rut_param)){
            $rut_param = preg_replace('/[^k0-9]/i', '', $rut_param);
            $parte4 = substr($rut_param, -1); // seria solo el numero verificador
            $parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq
            $parte2 = substr($rut_param, -7,3);
            $parte1 = substr($rut_param, 0,-7);

            return $parte1.".".$parte2.".".$parte3."-".$parte4;
        }
	}
}

if (!function_exists('formato_nombre_tabla')) {

	function formato_nombre_tabla($noms) {

	    $nombre = strtoupper($noms);
        if (strlen($nombre) > 25){
			$nombre = substr($nombre, 0, 25) . "...";
		}

        $nombre_f = $nombre;
		return $nombre_f;
    }

}

if (!function_exists('formato_color_estado')) {

	function formato_color_estado($estado){

		if($estado =='1'){

			$estado_f = '<span class="label label-sm label-danger">Pendiente</span>';

		}else if($estado=='2'){

			$estado_f = '<span class="label label-sm label-warning">En validacion</span>';

		}else if($estado=='3'){

			$estado_f = '<span class="label label-sm label-success">Pagado</span>';

		}

		return $estado_f;
	}

}

if (!function_exists('nombre_estado')) {

	function nombre_estado($estado){

		if($estado =='1'){

			$estado_f = 'Pendiente';

		}else if($estado=='2'){

			$estado_f = 'En validacion';

		}else if($estado=='3'){

			$estado_f = 'Pagado';

		}

		return $estado_f;
	}

}


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();

        $CI->load->library('email');

        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $CI->email->initialize($config);

        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;

        $CI = setProtocol();

        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();

        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

if (!function_exists('select_last')) {

    function select_last() {

             $CI= & get_instance();

            $num = $CI->db->select_max("id_cliente")->get("Table_OV_Cliente")->row_array();

            $fecha= $num["id_cliente"] + 1;

            return $fecha;

    }

}

?>
