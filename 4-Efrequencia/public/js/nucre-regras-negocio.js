//1	EM ABERTO
//2	AGUARDANDO DE ACORDO TITULAR
//3	AVALIADA

//Verifica se a FREQUENCIA nao foi avaliada
function verificaStatusFechado(statusAtual) {
    if (statusAtual > 1) {
        return true;
    }
    return false;
}

function verificaStatusFechadoPorMes(evento) {
    var mes = evento.dia_id.split('-')[1];
    if (evento.frequencia.status_id_dez > 1 && mes === '12') {
        return true;
    }
    if (evento.frequencia.status_id_jan > 1 && mes === '01') {
        return true;
    }
    return false;
}

function verificaEscaladoDez(frequencia) {
    this.mes = '';
    this.escaladoDezembro = false;
    var self = this;
    $.each(frequencia.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '12') {            
            self.escaladoDezembro = true;
            return false;
        }
    });
    if (self.escaladoDezembro) {
        return true;
    }
    return false;
}

function verificaEscaladoJan(frequencia) {
    this.mes = '';
    this.escaladoJaneiro = false;
    var self = this;
    $.each(frequencia.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '01') {            
            self.escaladoJaneiro = true;
            return false;
        }
    });
    if (self.escaladoJaneiro) {
        return true;
    }
    return false;
}