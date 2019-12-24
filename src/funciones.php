<?php
    function getDirectories($url)
    {
      $resultado = "";
      $lista = file_get_contents("lista.txt");
      $directorios = explode("\n", $lista);
      foreach ($directorios as $directorio)
      {
        $recurso = $url.$directorio;
        $resultado .= "<h3>TRYING => $recurso ...</h3><br>";

        if(fopen($recurso, "r"))
        {
          $resultado .= "<strong style='color:green'>[ * ]</strong>Encontrado directorio en <strong style='color:green'>$recurso</strong><br>";
          //file_put_contents($file, file_get_contents($file).$url.";");
        }
        else
        {
          $resultado .= "<strong style='color:red'>[ ! ]</strong>Nada encontrado<br>";
        }
      }
      return $resultado;
    }

    function isDirOnDomain($url , $dir)
    {
      return fopen($url.$dir);
    }

    function recurse($letters, &$words, $start, $end, $depth, $prefix = "")
    {
       $depth--;
       for ($i = $start; $i < $end; $i++)
       {
           $word = $prefix .$letters[$i];
           $words[] = $word;
           if($depth != 0)
           {
             //$start = 0;
             recurse($letters, $words, $start++, $end, $depth, $word);
           }
       }
    }

     function GRFC(array &$arr)
      {
          $rawReq = file_get_contents('php://input');
          echo "$rawReq";
          $domains = json_decode($rawReq);
          $temp = "";
          $arrayDomains = [];
          $x = 0;

          for($i = 0; $i < $domains->nod; ++$i)
          {
            $temp = "domain";
            $temp += $i;
            $arrayDomains[i] = $domains->$temp;
            $x = $i;
          }

         for($i=0; $x < $domains->nd; ++$x)
         {
           $temp = "dictionary";
           $temp +=$i; ++$i;
           $arr[i] = $domains->$temp;
         }

          return $arrayDomains;
      }

     function getStrings($letters, $maxLength)
     {
         $words = array();
         recurse($letters, $words, 0, count($letters), $maxLength);
         return $words;
     }

    function doBruteForceDir($url)
    {
      $directorios = getStrings(range("a" , "z") , 6);
      foreach ($directorios as $directorio)
      {
        echo "<strong>TRYING =>". $url.$directorio."</strong><br>";
        if(isDirOnDomain($url , $directorio))
        {

        echo "<strong style='color:green'>[ * ]</strong>Encontrado directorio en ".$url.$directorio."<br>";
        }
        else
        {
          echo "<strong style='color:red'>[ ! ]</strong>Nada...<br>";
        }
      }
    }
 ?>
