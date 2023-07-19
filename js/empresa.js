$(document).ready(function() {


$('[data-rel=tooltip]').tooltip();

var regex = /^(.+?)(\d+)$/i;
var cloneIndex = $(".clonedInput").length;
var cant_2 = $("#cant_mov_det2").val();

/*console.log("---inicio--document---");
console.log("cloneIndex:"+cloneIndex);
console.log("cant_2:"+cant_2);
console.log("---fin--document---");*/

if ($(".clonedInput").length == 1) {
        $('.remove_serv').hide();
    } else {
        $('.remove_serv').show();
    }

function clone_servicios(){
    
    cant_2clone = $("#cant_mov_det2").val();
    
    /*console.log("-------------------");
    console.log("---inicio--clone---");
    console.log("cloneIndexclone:"+cloneIndex);
    console.log("cant_2clone:"+cant_2clone);
    console.log("---fin--clone---");*/

    //cloneIndex = cant_2clone;

    $(this).parents(".clonedInput").clone(true)
        .appendTo(".bodyClone")
        .attr("id", "clonedInput" +  cloneIndex)
        .find('*')
        .each(function() {
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
                
                /*var cant_2 = $("#cant_mov_det2").val();
                var cant_2_aux = $("#cant_mov_det2_aux").val();*/

                $("#cant_mov_det2").val(cloneIndex + 1);
                
                //$("#id_movimiento_detalle_"+cloneIndex).val('');

                $("#servicio_"+cloneIndex).val('');
                $('[id="servicio_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="monservicio_to_'+cloneIndex+'"]').next().empty();

                
            }
        })
        .on('click', '.clone_serv', clone_servicios)
        .on('click', '.remove_serv', remove_servicios);

        cloneIndex++;


        if ($(".clonedInput").length == 1) {
            $('.remove_serv').hide();
        } else {
            $('.remove_serv').show();
        }

        //$("#cloneIndex_aux").val(cloneIndex);
}

function remove_servicios(){

    /*console.log("---inicio--remove---");
    console.log("cloneIndex:"+cloneIndex);
    console.log("cant_2:"+cant_2);
    console.log("---fin--remove---");*/


    var d = $("#cant_mov_det2").val();
    d--;
    cloneIndex--;

    $(this).parents(".clonedInput").remove();

    if ($(".clonedInput").length == 1) {
        $('.remove_serv').hide();
    } else {
        $('.remove_serv').show();
    }
    
    $("#cant_mov_det2").val(d);

}



$(".clone_serv").on("click", clone_servicios);
$(".remove_serv").on("click", remove_servicios);
});
