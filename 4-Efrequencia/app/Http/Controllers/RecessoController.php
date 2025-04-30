<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Recesso;

class RecessoController extends Controller {

    private $tituloExibicao = 'Recesso';
    
    public function index() {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::get()->all();
        return view('admin-secap.recesso-configuracao.index')->with('recessos', $recessos);
    }

    public function listarRecessos() {
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        return response()->json($recessos);
    }

    public function adicionar(Request $request) {
        //dd($request);  
        $recesso = new Recesso;

        $recesso->ano = ($request->ano);
        $recesso->descricao = ($request->descricao);
        $recesso->processo = ($request->processo);
        $recesso->data_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $request->data_inicio)));
        $recesso->data_fim = date('Y-m-d', strtotime(str_replace('/', '-', $request->data_fim)));
        
        try {
            $recesso->save();
            $mensagem = 'Recesso cadastrado com sucesso!';
            $classe = 'sucess';
            return redirect()->route('recessos-index')->with([$classe => $mensagem]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar cadastrar recesso:' . $e->getMessage();
            $classe = 'error';
            return redirect()->route('recessos-index')->with([$classe => $mensagem]);
        }
    }

    public function mostrarEditar($id = null) {
        if($id != null){
            $recesso = Recesso::find($id);
        } else {
            $recesso = new Recesso();
        }
        return view('admin-secap.recesso-configuracao.cadastrar-editar')->with(['recesso' => $recesso,'tituloExibicao' => $this->tituloExibicao]);
    }

    public function alterar(Request $request) {

        $recesso = Recesso::find($request->recesso_id);

        $recesso->ano = ($request->ano);
        $recesso->descricao = ($request->descricao);
        $recesso->processo = ($request->processo);
        $recesso->ativo = ($request->ativo=='on'?1:0);
        $recesso->data_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $request->data_inicio)));
        $recesso->data_fim = date('Y-m-d', strtotime(str_replace('/', '-', $request->data_fim)));

        try {
            $recesso->save();
            $mensagem = 'Configuração alterada com sucesso!';
            $classe = 'sucess';
            return redirect()->route('recessos-index')->with([$classe => $mensagem]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar alterar configuração: ' . $e->getMessage();
            $classe = 'error';
            return redirect()->route('recessos-index')->with([$classe => $mensagem]);
        }
        
    }

}
