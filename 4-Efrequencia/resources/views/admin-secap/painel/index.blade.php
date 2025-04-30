@extends('layouts.master_admin_secap')

@section('title', 'Painel Recesso')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/painel/painel-script.js') }}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('css/painel/painel-style.css')}}">
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

<!--Area botao Novo Servidor-->

<fieldset>
    <legend>Painel - Recesso
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="No painel é possível acompanhar o andamento do registro de frequências. Pendências ficam nos cartões vermelhos">?
        </button> 
    </legend>
</fieldset>  
<!--Fim Area botao Novo Servidor-->
<div class="form-group row">
    <div class="col-sm-5">
        <select class="form-control" id="select-recessos" name="recesso_id" required style="width: 100%">
            @forelse($recessos as $recesso)
            <option value="{{$recesso->id}}" {{$recesso->id == $idRecesso?"selected":""}}>{{$recesso->descricao}}</option>
            @empty
            <option>Nenhum servidor carregado</option>
            @endforelse
        </select>
    </div>
</div>

<fieldset><legend>Resumo das Escalações</legend>
</fieldset>  
<div class="form-group row">
    <div class="form-group col col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Total de Escalações<span class="total pull-right">{{count($frequencias)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequencias)}} é a quantidade de escalações para este recesso.
                </p>
            </div>
        </div>
    </div>
</div>

<fieldset><legend>Resumo das Frequências</legend>
</fieldset>  

<div class="form-group row">
    <div class="form-group col col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Total de Frequências <span class="total pull-right">{{count($frequenciasEscalacaoAprovada)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasEscalacaoAprovada)}} frequência(s) autorizada(s) para o recesso.
                </p>
            </div>
        </div>
    </div>
    <div class="form-group col col-sm-4">
        <div class="panel panel-danger">
            <div class="panel-heading">Total de Servidores que não definiram Chefia Imediata<span class="total pull-right">{{count($servidoresQueNaoDefiniramChefia)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($servidoresQueNaoDefiniramChefia)}} servidores que <b>não</b> definiram chefia imediata. Logo, não iniciaram o registro de frequência.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-servidores-sem-chefia">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<fieldset><legend>Resumo das Frequências - Dezembro</legend>
</fieldset>  

<div class="form-group row">
    <div class="form-group col col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading">Total de Frequências Validadas - Dezembro <span class="total pull-right">{{count($frequenciasAvaliadasDez)}} </span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasAvaliadasDez)}} frequência(s) de Dezembro avaliada(s) pela(s) chefias.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-avaliadas-dez">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group col col-sm-4">
        <div class="panel panel-danger">
            <div class="panel-heading">Total de Frequências Aguardando Validação Chefia - Dezembro<span class="total pull-right">{{count($frequenciasAguardandoValidacaoChefiaDez)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasAguardandoValidacaoChefiaDez)}} frequência(s) de Dezembro aguardando de acordo das chefias.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-aguardando-chefia-dez">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group col col-sm-4">
        <div class="panel panel-danger">
            <div class="panel-heading">Total de Frequências Em Aberto - Dezembro<span class="total pull-right">{{count($frequenciasNaoAvaliadasDez)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasNaoAvaliadasDez)}} frequência(s) de Dezembro <b>não</b> enviadas para validação da(s) chefias.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-nao-avaliadas-dez">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<fieldset><legend>Resumo das Frequências - Janeiro</legend>
</fieldset>  

<div class="form-group row">

    <div class="form-group col col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading">Total de Frequências Validadas - Janeiro <span class="total pull-right">{{count($frequenciasAvaliadasJan)}} </span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasAvaliadasJan)}} frequência(s) de Janeiro avaliada(s) pela(s) chefias.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-avaliadas-jan">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="form-group col col-sm-4">
        <div class="panel panel-danger">
            <div class="panel-heading">Total de Frequências Aguardando de Acordo Chefia - Janeiro<span class="total pull-right">{{count($frequenciasAguardandoValidacaoChefiaJan)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasAguardandoValidacaoChefiaJan)}} frequência(s) de Janeiro aguardando de acordo das chefias.
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-aguardando-chefia-jan">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group col col-sm-4">
        <div class="panel panel-danger">
            <div class="panel-heading">Total de Frequências Em Aberto - Janeiro<span class="total pull-right">{{count($frequenciasNaoAvaliadasJan)}}</span></div>
            <div class="panel-body">
                <p>
                    {{count($frequenciasNaoAvaliadasJan)}} frequência(s) de Janeiro <b>não</b> não enviada(s) para validação da(s) chefia(s).
                </p>
                <div class="form-group">
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-default" id="button-abrir-modal-frequencias-nao-avaliadas-jan">
                            <i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="modal fade" id="modal-detalhes-servidores-escalados" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Servidores Escalados</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequencias as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->nome}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Sem Resultados
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detalhes-servidores-escalados-aprovados" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Servidores Escalados - Aprovados pela Chefia</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasEscalacaoAprovada as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->nome}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Sem Resultados
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detalhes-frequencias" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Todas</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasEscalacaoAprovada as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->nome}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Sem Resultados
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detalhes-frequencias-avaliadas-dez" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Validadas - Dezembro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasAvaliadasDez as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->nome}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Nenhuma frequência validada por enquanto...
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detalhes-frequencias-nao-avaliadas-dez" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Em Aberto - Dezembro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>                                        
                                        <th>Chefia Responsável Validação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasNaoAvaliadasDez as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->servidor_escalado_nome}}
                                        </td>
                                        <td>
                                            {{$frequencia->servidor_valida_nome}}
                                            <input type="hidden" class="emails-servidores-em-aberto-dez" value="{{$frequencia->email}}">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Nenhuma frequência com o Status "Em Aberto"
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <span id="span-lista-emails-servidores-em-aberto-dez">


                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button id="button-ver-lista-email-em-aberto-dez" type="button" class="btn btn-default pull-right">
                            Exibir Lista de Email dos Servidores Escalados
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-frequencias-aguardando-chefia-dez" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Aguardando de Acordo - Dezembro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>                                        
                                        <th>Chefia Responsável Validação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasAguardandoValidacaoChefiaDez as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->servidor_escalado_nome}}
                                        </td>
                                        <td>
                                            {{$frequencia->servidor_valida_nome}}
                                            <input type="hidden" class="emails-chefias-pendentes-frequencia" value="{{$frequencia->email}}">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Todas as frequências foram validadas
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <span id="span-lista-emails-pendencias-frequencia">


                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button id="button-enviar-emails-pendencias-frequencia" type="button" class="btn btn-default pull-right">
                            Exibir Lista de Email das Chefias
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detalhes-frequencias-avaliadas-jan" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Validadas - Janeiro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasAvaliadasJan as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->nome}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Nenhuma frequência validada por enquanto...
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-frequencias-aguardando-chefia-jan" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Aguardando de Acordo - Janeiro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>                                        
                                        <th>Chefia Responsável Validação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasAguardandoValidacaoChefiaJan as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->servidor_escalado_nome}}
                                        </td>
                                        <td>
                                            {{$frequencia->servidor_valida_nome}}
                                            <input type="hidden" class="emails-chefias-pendentes-frequencia" value="{{$frequencia->email}}">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Todas as frequências foram validadas
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <span id="span-lista-emails-pendencias-frequencia">


                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button id="button-enviar-emails-pendencias-frequencia" type="button" class="btn btn-default pull-right">
                            Exibir Lista de Email das Chefias
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-detalhes-frequencias-nao-avaliadas-jan" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Frequências - Em Aberto - Janeiro</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>                                        
                                        <th>Chefia Responsável Validação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($frequenciasNaoAvaliadasJan as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->servidor_escalado_nome}}
                                        </td>
                                        <td>
                                            {{$frequencia->servidor_valida_nome}}
                                            <input type="hidden" class="emails-servidores-em-aberto-jan" value="{{$frequencia->email}}">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Nenhuma frequência com o Status "Em Aberto"
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <span id="span-lista-emails-servidores-em-aberto-dez">


                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button id="button-ver-lista-email-em-aberto-jan" type="button" class="btn btn-default pull-right">
                            Exibir Lista de Email dos Servidores Escalados
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-servidores-sem-chefia" role="dialog">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Servidores Sem Chefia</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servidor</th>  
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($servidoresQueNaoDefiniramChefia as $frequencia)
                                    <tr>
                                        <td>
                                            {{$frequencia->servidor_escalado_nome}}
                                        </td>
                                        <td>
                                            {{$frequencia->servidor_escalado_email}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            Tudo ok.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <span id="span-lista-emails-pendencias-frequencia">


                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop