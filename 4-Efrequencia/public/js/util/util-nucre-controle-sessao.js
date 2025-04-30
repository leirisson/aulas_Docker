var c = 0;
tempo_modal_aviso = 10;
logout = true;
startTimer();
function startTimer() {
    /*
     * Tempo da sessao 2 horas (60 minutos * 60 segundos * 1000 (milessegundos) * 2 (duas horas)
     */
    mintuos = 60;
    tempo_sessao_milissegundos = mintuos * 60 * 1000 * 2
    setTimeout(function () {
        logout = true;
        c = 0;
        tempo_modal_aviso = 30;
        $('#timer').html(tempo_modal_aviso);
        $('#logout_popup').modal({
            backdrop: 'static',
            keyboard: false
        });
        startCount();

    }, tempo_sessao_milissegundos);
}

function resetTimer() {
    logout = false;
    $('#logout_popup').modal('hide');
    startTimer();
}

function timedCount() {
    c = c + 1;
    remaining_time = tempo_modal_aviso - c;
    if (remaining_time == 0 && logout) {
        $('#logout_popup').modal('hide');
        location.href = $('#a-logout').attr('href');
        ;

    } else {
        $('#timer').html(remaining_time);
        t = setTimeout(function () {
            timedCount();
        }, 1000);
    }
}

function startCount() {
    timedCount();
}


