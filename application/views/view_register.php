<!DOCTYPE html>

<html lang="es">

  <head>
    
    <meta charset="utf-8" />
    <title>Flujo de Caja</title>

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

                <div id="signup-box" class="signup-box visible widget-box no-border">
                    
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
                    

                      <form action="<?php echo base_url();?>create/" method="post">
                      
												<fieldset>

                          <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nombre" autocomplete="off" value="<?php echo set_value('fullname'); ?>" />
															<i class="icon-briefcase"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="username_register" name="username_register" placeholder="Usuario" autocomplete="off" value="<?php echo set_value('username_register'); ?>"/>
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" id="password_register" name="password_register" placeholder="Clave" autocomplete="off" value="<?php echo set_value('password_register'); ?>"/>
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
                            <input type="password" class="form-control" id="password_register2" name="password_register2" placeholder="Repetir clave" autocomplete="off" value="<?php echo set_value('password_register2'); ?>"/>
															<i class="icon-retweet"></i>
														</span>
													</label>

                          <label class="block clearfix">
														<span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo set_value('email'); ?>"/>
															<i class="icon-envelope"></i>
														</span>
													</label>

													<!--<label class="block">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															I accept the
															<a href="#">User Agreement</a>
														</span>
													</label>-->

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
											<a href="<?php echo base_url();?>" class="back-to-login-link">
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
