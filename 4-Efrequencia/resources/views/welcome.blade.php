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

            <div class="subtitle m-b-md">
                Controle de Frequência - Recesso Judiciário
            </div>
            <!--Versão de config/app.php-->

            <div class="links">
                <a href="{{route('login-servidor')}}">Registrar/Validar Frequência</a>
            </div>

        </div>
    </div>

</div>
<div align="center" class="aviso">
    <div align="center"  style="width:30%;height:auto;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;background-color:#ffcccc;">
        <div style="margin: 10px;" class="links">
            <img border="0" src="{{URL::asset('img/google-chrome-icon.png')}}" width="55" height="55"/><br/>
            <font color="#000000" size="2"><span class="blink_text" ><b>AVISO</b></span>: Dê preferência ao navegador
            <b>Google Chrome</b> para o melhor funcionamento desta página.</font>
        </div>
    </div>

    <a href="{{route('login-admin')}}">Admin</a>
</div>


@endsection

