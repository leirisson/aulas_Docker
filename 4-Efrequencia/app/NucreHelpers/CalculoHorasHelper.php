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
class CalculoHorasHelper {

    public static function somarDoisHorarios($horas1, $horas2) {

        $h = array();
        $h[] = $horas1;
        $h[] = $horas2;
        $minutes = 0;
        // loop throught all the times
        foreach ($h as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public static function diferencaDoisHorarios($firstTime, $lastTime) {

        if ($firstTime === "" && $lastTime === "") {
            return "00:00";
        }

        $firstTime = ($firstTime == null || $firstTime == "") ? "00:00" : $firstTime;
        $lastTime = ($lastTime == null || $lastTime == "") ? "00:00" : $lastTime;
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);
        $timeDiff = $lastTime - $firstTime;

        return gmdate("H:i", $timeDiff);
        //return (intval($timeDiff / 60 / 60)) . ":" . (((($timeDiff / 60 / 60)) - (intval($timeDiff / 60 / 60))) * 60);
    }

    public static function diferencaDoisHorariosMaior24h($firstTime, $lastTime) {

        if ($firstTime === "" && $lastTime === "") {
            return "00:00";
        }

        $firstTime = ($firstTime == null || $firstTime == "") ? "00:00" : $firstTime;
        $lastTime = ($lastTime == null || $lastTime == "") ? "00:00" : $lastTime;

        list($hora1, $minuto1) = explode(':', $firstTime);
        list($hora2, $minuto2) = explode(':', $lastTime);
        $hora1 = intval($hora1);
        $hora2 = intval($hora2);
        $minuto1 = intval($minuto1);
        $minuto2 = intval($minuto2);
        if ($minuto2 < $minuto1) {
            $minutofinal = $minuto2 - $minuto1 + 60;
            $horafinal = $hora2 - $hora1 - 1;
        } else {
            $minutofinal = $minuto2 - $minuto1;
            $horafinal = $hora2 - $hora1;
        }
        if ($horafinal < 10) {
            $horafinal = "0" . $horafinal;
        }
        if ($minutofinal < 10) {
            $minutofinal = "0" . $minutofinal;
        }
        return $horafinal.":".$minutofinal;
    }

}
