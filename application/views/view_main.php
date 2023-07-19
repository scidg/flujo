<?php 
  
$canitdad_meses = devuelve_parametro_mes($id_empresa);


if(es_casa_central($id_empresa) == 1){
    
    $txt_em = 'CONSOLIDADO_';
    $img_empresa_madre1 = '<i class="icon-desktop"></i>';
    $txt_res = 'de empresas';
    $txt_res1 = 'Consolidado';    

}else{

    $nom_em = devuelve_nombre_empresa($id_empresa).'_';
    $txt_em = str_replace(' ', '_', $nom_em);
    $img_empresa_madre1 = '<i class="icon-desktop"></i>';
    $txt_res = 'de la empresa';
    $txt_res1 = 'Resumen';    
}

$hoy = date('d_m_Y'); 
$filename = $txt_em.'Resumen_Flujo_Caja_'.$hoy; 

?>
<style>

table tbody tr td table tbody tr td {
        min-width: 77px !important;
        font-size: 12px !important;
}

body {
  overflow: hidden;
}
.hhfixed {
  /*overflow-y: scroll;
  height: 100vh;
  width: 1500px;*/
}
.page-content{
  position: relative;
  overflow-y: scroll;
  max-height: 85vh;
}

tr.cdata, tr.ctrl {
  /*position: fixed;
  width: 100%;*/
}

.fixed #tbfix{
  position: fixed;
  z-index: 0;
  top: 47px;
}
td.gtd{
  min-width: 311px !important;
}
.fixed td.gtd{
  min-width: 263px !important;
}
.footer {
  padding-top: 0px !important;
}
</style>

    
    <div class="main-content-inner">
                    
        <div class="page-content" onscroll="move($(this))">

            <div class="page-header" >

                <?php if(!empty($canitdad_meses)){
                    if($_SESSION['inf_des'] == 1){ ?>
                    
                    <div style="float: right;">
                        <a onclick="exportTableToExcel('tabresumen','<?php echo $filename; ?>')" style="color: #fff;padding: 7px 15px;border-radius: 4px;background-color: #4CAF50;box-shadow: 1px 1px 4px 0px #0000009c;" href="javascript:void(0)">Exportar a Excel</a>
                    </div>

                <?php }
                        }?>

                    <h1>
                    <?php echo $img_empresa_madre1; ?> <?php echo $txt_res1; ?>  
                    <small>
                        <i class="icon-double-angle-right"></i>
                        &nbsp;ingresos, egresos y saldos <?php echo $txt_res; ?>.
                    </small>
                    </h1>

            </div><!-- /.page-header -->
            
 
                <input type="hidden" value="<?php echo $id_empresa;?>" name="id_empresa_guarda" id="id_empresa_guarda" />
                    <?php 


                

                /*foreach ($permisos_usuario as $permiso)
                    {
                      //array_push($valores, $res3->id_permiso);
                        echo "<pre>";
                        print_r($permiso->nombre_permiso);
                        echo "</pre>";
                    }*/
               
                    

                if(!empty($canitdad_meses)){

        
                        
                        require("view_resumen.php");    
                    
                
                }else{
                
                    echo '
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                        <i class="icon-remove"></i>
                        </button>
                        <strong>
                        Atenci&oacute;n!
                        </strong>
                        La empresa seleccionada <strong>"'.devuelve_nombre_empresa($id_empresa).'"</strong> no tiene el par&aacute;metro de visualizaci&oacute;n definido.<strong> Cont&aacute;ctese con el administrador del sistema</strong>
                        <br />
                    </div>';
                }
                ?>

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario" id="id_usuario" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="PrintOutString" style="display:none"></div>

                </div><!-- /.col -->


        </div><!-- /.main-content-inner -->

        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Person Form</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id_empresa" />
                            <input type="hidden" value="<?php echo $username;?>" name="usuario_guarda" />
                            <input type="hidden" value="1" name="id_empresa_guarda" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">RUT</label>
                                    <div class="col-md-9">
                                        <input name="rut_empresa" id="rut_empresa" placeholder="RUT" class="form-control"
                                            type="text" value="" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nombre</label>
                                    <div class="col-md-9">
                                        <input name="nombre_empresa" placeholder="Nombre" class="form-control" type="text"
                                            autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group" id="photo-preview">
                                    <label class="control-label col-md-3">Logo</label>
                                    <div class="col-md-9">Cancelar

                                        (Sin foto)
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" id="label-photo">Logo </label>
                                    <div class="col-md-9">
                                        <input name="logo_empresa" type="file">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Telefono</label>
                                    <div class="col-md-9">
                                        <input name="telefono_empresa" id="telefono_empresa" placeholder="Telefono"
                                            class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Direccion</label>
                                    <div class="col-md-9">
                                        <input name="direccion_empresa" placeholder="Direccion" class="form-control" type="text"
                                            autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Estado</label>
                                    <div class="col-md-9">
                                        <select name="estado" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


<script type="text/javascript">

function move(e){
    
        if(e.scrollTop()>120){
            e.addClass("fixed");
            $(".fixed #tbfix").attr("style","max-width: "+$("#tabresumen").width()+"px; background-color:#fff;");
        } else {
            $(".fixed #tbfix").removeAttr("style");
            e.removeClass("fixed");    
        }
    }

$(document).ready(function() {
    
    $("#id_empresa_usuario").change(function() {
        var ies = $('#id_empresa_usuario').val();
        var ius = $('#id_usuario').val();

        var select = 1;
        $(location).attr('href', '<?php echo base_url() ?>home_empresa/' + ies + '/' + ius);
    });

});



function exportTableToExcel(tableID, filename = ''){

    let downloadLink;
    let dataType = 'application/vnd.ms-excel';
    let tableSelectHeader = document.getElementById('tbfix');
    let tableSelectBody = document.getElementById(tableID);
    let tableHTMLHeader = tableSelectHeader.outerHTML;
    let tableHTMLBody = tableSelectBody.outerHTML;
    
    $('#PrintOutString').html(tableHTMLHeader + tableHTMLBody);
    $('#PrintOutString').find('input').each((i,o)=>{$(o).remove();});
    $('#PrintOutString').find('.btn-control').remove();
    $('#PrintOutString').find('.colspan-xls').attr("colspan", 3);
    /*let name_company = $('#company-name').val();
    $('#PrintOutString').find('.name-company-individual').html("<span>"+name_company+"</span>");*/
    
    tableSelect = document.getElementById('PrintOutString');
    
    tableHTML = tableSelect.outerHTML;

    //window.open('data:' + dataType + ',' + encodeURIComponent(tableHTML)); 
    
    //return (sa);
   
    // Specify file name

    filename = filename ? filename + '.xls' : 'Resumen_Flujo_Caja.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
   
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });

        navigator.msSaveOrOpenBlob( blob, filename);
    
    }else{

        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableHTML);
        // Setting the file name
        downloadLink.download = filename;
        //triggering the function
        downloadLink.click();
    }
}

function add_empresa() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar Empresa'); // Set Title to Bootstrap modal title
    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Logo'); // label photo upload
}

function save() {
    $('#btnSave').text('Guardando...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable
    var url;

    if (save_method == 'add') {
        url = "<?php echo site_url('save_empresa')?>";
    } else {
        url = "<?php echo site_url('update_empresa')?>";
    }

    var formData = new FormData($('#form')[0]);

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {

            if (data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass(
                    'has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                    i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        },

        error: function(jqXHR, textStatus, errorThrown) {
            //alert('Error al guardar o actualizar los datos.');
            $('#btnSave').text('Guardando...'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable
        }
    });
}
</script>