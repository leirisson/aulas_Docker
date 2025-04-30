@extends('layouts.master_admin_secap')

@section('title', 'Recessos - Configurar')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/recessos/recessos-script.js') }}"></script>
@stop
@section('pagecss')

@stop
@section('content')

@include('includes.alert-bootstrap')


<fieldset>
    <legend>Recessos - Gerenciar
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Página para configurações de novos períodos de Recesso. Para liberação da frequência para os servidores, marcar a opção 'Aberto para Registro de Frequência'">?
        </button>
    </legend>
</fieldset>  

<!--Area botao Novo -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <button type="button" class="btn btn-success" id="button-novo"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo Recesso</button>
        </div>
    </div>
</div>
<!--Fim Area botao Novo-->

<!-- Tabela  -->
<table id="tabela" 
       class="table table-hover table-striped table-bordered" 
       data-url="{{route('retorna-lista-recessos')}}"
       data-search="true" 
       data-toolbar="#div-toolbar-tabela"
       data-show-refresh="true"
       data-pagination="true"
       data-show-export="true"
       data-export-types="['excel']"
       data-show-columns="true" 
       data-id-field="id"> 
    <thead>
        <tr>
            <!--<th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">ID</th>  -->
            <th data-field="ano" data-sortable="true">Ano</th>
            <th data-field="descricao" data-sortable="true">Descrição</th>         
            <th data-field="processo" data-sortable="true">Processo</th>
            <th data-field="ativo" data-sortable="true" data-formatter="formatarSimNao">Aberto para Registro de Frequência?</th>
            <th data-field="data_inicio" data-sortable="true" data-formatter="formatarPeriodoRecesso">Período</th>
            <th data-field="created_at" data-sortable="true" data-formatter="formatarDataHora">Cadastrado em</th>      
        </tr>
    </thead>
    <tbody id="tbody-tabela">

    </tbody>
</table>
<!-- Fim Tabela  -->

<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela" class="dropdown-menu">
    <li data-item="alterar"><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Alterar</a></li>
</ul>
<!-- Fim Opcoes Menu Contexto -->
@stop