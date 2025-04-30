<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if (AutenticacaoHelper::checkAreaComumLogado() || AutenticacaoHelper::checkAreaAdminLogado() )
            <a class="navbar-brand" href="{{route('efetuar-logout')}}">{{config('app.name')}}</a>
            @else
            <a class="navbar-brand" href="{{route('welcome')}}">{{config('app.name')}}</a>
            @endif
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if (AutenticacaoHelper::checkAreaComumLogado())
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('registrar-frequencia') ? 'active' : '' }}"><a href="{{route('registrar-frequencia')}}">Registrar Frequência<span class="sr-only">(current)</span></a></li>
                <li class="{{ Request::is('registrar-frequencia/selecionar') ? 'active' : '' }}"><a href="{{route('frequencia-selecao')}}">Minhas Frequências<span class="sr-only">(current)</span></a></li>

                <li class="{{ Request::is('avaliar-frequencia') ? 'active' : '' }}"><a href="{{route('avaliar-index')}}">Validar Frequências<span class="sr-only">(current)</span></a></li>


            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-lock"></span>
                        @if (session('nome_servidor_logado'))  
                        {{session('nome_servidor_logado')}}
                        @else
                        {{session('matricula_servidor_logado')}}
                        @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('efetuar-logout')}}"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Sair</a></li>
                    </ul>
                </li>

            </ul>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>