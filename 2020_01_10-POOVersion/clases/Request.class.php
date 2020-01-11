<?php
    class Request
    {
        public static function getRequest($json)
        {
            $domains = json_decode($json);
            $arrayDomains = [];
            $arrayOpciones = [];
            $datos = [];
            $x = 0;
            //OPCIONES
            for($i = 0; $i < $domains -> opciones; ++$i)
            {
                $temp = "opcion";
                $temp .= $i;
                $array[] = $domains -> $temp;
                $x = $i;
            }
            $arrayOpciones = $array;
            $array = [];
            $x++;
            //NOD
            for($i = 0; $i < $domains -> nod; ++$i)
            {
                $temp = "domain";
                $temp .= $i;
                $array[] = $domains -> $temp;
                $x = $i;
            }
            $arrayDomains = $array;
            $datos = [$arrayOpciones,$arrayDomains];

           //ND
           for($i = 0; $x < $domains -> nd; ++$x)
           {
               $temp = "dictionary";
               $temp .= $i;
               ++$i;
               //$arr[$i] = $domains -> $temp;
           }
           return $datos;
        }
    }
 ?>
