<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use App\Models\Recesso;


class AutenticacaoController extends Controller {

    use ValidacaoLDAP;

    public function recessoAtivo() {
        $recesso = Recesso::where('ativo', 1)
                ->orderBy('ano', 'desc')
                ->first();
        return $recesso;
    }

    public function index() {
        if (\AutenticacaoHelper::checkAreaComumLogado()) {
            return redirect()->intended('registrar-frequencia/selecionar');
        }
        return view('auth.login');
        //return view('auth.maquina-sepag-desligada');
    }

    public function adminIndex() {
        if (\AutenticacaoHelper::checkAreaAdminLogado()) {
            return redirect()->intended('admin-secap/painel');
        }
        return view('auth-admin.login');
    }

    public function efetuarLogin(Request $request) {
        $matricula = $request->matricula;
        $senha = $request->password;
        if ($this->valida_ldap($matricula, $senha)) {
            $request->session()->put('matricula_servidor_logado', strtoupper($request->matricula));
            $servidor = null;
            try {
                $servidor = Servidor::where('matricula', $matricula)->first();
            } catch (\PDOException $e) {
                $request->session()->flash('mensagem', 'Houve um problema ao tentar se conectar com o banco de dados.');
                $request->session()->flash('classe', 'alert-danger');
                return redirect()->intended('login');
            }
            $servidor = Servidor::where('matricula', $matricula)->first();

            if ($servidor) {

                $request->session()->put('nome_servidor_logado', $servidor->nome);
                $request->session()->put('id_servidor_logado', $servidor->id);
                $request->session()->put('area_comum', 'area_comum');

                return redirect()->intended('registrar-frequencia');
            } else {
                $request->session()->flash('mensagem', 'Servidor não cadastrado no sistema. Entre em contato com a Sepag.');
                $request->session()->flash('classe', 'alert-danger');
                return redirect()->intended('login');
            }
            return redirect()->intended('registrar-frequencia/selecionar');
        }
        $request->session()->flash('mensagem', 'Matrícula ou senha incorretos. Tente novamente.');
        $request->session()->flash('classe', 'alert-danger');
        return redirect()->intended('login');
    }

    public function efetuarLoginAdmin(Request $request) {
        $matricula = $request->matricula;
        $senha = $request->password;
        $area = $request->area_admin;
        $servidor = null;
        try {
            $servidor = Servidor::where('matricula', $matricula)->first();
        } catch (\PDOException $e) {
            $request->session()->flash('mensagem', 'Houve um problema ao tentar se conectar com o banco de dados.');
            $request->session()->flash('classe', 'alert-danger');
            return redirect()->intended('login-admin');
        }
        if (
                $servidor &&
                $this->valida_ldap($matricula, $senha) &&
                (
                ($servidor->admin_sepag && $area == "SEPAG")
                )
        ) {
            $request->session()->put('matricula_servidor_logado', strtoupper($request->matricula));
            $request->session()->put('nome_servidor_logado', $servidor->nome);
            $request->session()->put('id_servidor_logado', $servidor->id);
            $request->session()->put('administrador_logado', $area);
            if ($area == "SEPAG")
                return redirect()->intended('admin-secap/painel');
        }
        $request->session()->flash('mensagem', 'Matrícula ou senha incorretos. Tente novamente.');
        $request->session()->flash('classe', 'alert-danger');
        return redirect()->intended('login-admin');
    }

    public function efetuarLogout(Request $request) {
        $request->session()->flash('mensagem', 'Saída efetuada com sucesso!');
        $request->session()->flash('classe', 'alert-success');
        $request->session()->flush();
        return redirect()->intended('/');
    }

}
