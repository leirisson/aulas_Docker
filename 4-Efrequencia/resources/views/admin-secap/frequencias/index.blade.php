@extends('layouts.master_admin_secap')

@section('title', 'Frequências')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>

<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nucre-regras-negocio.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre-calculo-horas.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/frequencias-secap/frequencias-secap-script.js')}}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-timepicker/css/bootstrap-timepicker.css')}}">

<link rel="stylesheet" href="{{ URL::asset('css/frequencias-secap/frequencias-secap-style.css')}}">

@stop
@section('content')

<!--Alerta Modal Bootstrap 1-->
<div class="modal fade" id="div-modal-msg-aguarde" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Aguarde...</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fim Alerta MOdal  Bootstrap 1-->
<!--Area botao Novo Frequencia-->

<fieldset>
    <legend>Frequências por Recesso 
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Na tabela, clique com o botão direito do mouse sobre um registro da tabela para ver as opções.">
            ?
        </button> 
    </legend>
</fieldset>  
<!-- Tabela Frequencias -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <select class="form-control" id="select-recessos" name="recesso_id" required style="width: 100%">
                @forelse($recessos as $recesso)
                <option value="{{$recesso->id}}" {{$recesso->id == $idRecesso?"selected":""}}>{{$recesso->descricao}}</option>
                @empty
                <option>Nenhum servidor carregado</option>
                @endforelse
            </select>
        </div>
    </div>
</div>
<table id="tabela-frequencias" 
       class="table table-hover table-striped table-bordered" 
       data-search="true"
       data-url="{{route('listar-frequencia-recesso-secap')}}"
       data-toolbar="#div-toolbar-tabela"definir
       data-pagination="true"
       data-sort-name="servidor_escalado.nome"
       data-id-field="id"> 
    <thead>
        <tr>
            <th data-field="servidor_escalado.nome" data-sortable="true">Nome</th> 
            <th data-field="eventos" data-sortable="true" data-formatter="formatarTotalFrequencia">Total Horas</th>
            <th data-field="lotacao" data-sortable="true">Setor</th>
            <th data-field="avaliacoes" data-sortable="true" data-formatter="formatarChefiaAvaliacaoDez">Avaliação Dezembro</th>    
            <th data-field="avaliacoes" data-sortable="true" data-formatter="formatarChefiaAvaliacaoJan">Avaliação Janeiro</th>  
            <th data-field="status_dez.status_descricao" data-sortable="true" data-formatter="formatarStatusDezembro">Status Dezembro</th>   
            <th data-field="status_jan.status_descricao" data-sortable="true" data-formatter="formatarStatusJaneiro">Status Janeiro</th> 
        </tr>
    </thead>
    <tbody id="tbody-tabela-escalas">

    </tbody>
</table>
<!-- Fim Tabela Frequencias -->
<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela-frequencia" class="dropdown-menu">
    <li data-item="visualizar"><a><span class="glyphicon glyphicon-eye-open pull-left"></span>&nbsp;&nbsp;Visualizar</a></li>
    <li class="divider frequencia-aberta redefinir-chefia"></li>
    <li data-item="definir-chefia" class="frequencia-aberta redefinir-chefia"><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Redefinir Chefia que Valida Frequência</a></li>
    <li class="divider"></li>
    <li data-item="versao-pdf-dez"><a><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Versão para PDF - Dezembro</a></li>
    <li class="divider"></li>
    <li data-item="versao-pdf-jan"><a><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Versão para PDF - Janeiro</a></li>
</ul>
<!-- Fim Opcoes Menu Contexto -->

<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-visualizar-frequencia" role="dialog">
    <!--Corpo carregado de views/frequencia-registro/visualizar.blade.php-->
</div>
<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->

<!--Inicio Div para modal editar chefia. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-editar-chefia" role="dialog">
    <!--Corpo carregado de views/frequencia-registro/modal-editar-chefia.blade.php-->
</div>
<!--Fim Div para modal editar chefia. Seu conteudo é carregado via ajax-->
@stop