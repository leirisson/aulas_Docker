@if (AutenticacaoHelper::checkAreaComumLogado() || AutenticacaoHelper::checkAreaAdminLogado() )
@include('includes.modal-controle-sessao')
@endif


<div class="container">
    <p class="text-muted">{{config('app.name')}} - Versão {{config('app.version')}}</p>
</div>

