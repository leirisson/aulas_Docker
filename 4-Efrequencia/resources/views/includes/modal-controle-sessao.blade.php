
<div class="modal fade" id="logout_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div style="width:100%;height:100%;margin: 0px; padding:0px">
                    <div style="width:25%;margin: 0px; padding:0px;float:left;">
                        <i class="fa fa-warning" style="font-size: 140px;color:#da4f49"></i>
                    </div>
                    <div style="width:70%;margin: 0px; padding:0px;float:right;padding-top: 10px;padding-left: 3%;">
                        <h4>Sua sessão está prestes a expirar!</h4>
                        <p style="font-size: 15px;">Você sairá automaticamente do sistema em <span id="timer" style="display: inline;font-size: 30px;font-style: bold">10</span> segundos.</p>				
                        <p style="font-size: 15px;">Deseja permanecer logado?</p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div style="margin-left: 30%;margin-bottom: 20px;margin-top: 20px;">
                <a href="javascript:;" onclick="resetTimer()" class="btn btn-primary" aria-hidden="true">Manter-me logado</a>
                <a id="a-logout" href="{{route('efetuar-logout')}}" class="btn btn-danger" aria-hidden="true">Sair do Sistema</a>
            </div>
        </div>
    </div>
</div>
