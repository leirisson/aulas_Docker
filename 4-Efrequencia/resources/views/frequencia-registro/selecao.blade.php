@extends('layouts.master')

@section('title', 'Minhas Frequências')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js?1') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nucre-regras-negocio.js?1') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/frequencias/frequencias-script.js?3')}}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<link rel="stylesheet" href="{{ URL::asset('css/frequencias/frequencias-style.css')}}">
<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
    .nao-exibir { display: none;}

    .exibir { display: "";}
    .modal-escala {
        /* new custom width */
        width: 70%;
        overflow-y: initial !important
    }
    .modal-body-escala{
        height: 400px;
        overflow-y: auto;
    }
</style>
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
    <legend>Minhas Frequências
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Aqui é exibida uma lista com suas frequências. Clique sobre um registro da tabela para ver as opções. Nas frequências com Status 'EM ABERTO', é possível redefinir a chefia caso seja necessário">?
        </button>
    </legend>
</fieldset>  
<!-- Tabela Frequencias -->
<table id="tabela-frequencias" 
       class="table table-hover table-striped table-bordered" 
       data-url="listar-frequencias"
       data-toolbar="#div-toolbar-tabela"
       data-pagination="true"
       data-sort-name="servidor_escalado.nome"
       data-id-field="id"> 

    <thead>
        <tr>
            <th data-field="servidor_escalado.matricula" data-sortable="true">Matrícula</th>
            <th data-field="servidor_escalado.nome" data-sortable="true"  data-formatter="formatarComoLink">Nome</th> 
            <th data-field="recesso.descricao" data-sortable="true">Ano</th>   
            <th data-field="avaliacoes" data-sortable="true" data-formatter="formatarChefiaAvaliacaoDez">Dezembro Validada Por</th>
            <th data-field="avaliacoes" data-sortable="true" data-formatter="formatarChefiaAvaliacaoJan">Janeiro Validada Por</th>
            <th data-field="status_dez" data-sortable="true"status.status_descricao data-formatter="formatarStatusFrequenciaComDicaDez">Status Dezembro</th> 
            <th data-field="status_jan" data-sortable="true"status.status_descricao data-formatter="formatarStatusFrequenciaComDicaJan">Status Janeiro</th> 
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
    <li data-item="redefinir-chefia" class="frequencia-aberta redefinir-chefia"><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Redefinir Chefia para Validação</a></li>
    <li class="divider"></li>
    <li data-item="pagina-pdf" ><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Página para Geração PDF</a></li>
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