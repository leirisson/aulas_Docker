@extends('layouts.master')

@section('title', 'Entrar')

@section('content')

@if (session('mensagem'))
<div id="div-alert-status" class="alert {{session('classe','alert-info')}}">
    <button type="button" class="close">×</button>
    {{ session('mensagem') }}
</div>
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

@endif
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Registrar/Validar Frequência - Entrar</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/efetuarLogin') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="matricula" class="col-md-4 control-label">Matricula</label>

                            <div class="col-md-6">
                                <input id="matricula" type="text" class="form-control" name="matricula" autofocus required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary form-control">
                                    Entrar
                                </button>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="text-center">
                                <a href="{{route('welcome')}}">Voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
