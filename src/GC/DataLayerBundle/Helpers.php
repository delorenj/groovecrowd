<?php

namespace GC\DataLayerBundle;

setlocale(LC_ALL, 'en_US.UTF8');

class Helpers {
        
        static function slugify($str, $replace=array(), $delimiter='-') {
                if( !empty($replace) ) {
                        $str = str_replace((array)$replace, ' ', $str);
                }

                $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
                $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
                $clean = strtolower(trim($clean, '-'));
                $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

                return $clean;
        }

        static function dec2string($decimal, $base) 
        {    
           $string = null; 
           $base = (int)$base; 
           if ($base < 2 | $base > 29 | $base == 10) { 
              echo 'BASE must be in the range 2-9 or 11-29'; 
              exit; 
           }
           $charset = '2346789ABCDEFGHJKMNPQRTUVWXYZ';   
           $charset = substr($charset, 0, $base); 
        //   if (!ereg('(^[2346789]{1,50}$)', trim($decimal))) { 
        //      $error['dec_input'] = 'Value must be a positive integer with < 50 digits'; 
        //      return false; 
        //   }
           do { 
              $remainder = bcmod($decimal, $base); 
              $char      = substr($charset, $remainder, 1);
              $string    = "$char$string";
              $decimal   = bcdiv(bcsub($decimal, $remainder), $base); 
           } while ($decimal > 0); 
           return $string; 
        }

        static function string2dec ($string, $base) 
        { 
           $decimal = 0; 
           $base = (int)$base; 
           if ($base < 2 | $base > 29 | $base == 10) { 
              echo 'BASE must be in the range 2-9 or 11-29'; 
              exit; 
           }
           $charset = '2346789ABCDEFGHJKMNPQRTUVWXYZ'; 
           $charset = substr($charset, 0, $base); 
           $string = trim($string); 
           if (empty($string)) { 
              return false; 
           }
           do { 
              $char   = substr($string, 0, 1);
              $string = substr($string, 1);
              $pos = strpos($charset, $char);
              if ($pos === false) { 
                 return false; 
              }
              $decimal = bcadd(bcmul($decimal, $base), $pos); 
           } while($string <> null); 
           return $decimal; 
        }

        static function idToCode($id) {
            $E = 12252083;
            $N = 18818243;
            $D = 7619483;
            $powmodded_id = Helpers::PowModSim($id, $E, $N);
            $result = Helpers::dec2string($powmodded_id, 29);
            return $result;
        }

        static function codeToId($code) {
            $E = 12252083;
            $N = 18818243;
            $D = 7619483;
            $id = Helpers::string2dec($code, 29);
            return Helpers::PowModSim($id, $D, $N);
        }
          
          
        static function PowModSim($Value, $Exponent, $Modulus) {
            $Result = "1";

            while (TRUE)
              {
              if (bcmod($Exponent, 2) == "1")
                $Result = bcmod(bcmul($Result, $Value), $Modulus);

              if (($Exponent = bcdiv($Exponent, 2)) == "0") break;

              $Value = bcmod(bcmul($Value, $Value), $Modulus);
              }

            return ($Result);
        }

}