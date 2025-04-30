@extends('layouts.master')

@section('title', 'NUCRE - Controle de Frequência - Home')

@section('content')

@section('pagecss')
<style>


    .full-height {
        height: 50vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 20px;
        color: #868584;
    }

    .subtitle {
        font-size: 20px;
    }
    /*
        .m-b-md {
            margin-bottom: 30px;
        }*/
    .links {
        padding-top: 20px;
    }
    .links > a {
        color: #265a88;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        /*        text-decoration: none;*/
        text-transform: uppercase;
    }
    .blink_text {
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 2s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;

        -moz-animation-name: blinker;
        -moz-animation-duration: 2s;
        -moz-animation-timing-function: linear;
        -moz-animation-iteration-count: infinite;

        animation-name: blinker;
        animation-duration: 2s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        color: black;
    }

    @-moz-keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @-webkit-keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }
    .aviso{
        margin-top: 150px;
    }
</style>
@stop
@section('pagescript')
<script>
    //timing the alert box to close after 5 seconds
    window.setTimeout(function () {
        $("#div-alert-status").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);

    //Adding a click event to the 'x' button to close immediately
    $('.alert .close').on("click", function (e) {
        $(this).parent().fadeTo(500, 0).slideUp(500);
    });
</script>
@stop

@if (session('mensagem'))
<div id="div-alert-status" class="alert {{session('classe','alert-info')}}">
    <button type="button" class="close">×</button>
    {{ session('mensagem') }}
</div>


@endif
<div class="container">
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                <img src="{{URL::asset('img/logo_sj.png')}}" height="140px">
            </div>
            <div class="title m-b-md">
                NUCRE - SJAM
            </div>
            <div class="subtitle m-b-md">
                O expediente da Seção de Pagamento está encerrado por hoje. Registre sua frequência amanhã.
            </div>
            <div class="form-group text-center">
                <div class="text-center">
                    <p>A Seinf está trabalhando para que o Sistema de Frequência fique sempre on-line durante o recesso.</p>
                    <p>Em caso de dúvidas, envie e-mail para Seção de Pagamento (sepag.am@trf1.jus.br).</p>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="text-center">
                    <a href="{{route('welcome')}}">Voltar</a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

