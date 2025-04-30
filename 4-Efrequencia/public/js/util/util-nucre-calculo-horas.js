/**
 * Funcao utilizada em tabela para formatar exibição do total de horas de um dia da frequencia
 * @param {Object} value - Valor da linha da tabela
 * @param {Object} row - Objeto inteiro que está representado na linha
 * @returns {String}
 */
function formatarTotalDia(value, row) {
    return calcularTotalHoras(row.entrada1, row.saida1, row.entrada2, row.saida2);
}

/**
 * Função utilizada em tabela para formatar exibição do total de horas de uma frequencia inteira
 * @param {Object} value - Valor da linha da tabela
 * @param {Object} row - Objeto inteiro que está representado na linha
 * @returns {String}
 */
function formatarTotalFrequencia(value, row) {

    var total = "00:00";
    var subtotal;
    jQuery.each(value, function (i, evento) {
        subtotal = calcularTotalHoras(evento.entrada1, evento.saida1, evento.entrada2, evento.saida2);
        total = calcularSomaEntreDuasStringsHoraMinuto(total, subtotal);
    });

    return total;

}


/**
 * 
 * @param {String} horaMinutoEntrada1
 * @param {String} horaMinutoSaida1
 * @param {String} horaMinutoEntrada2
 * @param {String} horaMinutoSaida2
 * @returns {String}
 */
function calcularTotalHoras(horaMinutoEntrada1, horaMinutoSaida1, horaMinutoEntrada2, horaMinutoSaida2) {
    horaMinutoEntrada1 = (typeof horaMinutoEntrada1 !== 'undefined' && horaMinutoEntrada1 !== null) ? horaMinutoEntrada1 : ("00:00");
    horaMinutoSaida1 = (typeof horaMinutoSaida1 !== 'undefined' && horaMinutoSaida1 !== null) ? horaMinutoSaida1 : ("00:00");
    horaMinutoEntrada2 = (typeof horaMinutoEntrada2 !== 'undefined' && horaMinutoEntrada2 !== null) ? horaMinutoEntrada2 : ("00:00");
    horaMinutoSaida2 = (typeof horaMinutoSaida2 !== 'undefined' && horaMinutoSaida2 !== null) ? horaMinutoSaida2 : ("00:00");

    //Caso o servidor tenha preenchido somente a entrada 1 e saida 2, calculamos corretamente
    if (horaMinutoSaida1 === "00:00" && horaMinutoEntrada2 === "00:00" && horaMinutoEntrada1 !== "00:00" && horaMinutoSaida2 !== "00:00") {
        horaMinutoSaida1 = horaMinutoSaida2;
        horaMinutoSaida2 = "00:00";
    }

    return calcularSomaEntreDuasStringsHoraMinuto(calcularDiferencaEntreDuasStringsHoraMinuto(horaMinutoEntrada1, horaMinutoSaida1), calcularDiferencaEntreDuasStringsHoraMinuto(horaMinutoEntrada2, horaMinutoSaida2));

}

/**
 * 
 * @param {String} idInputEntrada
 * @param {String} idInputSaida
 */
function impedirHoraMinutoEntradaMaiorHoraMinutoSaida(idInputEntrada, idInputSaida) {

    var horaMinutoEntrada = document.getElementById(idInputEntrada).value;
    var horaMinutoSaida = document.getElementById(idInputSaida).value;

    var diferenca = calcularDiferencaEntreDuasStringsHoraMinuto(horaMinutoEntrada, horaMinutoSaida);
    if (diferenca === "00:00") {
        document.getElementById(idInputSaida).value = document.getElementById(idInputEntrada).value;
    }
}

/**
 * 
 * @param {String} horaMinutoString
 * @returns {Number|converteHoraMinutoStringEmSegundos.arrayHoraMinuto}
 */
function converteHoraMinutoStringEmSegundos(horaMinutoString) {
    var arrayHoraMinuto = horaMinutoString.split(':');
    return arrayHoraMinuto[0] * 3600 +
            arrayHoraMinuto[1] * 60;
}

/**
 * 
 * @param {String} horaInicio
 * @param {String} horaFim 
 * @returns {String} Hora no Formato String com a diferenca
 */
function calcularDiferencaEntreDuasStringsHoraMinuto(horaInicio, horaFim) {

    var diferencaEmSegundos = converteHoraMinutoStringEmSegundos(horaFim) - converteHoraMinutoStringEmSegundos(horaInicio);

    return converteSegundosEmStringHoraMinuto(diferencaEmSegundos);

}

/**
 * 
 * @param {String} horaInicio
 * @param {String} horaFim
 * @returns {String}
 */
function calcularSomaEntreDuasStringsHoraMinuto(horaInicio, horaFim) {

    var somaEmSegundos = converteHoraMinutoStringEmSegundos(horaInicio) + converteHoraMinutoStringEmSegundos(horaFim);

    return converteSegundosEmStringHoraMinuto(somaEmSegundos);

}

/**
 * 
 * @param {String} segundos
 * @returns {String}
 */
function converteSegundosEmStringHoraMinuto(segundos) {
    if (segundos < 0) {
        return "00:00";
    }
    var arrayMinutoSegundo = [
        Math.floor(segundos / 3600),
        Math.floor((segundos % 3600) / 60)
    ];

    return arrayMinutoSegundo.map(function (v) {
        return v < 10 ? '0' + v : v;
    }).join(':');
}

$(function () {
    if (false) {
        console.log("Teste Hora 1", calcularDiferencaEntreDuasStringsHoraMinuto("08:00", "08:30") === "00:30");
        console.log("Teste Hora 2", calcularDiferencaEntreDuasStringsHoraMinuto("08:00", "23:00") === "15:00");
        console.log("Teste Hora 3", calcularDiferencaEntreDuasStringsHoraMinuto("08:00", "08:00") === "00:00");
        console.log("Teste Hora 4", converteSegundosEmStringHoraMinuto(60) === "00:01");
        console.log("Teste Hora 5", converteSegundosEmStringHoraMinuto(600) === "00:10");
        console.log("Teste Hora 6", converteHoraMinutoStringEmSegundos("00:01") === 60);
        console.log("Teste Hora 7", converteHoraMinutoStringEmSegundos("00:10") === 600);
    }
});




