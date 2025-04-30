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

<script type="text/javascript" src="{{ URL::asset('js/frequencias-exportar-excel/frequencias-script.js')}}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-timepicker/css/bootstrap-timepicker.css')}}">

<link rel="stylesheet" href="{{ URL::asset('css/frequencias-secap/frequencias-secap-style.css')}}">
<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
        text-align: center;
    }
    .nao-exibir { display: none;}

    .exibir { display: "";}
    .modal-escala {
        /* new custom width */
        width: 90%;
        overflow-y: initial !important
    }
    .modal-body-escala{
        height: 500px;
        overflow-y: auto;
    }

    /*    Cabecalho Fixo*/
    .header-fixed {
        width: 100% 
    }
    .header-fixed > thead > tr > th{height: 70px;text-align: center;}

    .header-fixed > thead,
    .header-fixed > tbody,
    .header-fixed > thead > tr,
    .header-fixed > tbody > tr,
    .header-fixed > thead > tr > th,
    .header-fixed > tbody > tr > td {
        display: block;
    }

    .header-fixed > tbody > tr:after,
    .header-fixed > thead > tr:after {
        content: ' ';
        display: block;
        visibility: hidden;
        clear: both;
    }

    .header-fixed > tbody {
        overflow-y: auto;
        height: 250px;
    }

    .header-fixed > tbody > tr > td,
    .header-fixed > thead > tr > th {
        width: 8.3333%;
        float: left;
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

<fieldset><legend>Entradas e Saídas para Exportar para Excel 
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Nesta página é possível exportar os registros como planilha do Excel clicando no botão ao lado da pesquisa acima da tabela">?
        </button> 
    </legend>
</fieldset>  
<!-- Tabela Frequencias -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <select class="form-control" id="select-recessos" name="recesso_id" required>
                @forelse($recessos as $recesso)
                <option value="{{$recesso->id}}" {{$recesso->id == $idRecesso?"selected":""}}>{{$recesso->descricao}}</option>
                @empty
                <option>Nenhum servidor carregado</option>
                @endforelse
            </select>
            <select class="form-control" id="select-mes-numero" name="mes_numero" required>
                <option value="12">Dezembro</option>
                <option value="1">Janeiro</option>
            </select>
            <select class="form-control" id="select-opcao-conversao-codigo" name="opcao_conversao_codigo" required>
                <option value="-1">Folga e Pagamento</option>
                <option value="1">Folga</option>
                <option value="0">Pagamento</option>
            </select>
        </div>
    </div>
</div>
<table id="tabela-frequencias" 
       class="table table-hover table-striped table-bordered" 
       data-search="true"
       data-url="{{route('gerar-json-exportar-excel')}}"
       data-toolbar="#div-toolbar-tabela"
       data-pagination="true"
       data-export-types="['excel']"
       data-show-export="true"
       data-sort-name="servidor_escalado.nome"
       data-id-field="id"> 
    <thead>
        <tr>
            <th data-field="matricula" data-sortable="true">MATRICULA</th> 
            <th data-field="nome" data-sortable="true">NOME</th>
            <th data-field="nome_chefia" data-sortable="true">NOME_CHEFIA</th>
            <th data-field="lotacao" data-sortable="true">LOTACAO</th>
            <th data-field="dia_id" data-sortable="true" data-formatter="formatarData">DIA</th>
            <th data-field="entrada1" data-sortable="true" data-formatter="formatarEntradasSaidas">ENTRADA_1</th>
            <th data-field="saida1" data-sortable="true" data-formatter="formatarEntradasSaidas">SAIDA_1</th>
            <th data-field="entrada2" data-sortable="true" data-formatter="formatarEntradasSaidas">ENTRADA_2</th>
            <th data-field="saida2" data-sortable="true" data-formatter="formatarEntradasSaidas">SAIDA_2</th>
            <th data-field="opcao" data-sortable="true" data-formatter="formatarOpcaoFolgaPagamento">OPCAO</th>
            <th data-field="status_descricao" data-sortable="true">STATUS</th>
        </tr>
    </thead>
    <tbody id="tbody-tabela-escalas">

    </tbody>
</table>
<!-- Fim Tabela Frequencias -->

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