<?php
namespace VCOMedia\PhpCommon\Utility;

use Zend\Mvc\I18n\Translator;

//TODO:  remove zend dependency 
class TimeUtility {

    public static function ago($time, Translator $translator) {
       $lengths = array("60","60","24","7","4.35","12","10");
       $now = time();
       $difference = $now - $time;
       $tense = $translator->translate("ago");

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       $periods = array(
           $translator->translatePlural("second", "seconds", $difference),
           $translator->translatePlural("minute", "minutes", $difference),
           $translator->translatePlural("hour", "hours", $difference),
           $translator->translatePlural("day", "days", $difference),
           $translator->translatePlural("week", "weeks", $difference),
           $translator->translatePlural("month", "months", $difference),
           $translator->translatePlural("year", "years", $difference),
           $translator->translatePlural("decade", "decades", $difference)
           );

       return "$difference $periods[$j] $tense";
    }
}