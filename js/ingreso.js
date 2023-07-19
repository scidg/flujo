
function formatNumber(num) {

    
    if (!num || num == 'NaN') return '-';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);

}
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
        $('.remove').hide();
    } else {
        $('.remove').show();
    }


function hoyFecha(){

        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        
        if (dd < 10) {dd = '0' + dd;}
        if (mm < 10) {mm = '0' + mm;}

        return dd+'-'+mm+'-'+yyyy;
}

function clone(){
    
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
                
                $("#id_movimiento_detalle_"+cloneIndex).val('');

                $("#id_tipo_documento_"+cloneIndex).val('');
                $('[id="id_tipo_documento_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="id_tipo_documento_'+cloneIndex+'"]').next().empty();

                $("#numero_tipo_documento_"+cloneIndex).val('');
                $('[id="numero_tipo_documento_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="numero_tipo_documento_'+cloneIndex+'"]').next().empty();

                $("#monto_"+cloneIndex).val('');
                $('[id="monto_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="monto_'+cloneIndex+'"]').next().empty();

                $("#fecha_ingreso_"+cloneIndex).val();
                $('[id="fecha_ingreso_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="fecha_ingreso_'+cloneIndex+'"]').next().empty();
 
                $("#fecha_pago_"+cloneIndex).val('');
                $('[id="fecha_pago_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="fecha_pago_'+cloneIndex+'"]').next().empty();

                $("#periodo_iva_"+cloneIndex).attr('style','visibility:hidden');
                $('[id="periodo_iva_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="periodo_iva_'+cloneIndex+'"]').next().empty();

                $("#id_tipo_estado_movimiento_"+cloneIndex).val('');
                $('[id="id_tipo_estado_movimiento_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="id_tipo_estado_movimiento_'+cloneIndex+'"]').next().empty();

                $("#id_banco_"+cloneIndex).val('');
                $('[id="id_banco_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="id_banco_'+cloneIndex+'"]').next().empty();

                $("#id_condicion_pago_"+cloneIndex).val('');
                $('[id="id_condicion_pago_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="id_condicion_pago_'+cloneIndex+'"]').next().empty();

                $("#numero_voucher_"+cloneIndex).val('');
                $('[id="numero_voucher_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="numero_voucher_'+cloneIndex+'"]').next().empty();

                $("#observaciones_"+cloneIndex).val('');   
                $('[id="observaciones_'+cloneIndex+'"]').parent().removeClass('has-error');
                $('[id="observaciones_'+cloneIndex+'"]').next().empty();
                
            }
        })
        .find('.date-picker')
        .prop("disabled",false)
        .removeClass('hasDatepicker')
    	  .removeData('datepicker')
    	  .unbind()
    	  .datepicker({
            todayBtn: false,
            language: "es",
            autoclose: true,
            todayHighlight: false,
            daysOfWeekDisabled: "0,6",
            weekStart: 1
          })
        .each(function(){
            var id_in = this.id || "";
            var match_in = id_in.match(regex) || [];
            if (match_in.length == 3) {
                this.id_in = match_in[1] + (cloneIndex);
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

        //$("#cloneIndex_aux").val(cloneIndex);
}

function remove(){

    /*console.log("---inicio--remove---");
    console.log("cloneIndex:"+cloneIndex);
    console.log("cant_2:"+cant_2);
    console.log("---fin--remove---");*/


    var d = $("#cant_mov_det2").val();
    d--;
    cloneIndex--;

    $(this).parents(".clonedInput").remove();

    if ($(".clonedInput").length == 1) {
        $('.remove').hide();
    } else {
        $('.remove').show();
    }
    
    $("#cant_mov_det2").val(d);

}



$(".clone").on("click", clone);
$(".remove").on("click", remove);
});
