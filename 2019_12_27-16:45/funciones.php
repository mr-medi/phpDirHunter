<?php
      function rollingCurl($urls, $callback, $custom_options = null, $XD=0, &$DIRECTORIOS)
      {
            $rolling_window = 100;
            $rolling_window = (count($urls) < $rolling_window) ? count($urls) : $rolling_window;
            $master = curl_multi_init();
            $curl_arr = array();
            $std_options = array(CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_USERAGENT => 'GoogleBot');
            $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;
            for ($i = 0; $i < $rolling_window; $i++)
            {
              $ch = curl_init();
              $options[CURLOPT_URL] = $urls[$i];
              curl_setopt_array($ch,$options);
              curl_multi_add_handle($master, $ch);
            }
            do
            {
              while(($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
              if($execrun != CURLM_OK)
                  break;
              while($done = curl_multi_info_read($master))
              {
                  $info = curl_getinfo($done['handle']);
                  if ($info['http_code'] == 200)
                  {
                      $DIRECTORIOS[$XD] = $info['url'];
                      ++$XD;
                  }
                  $output = curl_multi_getcontent($done['handle']);
                  //$callback($output);
                  $ch = curl_init();
                  curl_setopt_array($ch,$options);
                  curl_multi_add_handle($master, $ch);
                  curl_multi_remove_handle($master, $done['handle']);
                  $options[CURLOPT_URL] = $urls[$i++];
              }
          }while ($running);
        curl_multi_close($master);
        return true;
      }

    function getDirectories($url,$numeroPeticiones)
    {
      $contador = 0;
      $context = stream_context_create(
        array
        (
        'http' =>
                array
                (
                  'method' => 'GET',
                  'timeout' => 5.0,
                  'user_agent' => '<script>alert(0)</script>',
                  'follow_location' => 0,
                  'max_redirects' => '0',
                  'protocol_version' => 1.1,
                  'header'   =>
                    [
                      'Connection: close'
                    ]
                )
      ));
      $datos = array();
      $founds = array();
      $notFounds = array();
      $lista = file_get_contents("lista.txt");
      $directorios = explode("\n", $lista);
      while($contador <= $numeroPeticiones)
      {
          $recurso = $url.$directorios[$contador];
          if(fopen($recurso, "r" , false , $context))
          {
            $founds[] = $recurso;
            fclose($recurso);
          }
          else
          {
            $notFounds[] = $recurso;
          }
          $contador++;
      }
      $datos = array("found" => $founds , "notFound" => $notFounds);
      return $datos;
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
             $start = 0;
             recurse($letters, $words, $start++, $end, $depth, $word);
           }
       }
    }

     function GRFC(&$arr)
      {
          $rawReq = file_get_contents('php://input');
          //echo "$rawReq";
          $domains = json_decode($rawReq);
          $temp = "";
          $arrayDomains = [];
          $arrayOpciones = [];
          $x = 0;
          $datos = array();
          //OPCIONES
          for($i = 0; $i < $domains -> opciones; ++$i)
          {
              $temp = "opcion";
              $temp .= $i;
              $array[] = $domains -> $temp;
              //$arrayDomains[$i] = $domains -> $temp;
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
              //$arrayDomains[$x] = $domains -> $temp;
              $array[] = $domains -> $temp;
              //$arrayDomains = array("dominios" => array($domains -> $temp));
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
             $arr[$i] = $domains -> $temp;
         }
          return $datos;
      }

     function getStrings($letters, $maxLength)
     {
         $words = array();
         recurse($letters, $words, 0, count($letters), $maxLength);
         return $words;
     }

    function getUrlsBruteForce($url)
    {
      $directorios = getStrings(range("a" , "e") , 5);
      $urls = array();
      foreach ($directorios as $directorio)
      {
            $urls[] = $url.$directorio;
      }
      return $urls;
    }
 ?>
