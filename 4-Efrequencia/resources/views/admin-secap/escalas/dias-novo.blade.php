<!-- HTML a ser carregado via AJAX ao se selecionar um recesso no select-recessos -->
<div id='div-listagem-dias' class="row">
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Escalado</th>
                    <th>Preferência Conversão</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodoAnoAtual as $dia)
                <tr>
            <input type="hidden" name="dia_id|{{$dia}}" value="{{$dia}}"/>
            <td class="vert-align">
                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($dia)}}
            </td>
            <td>
                <input name="escalado-dia|{{$dia}}" type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
            </td>
            <td>
                <div name="div-opcao-dia|{{$dia}}" class="nao-exibir">
                    <input name="opcao-dia|{{$dia}}" type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                </div>
            </td>
            </tr>
            @empty
            <option>Ops... Tente novamente mais tarde</option>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Escalado</th>
                    <th>Preferência Conversão</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodoAnoProximo as $dia)
                <tr>
            <input type="hidden" name="dia_id|{{$dia}}" value="{{$dia}}"/>
            <td class="vert-align">
                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($dia)}}
            </td>
            <td>
                <input name="escalado-dia|{{$dia}}" type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
            </td>
            <td>
                <div name="div-opcao-dia|{{$dia}}" class="nao-exibir">
                    <input name="opcao-dia|{{$dia}}" type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                </div>
            </td>
            </tr>
            @empty
            <option>Ops... Tente novamente mais tarde</option>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    /*Configurando os novos elementos
     * carregados nesta view
     */
    $("input[name*='escalado-dia']").bootstrapToggle();
    $("input[name*='opcao-dia']").bootstrapToggle();
    $("input[name*='escalado-dia']").change(function (event) {
        var dia = $(this).prop('name').split('|')[1];
        var nomeDivOpcaoRelacionada = "div-opcao-dia|" + dia;
        if ($(this).prop('checked')) {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").show();
        } else {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").hide();
        }

    });


</script>
<!--Fim Editar Escala-->

