$(document).ready(function() {

    $.getJSON('https://mindicador.cl/api', function(data) {
    var dailyIndicators = data;
    $("<p/>", {
            html: dailyIndicators.uf.valor
        });
        $("#valor_uf").val(dailyIndicators.uf.valor);
    }).fail(function() {
        console.log('Error al consumir la API!');
    });

});