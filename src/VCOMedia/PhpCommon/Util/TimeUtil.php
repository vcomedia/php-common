<?php
namespace VCOMedia\PhpCommon\Util;

class TimeUtil {

    public static function ago($time, TranslatorInterface $translator) {
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

    public function timezoneOffsetSecondsToOffset($seconds) {
        $offset  = $seconds < 0 ? '-' : '+';
        $offset .= gmdate('H:i', abs($seconds));
        return $offset;
    }
    
    public static function timezoneOffsetSecondsToTimezoneName($seconds) {
        $timezoneAbbreviation = timezone_name_from_abbr('', $seconds, 1);
        if($timezoneAbbreviation === false) {
            $timezoneAbbreviation = timezone_name_from_abbr('', $seconds, 0);
        }        
        return $timezoneAbbreviation;
    }
    
    public static function timezoneOffsetSecondsToTimezoneAbbreviation($seconds) {
        $timezoneName = static::timezoneOffsetSecondsToTimezoneName($seconds);
        $dt = new DateTime('now', new DateTimeZone($timezoneName));
        return $dt->format('T');
    }
}

interface TranslatorInterface {
    public function translatePlural($singular, $plural, $number, $textDomain = 'default', $locale = null);
    public function translate($message, $textDomain = 'default', $locale = null);
}