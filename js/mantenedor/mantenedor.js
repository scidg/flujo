
$(document).ready(function() {

var regex = /^(.+?)(\d+)$/i;
var cloneIndex = $(".clonedInput").length;

if ($(".clonedInput").length == 1) {
        $('.remove').hide();
    } else {
        $('.remove').show();
    }

function clone(){

    $(this).parents(".clonedInput").clone()
        .appendTo(".bodyClone")
        .attr("id", "clonedInput" +  cloneIndex)
        .find('*')
        .each(function(){
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
            }
        })
        .on('click', '.clone', clone)
        .on('click', '.remove', remove);

        cloneIndex++;

        if ($(".clonedInput").length == 1) {
            $('.remove').hide();
        } else {
            $('.remove').show();
        }

}

function remove(){
    $(this).parents(".clonedInput").remove();

    if ($(".clonedInput").length == 1) {
    $('.remove').hide();
} else {
    $('.remove').show();
}

}

//$(".clone").on("click", clone);
$(".remove").on("click", remove);

});

    function consulta_nombre(nombre,tabla)
    {   
        var acc = $("#accion").val();
        var campo = 'nombre_'+tabla;
        if(tabla=='malla_societaria'){
            campo = 'nombre_socio';
        } 
        
        var empresa = $("#id_empresa_guarda").val();
        var mensaje_nombre_existente = ' esta Empresa';

        if(tabla=='empresa'){
            mensaje_nombre_existente = ' este Holding';
        }

        if(acc!='edit'){
          $.ajax({
            url : site_url+('ajax_consulta_nombre'),
            type: "POST",
            dataType: "JSON",
            data: {nom: nombre, tab: tabla, cam: campo, emp: empresa},
            success: function(data)
            {
              if(data){
                $(".nombre-existente").attr('style','visibility:show');
                $('.nombre-existente').parent().parent().addClass('has-error')
                $('.nombre-existente').html("* Nombre '<strong>"+ nombre.toUpperCase() + "</strong>' ya existe para "+mensaje_nombre_existente+". <br>Intente con otro Nombre.");
                /*$("#nombre_"+tabla).val('');
                $("#nombre_"+tabla).focus();*/
              }else{
                $('.nombre-existente').parent().parent().removeClass('has-error')
                $('.nombre-existente').empty();
              }
            }
          });
        }
    }


    function consulta_rut(nombre,tabla)
    {   
        var acc = $("#accion").val();
        var campo = 'rut_'+tabla;
        if(tabla=='malla_societaria'){
            campo = 'nombre_socio';
        } 
        
        var empresa = $("#id_empresa_guarda").val();
        var mensaje_nombre_existente = ' esta Empresa';

        if(tabla=='empresa'){
            mensaje_nombre_existente = ' este Holding';
        }

        if(acc!='edit'){
          $.ajax({
            url : site_url+('ajax_consulta_rut'),
            type: "POST",
            dataType: "JSON",
            data: {nom: nombre, tab: tabla, cam: campo, emp: empresa},
            success: function(data)
            {
              if(data){
                $(".rut-existente").attr('style','visibility:show');
                $('.rut-existente').parent().parent().addClass('has-error')
                $('.rut-existente').html("* RUT '<strong>"+ nombre.toUpperCase() + "</strong>' ya existe para "+mensaje_nombre_existente+". <br>Intente con otro.");
                /*$("#nombre_"+tabla).val('');
                $("#nombre_"+tabla).focus();*/
              }else{
                $('.rut-existente').parent().parent().removeClass('has-error')
                $('.rut-existente').empty();
              }
            }
          });
        }
    }

    function check_all(idm){

      
      if(idm ==1){

      var first = $('[id="codigo_permiso100"]:first').val();
      var last = $('[id="codigo_permiso102"]:last').val();

      if($("#codigo_modulo"+idm).prop('checked')){
          
            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
              //$("#puedes"+i).html("Puedes&nbsp;"); 
            }

          }else{

            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
              //$("#puedes"+i).html("No Puedes&nbsp;"); 
            }

          }

      }else if(idm ==2){

      var first = $('[id="codigo_permiso200"]:first').val();
      var last = $('[id="codigo_permiso201"]:last').val();

      if($("#codigo_modulo"+idm).prop('checked')){
          
            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
              //$("#puedes"+i).html("Puedes&nbsp;"); 
            }

          }else{

            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
              //$("#puedes"+i).html("No Puedes&nbsp;"); 
            }

          }

      }else if(idm ==3){

      var first = $('[id="codigo_permiso300"]:first').val();
      var last = $('[id="codigo_permiso311"]:last').val();

      if($("#codigo_modulo"+idm).prop('checked')){
          
            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
              // $("#puedes"+i).html("Puedes&nbsp;"); 
            }

          }else{

            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
              //$("#puedes"+i).html("No Puedes&nbsp;"); 
            }

          }

      }else if(idm ==4){

      var first = $('[id="codigo_permiso400"]:first').val();
      var last = $('[id="codigo_permiso410"]:last').val();

      if($("#codigo_modulo"+idm).prop('checked')){
          
            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
              //$("#puedes"+i).html("Puedes&nbsp;"); 
            }

          }else{

            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
              //$("#puedes"+i).html("No Puedes&nbsp;"); 
            }

          }
      }else if(idm ==5){

      var first = $('[id="codigo_permiso500"]:first').val();
      var last = $('[id="codigo_permiso500"]:last').val();

      if($("#codigo_modulo"+idm).prop('checked')){
          
            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
              // $("#puedes"+i).html("Puedes&nbsp;"); 
            }

          }else{

            for(var i = first; i <= last; i++){
              $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
              //$("#puedes"+i).html("No Puedes&nbsp;"); 
            }

          }
        }else if(idm ==6){
          var first = $('[id="codigo_permiso600"]:first').val();
        var last = $('[id="codigo_permiso613"]:last').val();
  
        if($("#codigo_modulo"+idm).prop('checked')){
            
              for(var i = first; i <= last; i++){
                $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
                // $("#puedes"+i).html("Puedes&nbsp;"); 
              }
  
            }else{
  
              for(var i = first; i <= last; i++){
                $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
                //$("#puedes"+i).html("No Puedes&nbsp;"); 
              }
  
            }
          
          }else if(idm ==7){
            var first = $('[id="codigo_permiso700"]:first').val();
          var last = $('[id="codigo_permiso700"]:last').val();
    
          if($("#codigo_modulo"+idm).prop('checked')){
              
                for(var i = first; i <= last; i++){
                  $('[type="checkbox"][value="'+i+'"]').prop( "checked", true );
                  // $("#puedes"+i).html("Puedes&nbsp;"); 
                }
    
              }else{
    
                for(var i = first; i <= last; i++){
                  $('[type="checkbox"][value="'+i+'"]').prop( "checked", false );
                  //$("#puedes"+i).html("No Puedes&nbsp;"); 
                }
    
              }
          }
}
