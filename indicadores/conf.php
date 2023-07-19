<?php

// DB CREDENCIALES DE USUARIO.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','precisa2020');
define('DB_NAME','flowbox');

try
{
// Ejecutamos las variables y aplicamos UTF8
$connect = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error Conexion: " . $e->getMessage());
}

function fecha_español($fecha) {
    if(!empty($fecha)){
        list($f) = explode("T", $fecha);
        $fecha_español = $f;
        return $fecha_español;
    }else if($fecha == '00-00-0000'){
        $fecha_español = '0000-00-00';
        return $fecha_español;
    }else{
        $fecha_español = '0000-00-00';
        return $fecha_español;
    }
  }

?>