<?php

if(es_casa_central($id_empresa)){
  $text_verde = ' del Holding ';
}else{
  $text_verde = ' de la empresa ';
}

//TRAER ESTE MES
$este_mes = date('n');
if(devuelve_este_mes($este_mes,$id_empresa)){
  $total_este_mes = devuelve_este_mes($este_mes,$id_empresa);
  $total_este_mes_mostrar = array($total_este_mes[0], $total_este_mes[1]);
}

//TRAER MES ANTERIOR
$mes_anterior = date('n') - 1;
if(devuelve_este_mes($mes_anterior,$id_empresa)){
$total_este_mes_anterior = devuelve_este_mes($mes_anterior,$id_empresa);
$total_este_mes_anterior_mostrar = array($total_este_mes_anterior[0], $total_este_mes_anterior[1]);
}


//TRAER TOTAL
$este_año = date('Y');
$año_anterior = date('Y') - 1;
$año_anterior_a = date('Y') - 2;

if(!es_casa_central($id_empresa)){

  if(devuelve_total_ano($id_empresa,$este_año)){
    $total_este_año = devuelve_total_ano($id_empresa,$este_año);
    $total_año_anterior = devuelve_total_ano($id_empresa,$año_anterior);
    $total_año_anterior_a = devuelve_total_ano($id_empresa,$año_anterior_a);
    $total_mostrar = array($total_este_año[0],$total_año_anterior[0],$total_año_anterior_a[0]);
  }

}else{

  if(devuelve_total_ano(null,$este_año)){
    $total_este_año = devuelve_total_ano(null,$este_año);
    $total_año_anterior = devuelve_total_ano(null,$año_anterior);
    $total_año_anterior_a = devuelve_total_ano(null,$año_anterior_a);
    $total_mostrar = array($total_este_año[0],$total_año_anterior[0],$total_año_anterior_a[0]);
  }

}

//TRAER TRIBUTARIO
if(!es_casa_central($id_empresa)){
  if(devuelve_tributario_ano($id_empresa,$este_año)){
    $tributario_este_año = devuelve_tributario_ano($id_empresa,$este_año);
    $tributario_año_anterior = devuelve_tributario_ano($id_empresa,$año_anterior);
    $tributario_año_anterior_a = devuelve_tributario_ano($id_empresa,$año_anterior_a);
    $tributario_mostrar = array($tributario_este_año[0],$tributario_año_anterior[0],$tributario_año_anterior_a[0]);
  }
}else{
  if(devuelve_tributario_ano(null,$este_año)){
    $tributario_este_año = devuelve_tributario_ano(null,$este_año);
    $tributario_año_anterior = devuelve_tributario_ano(null,$año_anterior);
    $tributario_año_anterior_a = devuelve_tributario_ano(null,$año_anterior_a);
    $tributario_mostrar = array($tributario_este_año[0],$tributario_año_anterior[0],$tributario_año_anterior_a[0]);
  }
}


?>

    
  <div class="main-content-inner">
        
    <div class="page-content">
        
        <div class="page-header">

            <h1>

                <i class="icon-dashboard"></i> Dashboard
                    
                    <small>
                        <i class="icon-double-angle-right"></i> 
                        &nbsp;gr&aacute;ficas e indicadores econ&oacute;micos.
                    </small>

            </h1>
        
        </div><!-- /.page-header -->
        
        <div class="row">
          
            <div class="col-xs-12">
              <div class="row">
                <div class="alert alert-block alert-success">
                      <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon icon icon-times"></i>
                      </button>

                      <i class="icon icon-home green"></i>
                      Bienvenido, a continuacion se muestran Indicadores Econ&oacute;micos y Estad&iacute;sticas <?php echo $text_verde. devuelve_nombre_empresa($id_empresa); ?> al dia de hoy 
                      <strong class="green">
                      <?php echo date('d-m-Y'); ?>
                      </strong>
                </div><!-- /.alert -->
                </div><!-- /.row -->  
            </div><!-- /.col-xs-12 -->

            <div class="col-sm-12 infobox-container">
              <div class="row">
                <div class="infobox infobox-green">
                  <div class="infobox-icon">
                    <i class="ace-icon glyphicon glyphicon-stats"></i>
                  </div>

                  <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo formato_precio("$ ", devuelve_uf(date('Y-m-d')), 'first');?></span>
                    <div class="infobox-content">uf</div>
                  </div>
                </div>

                <div class="infobox infobox-blue">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-cloud"></i>
                  </div>

                  <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo formato_precio("$ ", devuelve_dolar(date('Y-m-d')), 'first');?></span>
                    <div class="infobox-content">dolar</div>
                  </div>
                  
                  <!--<div class="stat stat-important">$ 1</div>-->

                </div>

                <div class="infobox infobox-pink">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-euro"></i>
                  </div>

                  <div class="infobox-data">
                  <span class="infobox-data-number"><?php echo formato_precio("$ ", devuelve_euro(date('Y-m-d')), 'first');?></span>
                    <div class="infobox-content">euro</div>
                  </div>

                </div>
                
                <div class="infobox infobox-red">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-signal"></i>
                  </div>

                  <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo formato_precio("$ ", devuelve_utm(date('Y-m-'.'01')), 'first');?></span>
                    <div class="infobox-content">utm</div>
                  </div>
                </div>
                <div class="space-6"></div>
                  
                <div class="infobox infobox-blue infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-th-large"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Cuentas</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('cuenta',$id_empresa);?></div>
                  </div>
                </div>
                
                <div class="infobox infobox-grey infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-th"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Subcuentas</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('subcuenta',$id_empresa);?></div>
                  </div>
                </div>

                <div class="infobox infobox-red infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-refresh"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Pr&eacute;stamos</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('prestamo',$id_empresa);?></div>
                  </div>
                </div>

                <div class="infobox infobox-green infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-bookmark"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Servicios</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('servicio',$id_empresa);?></div>
                  </div>
                </div>

                <div class="infobox infobox-grey infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-tag"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Empresas</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('empresa', 1);?></div>
                  </div>
                </div>

                <div class="infobox infobox-pink infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-tags"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Sucursales</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('sucursal', 1);?></div>
                  </div>
                </div>

                <div class="infobox infobox-orange infobox-small infobox-dark">
                  <div class="infobox-icon">
                    <i class="ace-icon icon icon-user"></i>
                  </div>

                  <div class="infobox-data">
                    <div class="infobox-content">Usuarios</div>
                    <div class="infobox-content"><?php echo devuelve_cantidad_mantenedor('usuario',$id_empresa);?></div>
                  </div>
                </div>
                </div><!-- /.row --> 
            </div><!-- /.infobox-container -->     
        
            
            <div class="col-xs-12">
              
              <div class="row">
                  
                  <div class="col-sm-2"></div><!-- /.col-sm-2 -->
              
                  <div class="col-sm-8">
                        <br>
                          <figure class="highcharts-figure">
                            <div id="container"></div>
                              <p class="highcharts-description">
                              </p>
                          </figure>
          
                  </div><!-- /.col-sm-8 -->

                  <div class="col-sm-2"></div><!-- /.col-sm-2 -->
                
              </div><!-- /.row -->  

            </div><!-- /.col-xs-12 -->

        </div><!-- /.row -->  

    </div><!-- /.page-content -->

  </div> <!--/.main-content-inner -->
      
<script type="text/javascript">
<?php

$mes_js = date('n');
$mes_anterior_js = date('n') - 1;
$este_año_js = date('Y');
$año_pasado_js = date('Y') - 1;
$año_pasado_anterior_js = date('Y') - 2;
$año_pasado_anterior_anterior_js = date('Y') - 3;



?>

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Histórico Ventas'
    },
    subtitle: {
        text: null
    },
    xAxis: {
        categories: ['2020', '2019', '2018'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pesos ($)',
            align: 'middle'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' pesos'
    },
    plotOptions: {
      column: {
            dataLabels: {
                enabled: true
            }
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Total',
        data: [<?php echo join($total_mostrar, ',') ?>],
        visible: true
    }, {
        name: 'Tributario',
        data: [<?php echo join($tributario_mostrar, ',') ?>],
        visible: true
    }]
});
		</script>