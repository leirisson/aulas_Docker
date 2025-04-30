<!doctype html>
<html>
    <head>
        @include('includes.head')
        @yield('pagescript')
        @yield('pagecss')
        <style>
            .celula-logotipo{
                text-align: right;
            }
            
            .frequencia-nao-validada{
                color: red;
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <div class="container">

            @if($frequencia->status_id_dez < 3 && $frequencia->status_id_jan < 3)
            <table class="table table-bordered">
                <tr>
                    <td rowspan="4">
                        <b>Ops!</b>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td rowspan="4">
                        Frequência ainda não foi validada! Você só poderá gerar a versão em pdf após sua chefia imediata validar sua frequência.
                    </td>
                </tr>
            </table>

            @else

            <div class="div-tabela-frequencia-imprime">
                <table class="table table-bordered">
                    <tr>
                        <td rowspan="4">
                            <img src="{{URL::asset('img/brasao_1.png')}}">
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo-poder-judiciario" colspan="4">PODER JUDICIÁRIO</td>
                    </tr>

                    <tr>
                        <td class="titulo-frequencia" colspan="4">JUSTIÇA FEDERAL DE 1ª INSTÂNCIA DO AMAZONAS</td>
                    </tr>
                    <tr>
                        <td class="titulo-frequencia" colspan="4"><b>FOLHA DE FREQUÊNCIA - {{$frequencia->recesso->descricao}}</b></td>
                    </tr>
                    <tr>
                        <td class="celula-titulo" colspan="5">NOME DO SERVIDOR</td>
                    </tr>
                    <tr>
                        <td colspan="5"><b>{{$frequencia->servidorEscalado->matricula . " - " . $frequencia->servidorEscalado->nome}}</b></td>
                    </tr>
                    <tr>
                        <td class="celula-titulo" colspan="5">CONTROLE DE FREQUÊNCIA</td>
                    </tr>
                    <tr class="td-titulo">
                        <td class="td-titulo">DIA</td>
                        <td class="td-titulo">HORA DE CHEGADA 1</td>
                        <td class="td-titulo">HORA DE SAIDA 1</td>
                        <td class="td-titulo">HORA DE CHEGADA 2</td>
                        <td class="td-titulo">HORA DE SAIDA 2</td>
                    </tr>
                    @forelse($frequencia->eventos as $evento)
                    <tr>
                        <td class="vert-align">
                            {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($evento->dia_id)}}
                        </td>
                        <td>
                            @if($evento->entrada1 == null)
                            ------
                            @endif
                            {{$evento->entrada1}}
                        </td>
                        <td>
                            @if($evento->saida1 == null)
                            ------
                            @endif
                            {{$evento->saida1}}
                        </td>
                        <td>
                            @if($evento->entrada2 == null)
                            ------
                            @endif
                            {{$evento->entrada2}}
                        </td>
                        <td>
                            @if($evento->saida2 == null)
                            ------
                            @endif
                            {{$evento->saida2}}
                        </td>
                    </tr>
                    @empty
                    <option>Ops... Tente novamente mais tarde</option>
                    @endforelse
                    <tr>
                        <td class="celula-titulo" colspan=5>DADOS DA VALIDAÇÃO ELETRÔNICA</td>
                    </tr>
                    <tr>
                        <td class="celula-logotipo">
                            <img src="{{URL::asset('img/logo_assinatura.png')}}">
                        </td>
                        <td class="texto-dados-validacao" colspan=5>
                            @if($frequencia->status_id_dez > 2)
                            <p>Frequência referente a dezembro validada eletronicamente por <b>{{ $frequencia->avaliacoes[0]->servidorDez->nome}}</b>, em {{FormatacaoDataHelper::formatarDataValidacao($frequencia->avaliacoes[0]->data_avaliacao_dez) }} (horário local), conforme art. 1º, III, "b", da Lei 11.419/2006</p>
                            @else
                            <p class="frequencia-nao-validada">Frequência referente a dezembro ainda não validada.</p>
                            @endif
                            @if($frequencia->status_id_jan > 2)
                            <p>Frequência referente a janeiro validada eletronicamente por <b>{{ $frequencia->avaliacoes[0]->servidorJan->nome}}</b>, em {{FormatacaoDataHelper::formatarDataValidacao($frequencia->avaliacoes[0]->data_avaliacao_jan) }} (horário local), conforme art. 1º, III, "b", da Lei 11.419/2006</p>
                            @else
                            <p class="frequencia-nao-validada">Frequência referente a janeiro ainda não validada.</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            @endif



        </div>
    </body>
</html>


