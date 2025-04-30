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
            <a class="navbar-brand" href="{{route('efetuar-logout')}}">{{config('app.name')}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('admin-secap/painel*') ? 'active' : '' }}"><a href="{{route('painel-index-sem-id')}}">Painel</a></li>
                <li class="{{ Request::is('admin-secap/escalas') ? 'active' : '' }}"><a href="{{route('escalas-index')}}">Escalações</a></li>
                <li class="{{ Request::is('admin-secap/frequencias') ? 'active' : '' }}"><a href="{{route('frequencias-por-recesso-secap')}}">Frequências - Totais</a></li>
                <li class="{{ Request::is('admin-secap/exportar-excel') ? 'active' : '' }}"><a href="{{route('exportar-excel')}}">Frequências - Exportar Excel</a></li>
                <li class="{{ Request::is('admin-secap/servidores') ? 'active' : '' }}"><a href="{{route('servidores-index')}}">Servidores - Gerenciar</a></li>
                <li class="{{ Request::is('admin-secap/recessos') ? 'active' : '' }}"><a href="{{route('recessos-index')}}">Recessos - Configurar</a></li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (AutenticacaoHelper::checkAreaAdminLogado())

                <li><a href="#">{{session('administrador_logado')}}</a></li>

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
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>