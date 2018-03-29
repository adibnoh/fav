<?php

namespace Adibnoh\Fav\Controllers;

use Carbon\Carbon;

class GlobalController
{

    /**
     * Create an instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /////////
    // Url //
    /////////

    /**
     * Convert string to url - append with http if string does not contain http
     */
    public function convertStringToUrl(String $url, String $protocol = 'https://')
    {
        if (!$url) {
            return;
        }
        $url = trim($url);
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $protocol . $url;
        }
        return $url;
    }

    /**
     * Build url with raw parameter
     */
    public function buildUrlWithRawParameter($url, $param)
    {
        return $url .'?'.http_build_query($param);
    }

    //////////////
    // DateTime //
    //////////////

    /**
     * [parseDate description]
     * @param $date            [description]
     * @param  String $date_format     [description]
     * @param  String $timezone        [description]
     * @param  String $return_format   [description]
     * @param  String $return_timezone [description]
     * @return [type]                  [description]
     */
    public function parseDate ($date, $date_format = null, $timezone = 'UTC', $return_format = 'Y-m-d H:i:s', $return_timezone = 'UTC')
    {

        if ($date) {

            if (is_object($date)) {

                if ($return_format == 'object' || $return_format == 'raw') {

                    return $date;
                
                } else {
                    
                    return $date->timezone($timezone)->format($return_format);
                
                }

            } else if ($date > 0) {
                
                if ($return_format == 'raw') {
                    
                    return $date;
                
                } else if ($return_format == 'object') {

                    if ($date_format && $timezone) {
                        
                        return Carbon::createFromFormat($date_format, $date, $timezone)->setTimezone($return_timezone);

                    } else {

                        return Carbon::parse($date)->timezone($timezone);

                    }
                
                } else if ($return_format == 'toDayDateTimeString') {

                    if ($date_format && $timezone) {
                        
                        return Carbon::createFromFormat($date_format, $date, $timezone)->setTimezone($return_timezone)->toDayDateTimeString();

                    } else {

                        return Carbon::parse($date)->timezone($timezone)->toDayDateTimeString();

                    }

                } else if ($return_format == 'toFormattedDateString') {

                    if ($date_format && $timezone) {
                        
                        return Carbon::createFromFormat($date_format, $date, $timezone)->setTimezone($return_timezone)->toFormattedDateString();

                    } else {

                        return Carbon::parse($date)->timezone($timezone)->toFormattedDateString();

                    }

                } else {

                    if ($date_format && $timezone) {
                        
                        return Carbon::createFromFormat($date_format, $date, $timezone)->setTimezone($return_timezone)->format($return_format);

                    } else {

                        return Carbon::parse($date)->timezone($timezone)->format($return_format);

                    }
                
                }
            
            } else {
            
                return null;
            
            }

        } else {

            return;

        }

    }

    ///////////
    // Color //
    ///////////

    public function HTMLToRGB($htmlCode)
    {
        if($htmlCode[0] == '#')
          $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3)
        {
          $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    public function RGBToHSL($RGB) 
    {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC)
        {
          $s = 0;
          $h = 0;
        }
        else
        {
          if($l < .5)
          {
            $s = ($maxC - $minC) / ($maxC + $minC);
          }
          else
          {
            $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
          }
          if($r == $maxC)
            $h = ($g - $b) / ($maxC - $minC);
          if($g == $maxC)
            $h = 2.0 + ($b - $r) / ($maxC - $minC);
          if($b == $maxC)
            $h = 4.0 + ($r - $g) / ($maxC - $minC);

          $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

    public function getContrastColor($hexColor) 
    {

        // add few exception
        $color_exception_white = ['#6d35a3'];

        if (in_array($hexColor, $color_exception_white)) {
            return 'white';
        }

        //////////// hexColor RGB
        $R1 = hexdec(substr($hexColor, 0, 2));
        $G1 = hexdec(substr($hexColor, 2, 2));
        $B1 = hexdec(substr($hexColor, 4, 2));

        
        $d = 0;

        // Counting the perceptive luminance - human eye favors green color... 
        $a = 1 - ( ( ( 0.299 * $R1 ) + ( 0.587 * $G1 ) + ( 0.114 * $B1 ) ) / 255 );

        if ($a < 0.3) {
           return 'black';
        }
        else {
           return 'white';
        }

    }

    public function isColorLight($color) 
    {
        $rgb = $this->HTMLToRGB($color);
        $hsl = $this->RGBToHSL($rgb);
        if($hsl->lightness > 200) {
          return true;
        } else {
            return false;
        }
    }

    public function isColorDark($color) 
    {
        $rgb = HTMLToRGB($color);
        $hsl = RGBToHSL($rgb);
        if($hsl->lightness < 200) {
          return true;
        } else {
            return false;
        }
    }

    /**
     *
     * This method return all value found in multidimensional array based on key/needle.
     * @param  Array $haystack [description]
     * @param  [type] $needle   [description]
     * @return [type]           [description]
     */
    public function array_column_recursive(Array $haystack, $needle) 
    {

        $found = [];

        array_walk_recursive($haystack, function($value, $key) use (&$found, $needle) {
            if ($key == $needle)
                $found[] = $value;
        });  
        
        return $found;
    }

    public function generateUniqueId() 
    { 
        $s = strtoupper(md5(uniqid(rand(),true))); 
        $guidText = 
            substr($s,0,8) . '-' . 
            substr($s,8,4) . '-' . 
            substr($s,12,4). '-' . 
            substr($s,16,4). '-' . 
            substr($s,20); 
        return $guidText;
    }

    /**
     * Calculate column bil in table view that display pagination
     */
    public function displayColumnBil($count, $currentPage, $key)
    {
        return ( $count * ( $currentPage - 1 ) ) + $key + 1;
    }

    /**
     * Concatenate Array into String with `and` before last item
     * example: 
     * $array = ['foo', 'bar', 'john'];
     * return smartImplode($array)
     * output: 
     * foo, bar and john
     */
    public function smartImplode($array)
    {
        $last  = array_slice($array, -1);
        $first = join(', ', array_slice($array, 0, -1));
        $both  = array_filter(array_merge(array($first), $last), 'strlen');
        return join(' and ', $both);
    }

    public function arrayToObject($array) 
    {
        if (!is_array($array)) {
            return $array;
        }
        
        $object = new \StdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name=>$value) {
                $name = strtolower(trim($name));
                if (!empty($name)) {
                    $object->$name = $this->arrayToObject($value);
                }
            }
            return $object;
        }
        else {
            return FALSE;
        }
    }

    public function getYoutubeIdFromUrl($url) 
    {

        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        if ($my_array_of_vars['v']) {
            return $my_array_of_vars['v']; 
        } else {
            return false;
        }

    }

    public function convertSeverityCodeToSeverityText($severity) 
    {

        switch($severity)
        {
            case E_ERROR: // 1 //
                return 'E_ERROR';
            case E_WARNING: // 2 //
                return 'E_WARNING';
            case E_PARSE: // 4 //
                return 'E_PARSE';
            case E_NOTICE: // 8 //
                return 'E_NOTICE';
            case E_CORE_ERROR: // 16 //
                return 'E_CORE_ERROR';
            case E_CORE_WARNING: // 32 //
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR: // 64 //
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING: // 128 //
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR: // 256 //
                return 'E_USER_ERROR';
            case E_USER_WARNING: // 512 //
                return 'E_USER_WARNING';
            case E_USER_NOTICE: // 1024 //
                return 'E_USER_NOTICE';
            case E_STRICT: // 2048 //
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: // 8192 //
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384 //
                return 'E_USER_DEPRECATED';
            default:
                return "";
                break;
        }

    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function getSecretKey()
    {
        return config('fav.secret_key');
    }

}