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
class FormatacaoDataHelper {

    public static function formatarDataSqlToddmmyyyy($data) {
        $date = new DateTime($data);
        return $date->format("d/m/Y");
    }

    public static function inverteData($data) {
        if (count(explode("/", $data)) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        } elseif (count(explode("-", $data)) > 1) {
            return implode("/", array_reverse(explode("-", $data)));
        }
    }

    //
    public static function diaSemana($data) {
// Traz o dia da semana para qualquer data informada
        $dia = substr($data, 8, 2);
        $mes = substr($data, 5, 2);
        $ano = substr($data, 0, 4);
        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
        switch ($diasemana) {
            case"0": $diasemana = "Domingo";
                break;
            case"1": $diasemana = "Segunda-Feira";
                break;
            case"2": $diasemana = "Terça-Feira";
                break;
            case"3": $diasemana = "Quarta-Feira";
                break;
            case"4": $diasemana = "Quinta-Feira";
                break;
            case"5": $diasemana = "Sexta-Feira";
                break;
            case"6": $diasemana = "Sábado";
                break;
        }
        return "$diasemana";
    }

    public static function diaSemanaMenor($data) {
// Traz o dia da semana para qualquer data informada
        //2016-11-11
        $dia = substr($data, 8, 2);
        $mes = substr($data, 5, 2);
        $ano = substr($data, 0, 4);
        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
        switch ($diasemana) {
            case"0": $diasemana = "Dom";
                break;
            case"1": $diasemana = "Seg";
                break;
            case"2": $diasemana = "Ter";
                break;
            case"3": $diasemana = "Qua";
                break;
            case"4": $diasemana = "Qui";
                break;
            case"5": $diasemana = "Sex";
                break;
            case"6": $diasemana = "Sáb";
                break;
        }
        return "$diasemana";
    }

    public static function formatarDataSqlToddmmyyyyDiaSemana($data) {

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        return (strftime('%A, %d de %B de %Y', strtotime($data)));
    }

    public static function formatarDataValidacao($data) {

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        return (strftime('%d/%m/%Y %H:%M', strtotime($data)));
    }

    public static function formatarHHMM($stringHoraDoMySql) {
        if ($stringHoraDoMySql == "" || $stringHoraDoMySql == null) {
            return "00:00";
        }

        $format = 'H:i:s';
        $date = DateTime::createFromFormat($format, $stringHoraDoMySql);
        return $date->format('H:i');
    }

    public static function formatarHHMMmaior24h($stringHoraDoMySql) {
        if ($stringHoraDoMySql == "" || $stringHoraDoMySql == null) {
            return "00:00";
        }

        return explode(":", $stringHoraDoMySql)[0] . ":" . explode(":", $stringHoraDoMySql)[1];
    }

}
