
  <script type="text/javascript">

    $(document).ready(function() {
    
                $("input[type=text]").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
  });

    function save()
  {


    $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    $('#btnReset').attr('disabled',true); //set button disable

    var url;

    var formData = new FormData($('#form')[0]);
    var id_empresa = $('#id_empresa_guarda').val();

    url = "<?php echo site_url('update_contrasena')?>";

    $.ajax({
      url : url,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function(data)
      {

          if(data.status) //if success close modal and reload ajax table
          {

            alert('Contraseña actualizada. Por seguridad deberá volver a iniciar sesión.');
            $(location).attr('href','<?php echo base_url().'/logout' ?>');
            // window.location.href= base_url;


          }
          else
          {
              for (var i = 0; i < data.inputerror.length; i++)
              {
                  $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                  $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
              }
          }
          $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardar'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          $('#btnAnular').attr('disabled',true);

        },

          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error al guardar los datos.');
            $('#btnSave').html('<i class="ace-icon icon icon-save bigger-110"></i>&nbsp;Guardando...'); //change button textarea
            $('#btnSave').attr('disabled',false); //set button enable
            $('#btnAnular').attr('disabled',true); //set button disable
            $('#btnVolver').attr('disabled',true); //set button disable
          }
        });
  }

  </script>


    
<div class="main-content-inner">

  <div class="page-content">
      
      <div class="page-header">

          <h1>
              <i class="icon-cog"></i> Mi Perfil
                            <small>
                  <i class="icon-double-angle-right"></i>
                  &nbsp;cambiar clave acceso sistema.
                </small>
          </h1>

      </div><!-- /.page-header -->
      
      <div class="row">
      
        <div class="col-xs-12">
          
            <!-- PAGE CONTENT BEGINS -->
          
            <form class="form-horizontal" id="form" class="form-horizontal" role="form">
              
              <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda"/>
              <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario" id="id_empresa_guarda"/>

              <div class="form-body">

                  <!--<div class="form-group">
                    <label class="control-label col-md-3">Contraseña Actual *</label>
                    <div class="col-md-6">
                      <input id="contra_actual" name="contra_actual" placeholder="Contraseña actual" class="form-control" type="text" autocomplete="off">
                      <span style="font-size: 16px;" class="help-block"></span>
                    </div>
                  </div>-->

                  <div class="form-group">
                    <label class="control-label col-md-3">Contraseña Nueva *</label>
                    <div class="col-md-6">
                      <input id="contra_nueva" name="contra_nueva" placeholder="Contraseña nueva" class="form-control" type="text" autocomplete="off">
                      <span style="font-size: 16px;" class="help-block"></span>
                    </div>
                  </div>                 

                  <div class="form-group">
                    <label class="control-label col-md-3">Confirmacion Contraseña *</label>
                    <div class="col-md-6">
                      <input id="contra_conf" name="contra_conf" placeholder="Confirmacion Contraseña" class="form-control" type="text" autocomplete="off">
                      <span style="font-size: 16px;" class="help-block"></span>
                    </div>
                  </div>  
                
              </div>    
              
            </form>
                        
            <div class="clearfix form-actions">
              
              <div class="col-md-offset-3 col-md-9">
              
                <button class="btn btn-default" type="reset" id="btnReset" >
                    <i class="ace-icon icon icon-refresh bigger-110"></i>
                    Limpiar
                </button>
                
                &nbsp; &nbsp; &nbsp;

                <button class="btn btn-success" type="button" id="btnSave" onclick="save()">
                    <i class="ace-icon icon icon-save bigger-110"></i>
                    Guardar
                </button>

              </div>
            
            </div><!-- /.clearfix form-actions -->
            
        </div><!-- /.col-xs-12 -->

      </div><!-- /.row -->

    </div><!-- /.page-content -->
      
</div><!-- /.main-content-inner -->