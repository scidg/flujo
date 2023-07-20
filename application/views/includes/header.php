<?php

$url = $this->uri->uri_string();
//echo ">>".$id_empresa;

if(!empty($id_empresa_usuario)){
  $id_empresa = $id_empresa_usuario;
}

$aquiestoy = '';
$id_holding = 1;

//consolidado/resumen
$inf=0;
$_SESSION['inf_ver']=0;
$_SESSION['inf_des']=0;
$_SESSION['his_agr_trib']=0;

//historico
$his=0;

//ingreso
$ing=0;
$ing_mov=0;
$_SESSION['ing_mov_ver']=0;
$_SESSION['ing_mov_cli']=0;
$_SESSION['ing_mov_agr']=0;
$_SESSION['ing_mov_edi']=0;
$_SESSION['ing_mov_eli']=0;
$_SESSION['ing_mov_qui']=0;
//$_SESSION['ing_mov_q2']=0;
$ing_lis=0;
$_SESSION['ing_lis_ver']=0;
$_SESSION['ing_lis_act']=0;

//egreso
$egr=0;
$egr_mov=0;
$_SESSION['egr_mov_ver']=0;
$_SESSION['egr_mov_cli']=0;
$_SESSION['egr_mov_agr']=0;
$_SESSION['egr_mov_edi']=0;
$_SESSION['egr_mov_eli']=0;
$_SESSION['egr_gas_agr']=0;
$egr_lis=0;
$_SESSION['egr_lis_ver']=0;
$_SESSION['egr_lis_act']=0;

//malla_societaria
$mal=0;

//mantenedores
$man=0;
$man_cue=0;
$man_sub=0;
$man_emp=0;
$man_suc=0;

//$parametro_per=0;
$man_ser=0;
$man_ban=0;
$man_con=0;
$man_pla=0;
$man_tip=0;
$man_mon=0;
$man_lin=0;
$man_iva=0;
$man_usu=0;

//prestamo
$pre=0;

if(count($mostrar_empresas_usuario) > 1){
  $class_icon_empresas = "icon-tags";
}else{
  $class_icon_empresas = "icon-tag";
}



if(!empty($permisos_usuario)){

    $val_select = array();

    foreach($permisos_usuario as $valor){
      array_push($val_select, $valor->codigo_permiso);
    }
    //REAL PAJA, CAMBIARLO ALGUN DIA...
    in_array(100,$val_select)?$inf=1:$inf=0;
    in_array(101,$val_select)?$_SESSION['inf_ver']=1:$_SESSION['inf_ver']=0;
    in_array(102,$val_select)?$_SESSION['inf_des']=1:$_SESSION['inf_des']=0;
    
    in_array(200,$val_select)?$his=1:$his=0;
    in_array(201,$val_select)?$_SESSION['his_agr_trib']=1:$_SESSION['his_agr_trib']=0;

    in_array(300,$val_select)?$ing=1:$ing=0;
    in_array(301,$val_select)?$ing_mov=1:$ing_mov=0;
    in_array(302,$val_select)?$_SESSION['ing_mov_ver']=1:$_SESSION['ing_mov_  ver']=0;
    in_array(303,$val_select)?$_SESSION['ing_mov_cli']=1:$_SESSION['ing_mov_cli']=0;  
    in_array(304,$val_select)?$_SESSION['ing_mov_agr']=1:$_SESSION['ing_mov_agr']=0;  
    in_array(305,$val_select)?$_SESSION['ing_mov_edi']=1:$_SESSION['ing_mov_edi']=0;  
    in_array(306,$val_select)?$_SESSION['ing_mov_eli']=1:$_SESSION['ing_mov_eli']=0;  
    in_array(307,$val_select)?$_SESSION['ing_mov_qui']=1:$_SESSION['ing_mov_qui']=0;  
    //in_array(308,$val_select)?$_SESSION['ing_mov_q2']=1:$_SESSION['ing_mov_q2']=0;  
    in_array(309,$val_select)?$ing_lis=1:$ing_lis=0;  
    in_array(310,$val_select)?$_SESSION['ing_lis_ver']=1:$_SESSION['ing_lis_ver']=0;
    in_array(311,$val_select)?$_SESSION['ing_lis_act']=1:$_SESSION['ing_lis_act']=0;  

    in_array(400,$val_select)?$egr=1:$egr=0;
    in_array(401,$val_select)?$egr_mov=1:$egr_mov=0;
    in_array(402,$val_select)?$_SESSION['egr_mov_ver']=1:$_SESSION['egr_mov_  ver']=0;
    in_array(403,$val_select)?$_SESSION['egr_mov_cli']=1:$_SESSION['egr_mov_cli']=0;  
    in_array(404,$val_select)?$_SESSION['egr_mov_agr']=1:$_SESSION['egr_mov_agr']=0;  
    in_array(405,$val_select)?$_SESSION['egr_mov_edi']=1:$_SESSION['egr_mov_edi']=0;  
    in_array(406,$val_select)?$_SESSION['egr_mov_eli']=1:$_SESSION['egr_mov_eli']=0;  
    in_array(407,$val_select)?$_SESSION['egr_gas_agr']=1:$_SESSION['egr_gas_agr']=0;  
    in_array(408,$val_select)?$egr_lis=1:$egr_lis=0;  
    in_array(409,$val_select)?$_SESSION['egr_lis_ver']=1:$_SESSION['egr_lis_ver']=0;
    in_array(410,$val_select)?$_SESSION['egr_lis_act']=1:$_SESSION['egr_lis_act']=0;  

    in_array(500,$val_select)?$mal=1:$mal=0;
    
    in_array(600,$val_select)?$man=1:$man=0;
    in_array(601,$val_select)?$man_cue=1:$man_cue=0;
    in_array(602,$val_select)?$man_sub=1:$man_sub=0;
    in_array(603,$val_select)?$man_emp=1:$man_emp=0;
    in_array(604,$val_select)?$man_suc=1:$man_suc=0;
    in_array(605,$val_select)?$man_ser=1:$man_ser=0;
    in_array(606,$val_select)?$man_ban=1:$man_ban=0;
    in_array(607,$val_select)?$man_con=1:$man_con=0;
    in_array(608,$val_select)?$man_pla=1:$man_pla=0;
    in_array(609,$val_select)?$man_tip=1:$man_tip=0;
    in_array(610,$val_select)?$man_mon=1:$man_mon=0;
    in_array(611,$val_select)?$man_lin=1:$man_lin=0;
    //in_array(18,$val_select)?$parametro_per=1:$parametro_per=0; //Mant. Parametro en Stand By
    in_array(612,$val_select)?$man_iva=1:$man_iva=0;
    in_array(613,$val_select)?$man_usu=1:$man_usu=0;
    
    in_array(700,$val_select)?$pre=1:$pre=0;

  }
//echo $man_emp.$man_suc.$parametro_per.$man_usu;

if(empty($url)){
  $boton = 'main';
}else{
  $boton = $url;
}
$pos = strpos($boton, "/");

//echo "boton: ".$boton."<br>";
//echo $pos;

if ($pos === false) {

$boton1="";
}else{
list($boton1,$id)=explode("/",$boton);
}

//echo "boton1: ".$boton1."<br>";

$clase = '';
$fecha_actual = date('Y-m-d');
//echo $fecha_actual."<br>";
$hoy_encrypt = $this->encryption->encrypt($fecha_actual);
//echo $hoy_encrypt."<br>";
$hoy = strtr($hoy_encrypt,array('+' => '.', '=' => '-', '/' => '~'));
//echo $hoy."<br>";
/*$hoy = strtr($hoy, array('.' => '+', '-' => '=', '~' => '/'));
$hoy = $this->encryption->decrypt($hoy);*/
//echo $hoy."<br>";
?>

<!DOCTYPE html>

<html lang="es">

  <head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $pageTitle; ?></title>

		<meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    
    <!-- basic styles -->

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/font-awesome.min.css" />

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/dataTables.bootstrap.css" >
    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/bootstrap-datepicker3.min.css" />

		<!-- fonts -->

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/ace-fonts.css" />

    <!-- loading -->

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/loading.css" />

    <!-- ace styles -->

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/ace-skins.min.css" />

    <link rel="stylesheet" href="<?php echo base_url() ?>../bootstrap/css/bootstrap-colorpicker.min.css" />

    <script src="<?php echo base_url() ?>../bootstrap/js/jquery-2.2.3.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/jquery.dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/bootbox.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/jquery.maskedinput.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/fuelux/fuelux.spinner.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/jquery.nestable.min.js"></script>
    <script src="<?php echo base_url() ?>../js/empresa.js"></script>
    <script src="<?php echo base_url() ?>../js/ingreso.js"></script>
    <script src="<?php echo base_url() ?>../js/mantenedor/mantenedor.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/jquery.easypiechart.min.js"></script>
		<script src="<?php echo base_url() ?>../bootstrap/js/jquery.sparkline.index.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/flot/jquery.flot.resize.min.js"></script>
		<script src="<?php echo base_url() ?>../bootstrap/js/flot/jquery.flot.min.js"></script>
		<script src="<?php echo base_url() ?>../bootstrap/js/flot/jquery.flot.pie.min.js"></script>
    
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script type="text/javascript">
      if("ontouchend" in document) document.write("<script src='<?php echo base_url() ?>../bootstrap/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <script src="<?php echo base_url() ?>../bootstrap/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="assets/js/excanvas.min.js"></script>
    <![endif]-->

      <!-- ace scripts -->

    <script src="<?php echo base_url() ?>../bootstrap/js/ace-elements.min.js"></script>
    <script src="<?php echo base_url() ?>../bootstrap/js/ace.min.js"></script>

    <!-- inline scripts related to this page -->
    <script src="<?php echo base_url() ?>../bootstrap/js/ace-extra.min.js"></script>
    
    <script>
      var site_url = "<?php echo base_url();?>";
    </script>

<link rel="icon" href="<?php echo base_url();?>bootstrap/images/favicon.ico" type="image/x-icon">

</head>

<body class="navbar-fixed">

<div id="loading_resumen_i" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div>        
</div>

<div id="loading_resumen_e" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div>        
</div>

<div id="loading_resumen_sa" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div>        
</div>

<div id="loading_gr" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div>        
</div>

<div id="loading_dm" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div> 
</div>

<div id="loading_dtp" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div> 
</div>

<div id="loading_et" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div> 
</div>

<div id="loading_dsp" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>  
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div> 
</div>

<div id="loading_ea" class="loading" style="1display: none;">
  <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
  </div>
  <div class="cssload-text">
        <h3>Cargando...</h3>
  </div>
</div>


  <div id="navbar" class="navbar navbar-default navbar-fixed-top">

    <div class="navbar-container ace-save-state" id="navbar-container">

      <div class="navbar-header pull-left">

        <span class="navbar-brand">

            <small>

              <i class="icon-calendar"></i>

                Flujo de Caja 

            </small>
            
        </span>

      </div>
      
        <!--<div><img <?php  echo devuelve_logo_empresa_cabecera($id_empresa) ?> class="img-responsive" style="width:10%;height:10%" alt=""/></div><br>-->

        </a><!-- /.brand -->
      
      </div><!-- /.navbar-header -->

      <div class="navbar-buttons navbar-header pull-right" role="navigation">

        <ul class="nav ace-nav">
            
          <li class="grey dropdown-modal">
              
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

              <?php 

              if(es_casa_central($id_empresa) == 1){
                
                $img_casa_central1 = '<i class="icon-star"></i>';
              
              }else{

                $img_casa_central1 = '<i class='.$class_icon_empresas.'></i>';
              }

                echo $img_casa_central1."&nbsp;".devuelve_nombre_empresa($id_empresa);?>
                
                <i class="icon-caret-down"></i>
              
            </a>

            <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                  
              <li class="dropdown-header">

                <i class="<?php echo $class_icon_empresas;?>"></i><?php echo count($mostrar_empresas_usuario);?> Empresa(s)
                
              </li>

              <?php
                  
              foreach ($mostrar_empresas_usuario as $cl){ ?>
                
              <li>
                  
                <a href="<?php echo base_url()."dashboard"."/".$cl->id_empresa."/".$id_usuario."/".$hoy; ?>">
                      
                  <div class="clearfix">
                  
                    <span class="pull-left">
                      
                      <?php  
                            
                      if($cl->casa_central == 1){
                        
                        $img_casa_central = '<i class="icon-star"></i>';
                      
                      }else{

                        if($cl->id_empresa === $id_empresa){

                          $aquiestoy = '<i class="icon-arrow-right"></i>';
                        
                        }else{
                        
                          $aquiestoy = '';
                        
                        }

                        $img_casa_central = "";

                        }

                      echo $aquiestoy."&nbsp;&nbsp;".$cl->nombre_empresa."&nbsp;&nbsp;&nbsp;".$img_casa_central;?>
                        
                    </span>
                      
                  </div>

                </a>

              </li>
                  
              <?php } ?>                

              <li>
                    
              </li>
                
            </ul>

          </li>

          
          <li class="light-blue dropdown-modal">
            
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            
              <i class="icon-user"></i>&nbsp;&nbsp;

                <span class="user-info">

                  <small>Bienvenido,</small>

                  <?php echo $fullname; ?>

                </span>

              <i class="icon-caret-down"></i>

            </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                <li>

                  <a href="<?php echo base_url()."perfil"."/".$id_empresa; ?>">

                    <i class="icon-cog"></i>

                    Mi Perfil

                  </a>

                </li>

                <li class="divider"></li>
                
                <li>

                    <a href="<?php echo base_url(); ?>logout">

                    <i class="icon-off"></i> 

                      Salir

                    </a>

                </li>

              </ul>

          </li>

        </ul><!-- /.nav ace-nav -->

      </div><!-- /.role="navigation" -->      

    </div><!-- /.navbar-container -->

  </div><!-- /.navbar -->

<div class="main-container ace-save-state" id="main-container">

    <script type="text/javascript">

      try{ace.settings.loadState('main-container')}catch(e){}

    </script>

  <!--<div class="main-container-inner">

    <a class="menu-toggler" id="menu-toggler" href="#">

      <span class="menu-text"></span>
      
    </a>-->
    
    <!--Ahora es fijo solo la cabecera, ya que "molesta" al querer todos los mantenedores.-->

    <div class="sidebar" id="sidebar">
      
          <script type="text/javascript">
          
            try{ace.settings.loadState('sidebar')}catch(e){}

          </script>

          <ul class="nav nav-list">

            <li <?php if($boton == 'main' || $boton1 == 'dashboard' ){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

             <a href="<?php echo base_url()."dashboard"."/".$id_empresa."/".$id_usuario."/".$hoy; ?>">

               <i class="icon-dashboard"></i>

               <span class="menu-text"> Dashboard </span>

             </a>

            </li>

          </ul>

          <?php 

          if(es_casa_central($id_empresa) == 1){
          
          $img_casa_central1 = '<i class="icon-desktop"></i>';
        
          }else{

          $img_casa_central1 = '<i class="icon-desktop"></i>';
          }

          if(es_casa_central($id_empresa) == 1){ ?>

          <ul class="nav nav-list">

            <li <?php if($boton == 'main' || $boton1 == 'home_empresa'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

              <a href="<?php echo base_url()."home_empresa"."/".$id_empresa."/".$id_usuario."/".$hoy; ?>">

                <?php echo $img_casa_central1; ?>

                <span class="menu-text"> Consolidado </span>

              </a>

            </li>

          </ul>
          
          <?php } ?>
          
          

          <?php if(es_casa_central($id_empresa) == 0){ ?>
          
          <?php if($inf == 1){ ?>

          <ul class="nav nav-list">

            <li <?php if($boton == 'main' || $boton1 == 'home_empresa'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

             <a href="<?php echo base_url()."home_empresa"."/".$id_empresa."/".$id_usuario."/".$hoy; ?>">

               <i class="icon-desktop"></i>

               <span class="menu-text"> Resumen </span>

             </a>

            </li>

          </ul>

          <?php } 
        
          } ?>

          <ul class="nav nav-list">

          <?php if($his == 1){ ?>

            <li <?php if($boton1 == 'historico'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

              <a href="<?php echo base_url()."historico"."/".$id_empresa; ?>">

                <i class="icon-time"></i>

                <span class="menu-text"> Hist&oacute;rico </span>

              </a>

            </li>

          </ul>

          <?php } ?>

          <ul class="nav nav-list">

          <?php if(es_casa_central($id_empresa) == 0){ 
            
            if($ing==1) { ?>

            <li <?php if($boton1 == 'ingreso' || $boton1 == 'listado' || $boton1 == 'movimiento'){$clase = 'class="active open"';}else{$clase = '';} echo $clase; ?>>

              <a href="#" class="dropdown-toggle">

              <i class="icon-arrow-down green"></i>

               <span class="menu-text"> Ingresos </span>

                <b class="arrow icon-angle-down"></b>

							</a>

                <ul class="submenu">
                
                <?php if ( ($ing==1) && ($ing_mov == 1) ){ ?>

                  <li <?php if($boton1 == 'ingreso' || $boton1 == 'movimiento'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

                    <a href="<?php echo base_url()."ingreso"."/".$id_empresa."/".$hoy; ?>">

                      <i class="icon-plus green"></i>

                      <span class="menu-text"> Movimientos </span>

                    </a>

                  </li>
                  
                  <?php } ?>

                  <?php if ( ($ing==1) && ($ing_lis == 1) ){ ?>

                  <li <?php if($boton1 == 'listado'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

                    <a href="<?php echo base_url()."listado"."/".$id_empresa; ?>">

                        <i class="icon-th-list green"></i>

                        <span class="menu-text"> Listado </span>
                        
                    </a>

                  </li>
                  
                  <?php } ?>

                </ul>
              
            </li>

            <?php } ?>

            <?php if($egr==1) {?>

            <li <?php if($boton1 == 'egreso' || $boton1 == 'listado_egreso' || $boton1 == 'movimiento_egreso'){$clase = 'class="active open"';}else{$clase = '';} echo $clase; ?>>

              <a href="#" class="dropdown-toggle">

                <i class="icon-arrow-up red"></i>

                <span class="menu-text"> Egresos </span>

                  <b class="arrow icon-angle-down"></b>
                
							</a>

							<ul class="submenu">
              
              <?php if ( ($egr==1) && ($egr_mov == 1) ){ ?>

                <li <?php if($boton1 == 'egreso' || $boton1 == 'movimiento_egreso'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                
                  <!-- HAmestica: Llamada a url manteniendo cuentas abiertas -->
                  <!-- <a href="<?php echo base_url()."egreso"."/".$id_empresa."/".$hoy; ?>"> -->
                  <a href="<?php echo base_url()."egreso"."/".$id_empresa."/".$hoy."/0"; ?>">

                    <i class="icon-plus red"></i>

                    <span class="menu-text"> Movimientos </span>

                  </a>

                </li>
                
                <?php } ?>

                <?php if ( ($egr==1) && ($egr_lis == 1) ){ ?>

								<li <?php if($boton1 == 'listado_egreso'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                
                  <a href="<?php echo base_url()."listado_egreso"."/".$id_empresa; ?>">

                      <i class="icon-th-list red"></i>

                      <span class="menu-text"> Listado </span>

                  </a>

								</li>
                
                <?php } ?>

              </ul>
              
            </li>
            
            <?php } ?>

            <?php if($mal == 1){ ?>

            <li <?php if($boton1 == 'malla_societaria'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

              <a href="<?php echo base_url()."malla_societaria"."/".$id_empresa; ?>">

                <i class="icon-globe"></i>

                <span class="menu-text"> Malla Societaria</span>

              </a>

            </li>

            <?php } 
          
            } ?>


            <!---SI ES EM Y EL USUARIO NO ES ADMIN NO APARECE EL MENU DE MANTENEDOREs-->
            <?php if( ($id_tipo_perfil != 1) && (es_casa_central($id_empresa) == 1) ){ $clase_hidden = 'class="hidden"';}else{$clase_hidden = 'class=""';}
            
            if($man==1) {?>

            <li <?php if($boton1 == 'cuenta' || $boton1 == 'subcuenta' || $boton1 == 'empresa' || $boton1 == 'sucursal' || $boton1 == 'cliente' || $boton1 == 'proveedor' || $boton1 == 'banco' || $boton == 'servicio_otro' || $boton1 == 'condicion_pago' || $boton1 == 'plazo_pago' || $boton1 == 'tipo_documento' || $boton1 == 'moneda'|| $boton1 == 'linea_credito' || $boton1 == 'iva' || $boton1 == 'servicio' || $boton1 == 'parametro' || $boton1 == 'usuario'){$clase = 'class="active open"';}else{$clase = $clase_hidden;} echo $clase; ?>>

              <a href="#" class="dropdown-toggle">

                <i class="icon-wrench"></i>

                <span class="menu-text"> Mantenedores </span>

                <b class="arrow icon-angle-down"></b>

              </a>

                <ul class="submenu">

                <?php if(es_casa_central($id_empresa) == 0){ 
                  
                  if ( ($man==1) && ($man_cue == 1) ){ ?>
                

                  <li <?php if($boton1 == 'cuenta' || $boton1 == 'subcuenta' ){$clase = 'class="active open"';}else{$clase = '';} echo $clase; ?>>
                   
                    <a href="<?php echo base_url()."cuenta"."/".$id_empresa; ?>">

                      <i class="icon-th-large"></i>

                      <span class="menu-text"> Cuentas </span>

                    </a>

                      <ul class="submenu">

                        <li <?php if($boton1 == 'sucursal'){$clase = 'class=""';}else{$clase = '';} echo $clase; ?>>

                          <a href="<?php echo base_url()."subcuenta"."/".$id_empresa; ?>">

                            <i class="icon-th"></i>

                            <span class="menu-text"> Subcuentas </span>

                          </a>

                        </li>

                      </ul>

                  </li>

                  <?php  } 
                
                    } ?>

                  <?php 
                  

                    if ( ($man==1) && ($man_emp == 1) ){ ?>

                      <li <?php if($boton1 == 'empresa' ){$clase = 'class="active open"';}else{$clase = '';} echo $clase; ?>>

                        <a href="<?php echo base_url()."empresa"."/".$id_empresa; ?>">

                          <i class="icon-tag"></i>

                          <span class="menu-text"> Empresas</span>

                        </a>

                      </li>

                  <?php } ?>
                  
                <?php if(es_casa_central($id_empresa) == 0){ ?>
                 <?php if ( ($man==1) && ($man_ser== 1) ){ ?>
                  <li <?php if($boton1 == 'servicio'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."servicio"."/".$id_empresa; ?>">
                      <i class="icon-bookmark"></i>
                      <span class="menu-text"> Servicios </span>
                    </a>
                  </li>
                 <?php } ?>
                 <?php if ( ($man==1) && ($man_ban== 1) ){ ?>
                  <li <?php if($boton1 == 'banco'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."banco"."/".$id_empresa; ?>">
                      <i class="icon-credit-card"></i>
                      <span class="menu-text"> Bancos </span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_con== 1) ){ ?>
                  <li <?php if($boton1 == 'condicion_pago'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."condicion_pago"."/".$id_empresa; ?>">
                      <i class="icon-ok"></i>
                      <span class="menu-text"> Condici&oacute;n(es) de Pago</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_pla== 1) ){ ?>
                  <li <?php if($boton1 == 'plazo_pago' ){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."plazo_pago"."/".$id_empresa; ?>">
                      <i class="icon-tasks"></i>
                      <span class="menu-text"> Plazos de Pago</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_tip== 1) ){ ?>
                  <li <?php if($boton1 == 'tipo_documento'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."tipo_documento"."/".$id_empresa; ?>">
                      <i class="icon-file"></i>
                      <span class="menu-text"> Tipos de Documentos</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_mon== 1) ){ ?>
                  <li <?php if($boton1 == 'moneda'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."moneda"."/".$id_empresa; ?>">
                      <i class="icon-usd"></i>
                      <span class="menu-text"> Monedas</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_lin== 1) ){ ?>
                  <li <?php if($boton1 == 'linea_credito'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."linea_credito"."/".$id_empresa; ?>">
                      <i class="icon-list-alt"></i>
                      <span class="menu-text"> L&iacute;neas de Cr&eacute;dito</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if ( ($man==1) && ($man_iva== 1) ){ ?>
                  <li <?php if($boton1 == 'iva'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."iva"."/".$id_empresa; ?>">
                      <i class="icon-pushpin"></i>
                      <span class="menu-text"> IVA</span>
                    </a>
                  </li>
                  <?php }?>
                  
                <?php } ?>

                <?php if ( ($man==1) && ($man_usu== 1) ){ ?>

                  <li <?php if($boton1 == 'usuario'){$clase = 'class="active"'; $texto_breadcum = 'Usuarios';}else{$clase = '';} echo $clase; ?>>
                    <a href="<?php echo base_url()."usuario"."/".$id_empresa; ?>">
                      <i class="icon-user"></i>
                      <span class="menu-text"> Usuarios </span>
                    </a>
                  </li>

                  <?php }
                  }?>

                </ul>

            </li>
            
            <?php if ($pre==1){ ?>

            <li <?php if($boton1 == 'prestamo'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

              <a href="<?php echo base_url()."prestamo"."/".$id_empresa; ?>">

                <i class="icon-refresh"></i>

                <span class="menu-text"> Pr&eacute;stamos</span>

              </a>

            </li>

            <?php }?>
            <!-- Oculto este menu. Para cambiar la clave el usuario ira al boton perfil que esta en el menu de bienvenida-->
            <li <?php if($boton1 == 'soporte' || $boton1 == 'manual' || $boton1 == 'control'){$clase = 'class="active open"'; $texto_breadcum = 'Perfil';}else{$clase = '';} echo $clase; ?>>
              
              <a href="#" class="dropdown-toggle">
                
                <i class="icon-question-sign"></i>
                
                <span class="menu-text"> Soporte </span>
                  
                <b class="arrow icon-angle-down"></b>
                
              </a>

              <ul class="submenu">
                
                <li <?php if($boton1 == 'soporte' || $boton1 == 'manual'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

                  <a href="<?php echo base_url()."manual"."/".$id_empresa; ?>">
                  <!-- <a href="<?php echo base_url()."manual/manual.odt"; ?>">-->

                    <i class="icon-book"></i>

                    <span class="menu-text"> Manual </span>

                  </a>

                </li>

                <!--<li <?php if($boton1 == 'control'){$clase = 'class="active"';}else{$clase = '';} echo $clase; ?>>

                  <a href="<?php echo base_url()."control"."/".$id_empresa; ?>">

                      <i class="icon-cloud"></i>

                      <span class="menu-text"> Control de Versiones</span>
                      
                  </a>

                </li>-->
               
              </ul>

            </li>
            

            <!--
            <li <?php if($boton1 == 'blank'){$clase = 'class="active"'; $texto_breadcum = 'Blank';}else{$clase = '';} echo $clase; ?>>
              
              <a href="<?php echo base_url()."blank"."/".$id_empresa; ?>">
                <i class="icon-file"></i>
                <span class="menu-text"> Blank </span>
              </a>

            </li>
              -->
              <!-- NUEVO MODULOS
              <?php foreach ($muestra_submodulo as $submodulo) { ?>

                <li>
                  <a href="<?php echo base_url().$submodulo->nombre_submodulo."/".$id_empresa; ?>">
                    <i class=<?php echo $submodulo->icon; ?>></i>
                    <span class="menu-text"> <?php echo $submodulo->titulo_submodulo;?> </span>
                  </a>
                </li>

                <?php } ?>-->

          </ul><!-- /.nav-list -->

          <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
          </div> 
<!--
          <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					  <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				  </div>-->

    </div> <!-- /.sidebar -->

    <div class="main-content">
      
        <script type="text/javascript">

        $(document).ready(function() {

          $('#loading_resumen_i').hide(); 
          $('#loading_resumen_e').hide(); 
          $('#loading_resumen_sa').hide();
          $('#loading_gr').hide(); 
          $('#loading_dm').hide(); 
          $('#loading_dtp').hide(); 
          $('#loading_et').hide(); 
          $('#loading_dsp').hide(); 
          $('#loading_ea').hide(); 

        });

        </script>