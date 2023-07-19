<!DOCTYPE html>

<html lang="es">

  <head>
    
    <meta charset="utf-8" />
    <title>Flujo de Caja 1</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="<?php echo base_url();?>../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>../bootstrap/css/font-awesome.min.css" />

    <!--[if IE 7]>
      <link rel="stylesheet" href="css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <link rel="stylesheet" href="<?php echo base_url();?>../bootstrap/css/ace-fonts.css" />

    <!-- ace styles -->

    <link rel="stylesheet" href="<?php echo base_url();?>../bootstrap/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>../bootstrap/css/ace-rtl.min.css" />

    <link rel="icon" href="<?php echo base_url();?>../bootstrap/images/favicon.ico" type="image/x-icon">

    <!--[if lte IE 8]>
      <link rel="stylesheet" href="css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="login-layout" >
    
    <div class="main-container">
      
      <div class="main-content">
        
        <div class="row">

          <div class="col-sm-10 col-sm-offset-1">
            
            <div class="login-container">
              
              <div class="space-18"></div>

              <div class="center">

                  <h1>

                    <i class="icon-calendar white"></i>

                    <span class="blue" id="id-text2">Flujo de Caja</span>

                  </h1>
                  
                  <!--<h4 class="blue" id="id-company-text"> v3.0.1</h4>-->
                  
              </div>
              
              <div class="space-18"></div>
              
              <div class="position-relative">
                
                <div id="login-box" class="login-box visible widget-box">
                
                  <!--<img src='<?php echo base_url();?>../application/imagenes/Group.png' class='img-responsive'>-->
                  
                  <div class="widget-body">
                    
                    <div class="widget-main">
                      
                      <h4 class="header blue lighter bigger">

                      <i class="icon-user"></i>
                        Ingrese su informaci&oacute;n
                      </h4>

                      <div class="space-6"></div>
                      
                        <?php 
                        
                        $this->load->helper('form'); ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                            </div>
                        </div>
                        
                        <?php 
                        
                        $this->load->helper('form');
                        
                        $error = $this->session->flashdata('error');
                        
                        if($error){ ?>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error; ?>
                              </div>
                            </div>
                          </div>
                        <?php }

                        $success = $this->session->flashdata('success');
                        
                        if($success) { ?>

                          <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <?php echo $success; ?>
                          </div>

                        <?php } ?>

                        <form action="<?php echo base_url();?>inside/" method="post">
                          
                          <fieldset>
                            
                            <label class="block clearfix">
                              <span class="block input-icon input-icon-right">
                               
                                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" autocomplete="off" value="<?php echo set_value('username'); ?>"/>
                                <i class="icon-user"></i>
                              </span>
                            </label>

                            <label class="block clearfix">
                              <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Clave" autocomplete="off" value="<?php echo set_value('password'); ?>"/>
                                <i class="icon-lock"></i>
                              </span>
                            </label>

                            <div class="space"></div>

                            <div class="clearfix">
                              <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                <i class="icon-key"></i>
                                Entrar
                              </button>
                            </div>

                          </fieldset>  
                          
                        </form>
                        
                    </div><!-- /widget-main -->
                    
                    <div class="toolbar clearfix">

											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													Olvid&eacute; mi clave
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													Registro
													<i class="icon-arrow-right"></i>
												</a>
                      </div>
                      
                    </div>

                  </div><!-- /widget-body -->

                </div><!-- /login-box -->

                <div id="forgot-box" class="forgot-box widget-box no-border">

										<div class="widget-body">

											<div class="widget-main">

												<h4 class="header red lighter bigger">
													<i class="icon-key"></i>
													Recuperar Clave
												</h4>
	
												<div class="space-6"></div>
												<p>
													Ingrese su email para recibir instrucciones
												</p>
	
												<form>
													<fieldset>
														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="email" class="form-control" placeholder="Email" />
																<i class="icon-envelope"></i>
															</span>
														</label>
	
														<div class="clearfix">
															<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
																<i class="icon-arrow-right"></i>
																<span class="bigger-110">Enviar</span>
															</button>
														</div>
													</fieldset>
												</form>
											</div><!-- /.widget-main -->
	
											<div class="toolbar center">
												<a href="#" data-target="#login-box" class="back-to-login-link">
														Volver al login
													<i class="icon-arrow-right"></i>
												</a>
                      </div>
                      
                    </div><!-- /.widget-body -->
                    
                </div><!-- /.forgot-box -->

                <div id="signup-box" class="signup-box widget-box no-border">
                    
                  <div class="widget-body">
                    
                    <div class="widget-main">
                      
                      <h4 class="header green lighter bigger">
                      <i class="icon-lock green"></i>
												Crear una cuenta
											</h4>

											<div class="space-6"></div>
                      
                        <?php 
                        
                        $this->load->helper('form'); ?>
                     
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                            </div>
                        </div>
                        
                        <?php 
                        
                        $this->load->helper('form');
                        
                        $error_register = $this->session->flashdata('error_register');
                        
                        if($error_register){ ?>
                        
                          <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <?php echo $error_register; ?>
                          </div>
                        
                        <?php }

                        $success_register = $this->session->flashdata('success');
                        
                        if($success_register) { ?>

                          <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <?php echo $success_register; ?>
                          </div>

                        <?php } ?>
                    

                      <form action="<?php echo base_url();?>register" method="post">
                      
												<fieldset>

                        <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="rut_empresa" name="rut_empresa" placeholder="R.U.T. empresa" autocomplete="off" value="<?php echo set_value('rut_empresa'); ?>" required/>
															<i class="icon-briefcase"></i>
														</span>
													</label>

                          <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Nombre empresa" autocomplete="off" value="<?php echo set_value('nombre_empresa'); ?>" required/>
															<i class="icon-briefcase"></i>
														</span>
													</label>

                          <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nombre usuario" autocomplete="off" value="<?php echo set_value('fullname'); ?>" required/>
															<i class="icon-briefcase"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="username_register" name="username_register" placeholder="Usuario" autocomplete="off" value="<?php echo set_value('username_register'); ?>" required/>
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" id="password_register" name="password_register" placeholder="Clave" autocomplete="off" value="<?php echo set_value('password_register'); ?>" required/>
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                            <input type="password" class="form-control" id="password_register2" name="password_register2" placeholder="Repetir clave" autocomplete="off" value="<?php echo set_value('password_register2'); ?>" required/>
															<i class="icon-retweet"></i>
														</span>
													</label>

                          <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo set_value('email'); ?>" required/>
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" id="multiempresa" name="multiempresa" class="ace"/>
														<span class="lbl">
                              Quiero una cuenta multiempresa
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															<span class="bigger-110">Limpiar</span>
														</button>

														<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Registrar</span>

															<i class="icon-arrow-right"></i>
														</button>
													</div>
                        
                        </fieldset>
                        
                      </form>
                      
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												Volver al login
											</a>
                    </div>
                    
                  </div><!-- /.widget-body -->
                  
                </div><!-- /.signup-box -->

              </div><!-- /position-relative -->

            </div><!-- /login-container -->

          </div><!-- /.col -->

        </div><!-- /.row -->

      </div><!-- /main-content -->

    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->

    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo base_url();?>../bootstrap/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>
 <!-- inline scripts related to this page -->
    <script type="text/javascript">
          jQuery(function($) {
          $(document).on('click', '.toolbar a[data-target]', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');//hide others
            $(target).addClass('visible');//show target
          });
          });
          
        </script>
  </body>

</html>
