<?php

/* * *******************************************
  Funcao de validacao no AD via protocolo LDAP
  como usar:
  valida_ldap("usuario","senha");
  Usuario, neste caso, e a matricula do servidor.

 * ******************************************* */
namespace App\Http\Controllers;

trait ValidacaoLDAP {

    function valida_ldap($usuario, $senha) {

        //para teste
        //return true;
        //Usuario Padrão
        if($usuario=="am001" && $senha=="am001"){
            return true;
        }

        $ldap_server = \Illuminate\Support\Facades\Config::get("app.ldap_ip"); //IP ou nome do servidor vindo do arquivo /config/app.php
        $dominio = \Illuminate\Support\Facades\Config::get("app.ldap_dominio"); //Dominio vindo do arquivo /config/app.php
        $auth_user = strtoupper($usuario) . $dominio;

        // Tenta se conectar com o servidor
        if (!($connect = @ldap_connect($ldap_server))) {
            return false;
        }
        // Tenta autenticar no servidor
        if (!($bind = @ldap_bind($connect, $auth_user, $senha))) {
            // se nao validar retorna false
            return false;
        } else {
            // se validar retorna true
            return true;
        }
    }

}
