<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Servidor;

class ServidorController extends Controller
{
    public function index(){
        //Somente get() retorna uma collection. All retorna um array
        $servidores = Servidor::get()->all();
        return view('admin-secap.servidores.index')->with('servidores',$servidores);
    }
    
    public function listarServidores() {
        $servidores = Servidor::orderBy('nome', 'asc')->get()->all();
        return response()->json($servidores);
    }
    public function adicionar(Request $request) {
        //dd($request);  
        $servidor = new Servidor;

        $servidor->setNomeAttribute($request->nome_servidor);
        $servidor->setMatriculaAttribute($request->matricula_servidor);
        $servidor->setEmailAttribute($request->email_servidor);
        $servidor->setAdminSecap($request->admin_secap);
        $servidor->setAdminSepag($request->admin_sepag);
        try {
            $servidor->save();
            $mensagem = 'Servidor cadastrado com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar cadastrar servidor:' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }
    
    public function mostrarEditar($id) {
        $servidor = Servidor::find($id);
        return view('admin-secap.servidores.editar')->with(['servidor' => $servidor]);
    }

    public function alterar(Request $request) {

        $servidor = Servidor::find($request->servidor_id);


        $servidor->setNomeAttribute($request->nome_servidor);
        $servidor->setMatriculaAttribute($request->matricula_servidor);
        $servidor->setEmailAttribute($request->email_servidor);
        $servidor->setAdminSecap($request->admin_secap);
        $servidor->setAdminSepag($request->admin_sepag);
        
        try {
            $servidor->save();
            $mensagem = 'Servidor alterado com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar alterar servidor: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }
    
    public function deletar($id, Request $request) {
        try {
            Servidor::destroy($id);
            $mensagem = 'Servidor excluído com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar excluir servidor: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }
    
}
