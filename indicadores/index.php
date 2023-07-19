<?php
include_once('conf.php');

//$apiUrl = 'https://mindicador.cl/api/'.$indicador.'/'.$hoy;
$apiUrl = 'https://mindicador.cl/api/';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents

if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}
     
$dailyIndicators = json_decode($json);

//PARA NADA OPTIMO... FILO!
//INICIO UF

$valor_uf = $dailyIndicators->uf->valor;
$fecha_uf = fecha_español($dailyIndicators->uf->fecha);

$query = $connect->prepare("INSERT INTO indicador_economico (nombre, fecha, valor, estado, fecha_creacion) VALUES (?,?,?,?,NOW())");

$nombre = 'uf';
$fecha = $fecha_uf;
$valor = $valor_uf;
$estado = '1';

$result = $query->execute([$nombre, $fecha, $valor, $estado]);


if($result){ echo "UF guardado con éxito."."<br>"; }
else{ 
echo "Error al guardar UF:";
$arr = $query->errorInfo();
print_r($arr);
}

//FIN UF


//INICIO DOLAR

$valor_dolar = $dailyIndicators->dolar->valor;
$fecha_dolar = fecha_español($dailyIndicators->dolar->fecha);

$query = $connect->prepare("INSERT INTO indicador_economico (nombre, fecha, valor, estado, fecha_creacion) VALUES (?,?,?,?,NOW())");

$nombre = 'dolar';
$fecha = $fecha_dolar;
$valor = $valor_dolar;
$estado = '1';

$result = $query->execute([$nombre, $fecha, $valor, $estado]);


if($result){ echo "DOLAR guardado con éxito."."<br>"; }
else{ 
echo "Error al guardar DOLAR:";
$arr = $query->errorInfo();
print_r($arr);
}

//FIN DOLAR

//INICIO EURO

$valor_euro = $dailyIndicators->euro->valor;
$fecha_euro = fecha_español($dailyIndicators->euro->fecha);

$query = $connect->prepare("INSERT INTO indicador_economico (nombre, fecha, valor, estado, fecha_creacion) VALUES (?,?,?,?,NOW())");

$nombre = 'euro';
$fecha = $fecha_euro;
$valor = $valor_euro;
$estado = '1';

$result = $query->execute([$nombre, $fecha, $valor, $estado]);


if($result){ echo "EURO guardado con éxito."."<br>"; }
else{ 
echo "Error al guardar EURO:";
$arr = $query->errorInfo();
print_r($arr);
}

//FIN EURO

//INICIO UTM

$valor_utm = $dailyIndicators->utm->valor;
$fecha_utm = fecha_español($dailyIndicators->utm->fecha);

$query = $connect->prepare("INSERT INTO indicador_economico (nombre, fecha, valor, estado, fecha_creacion) VALUES (?,?,?,?,NOW())");

$nombre = 'utm';
$fecha = $fecha_utm;
$valor = $valor_utm;
$estado = '1';

$result = $query->execute([$nombre, $fecha, $valor, $estado]);


if($result){ echo "UTM guardado con éxito."."<br>"; }
else{ 
echo "Error al guardar UTM:";
$arr = $query->errorInfo();
print_r($arr);
}

//FIN UTM
?>