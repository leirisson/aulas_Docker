<?php

/**
 * Description of AutenticacaoHelper
 * http://stackoverflow.com/questions/28290332/best-practices-for-custom-helpers-on-laravel-5
 * Create a helpers.php file in your app folder and load it up with composer:

  "autoload": {
  "classmap": [
  ...
  ],
  "psr-4": {
  "App\\": "app/"
  },
  "files": [
  "app/helpers.php" // <---- ADD THIS
  ]
  },
  After adding that to your composer.json file, run the following command:

  composer dump-autoload
 * @author Gleyton Lima
 */
class AutenticacaoHelper {

    public static function checkAreaComumLogado() {
        return session()->has('area_comum');
    }

    public static function checkAreaAdminLogado() {
        return session()->has('administrador_logado');
    }

    public static function getIdServidorLogado() {
        if (session()->has('id_servidor_logado')) {
            return session('id_servidor_logado');
        }

        return 'nome_usuario';
    }

    /**
     * Verifica se há na Sessão um usuário administrador da secap logado
     * @return boolean
     */
    public static function checaAdminSecapLogado() {
        if (session()->has('administrador_logado') && session('administrador_logado') == 'SECAP') {
            return true;
        }

        return false;
    }

    /**
     * Verifica se há na Sessão um usuário administrador da sepag logado
     * @return boolean
     */
    public static function checkLogadoChefiaEscalar() {
        if (session()->has('chefia_escalar_logada')) {
            return true;
        }
        return false;
    }
    
    
    /**
     * Verifica se há na Sessão uma chefia logada
     * @return boolean
     */
    public static function checaAdminSepagLogado() {
        if (session()->has('administrador_logado') && session('administrador_logado') == 'SEPAG') {
            return true;
        }
        return false;
    }

}
