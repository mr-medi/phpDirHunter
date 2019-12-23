<?php
    function getDirectories($url)
    {
      $resultado = "";
      $lista = file_get_contents("lista.txt");
      $directorios = explode("\n", $lista);
      foreach ($directorios as $directorio)
      {
        $recurso = $url.$directorio;
        $resultado .= "<strong>Probando => $recurso ...</strong><br>";

        if(fopen($recurso, "r"))
        {
          $resultado .= "[ * ]Encontrado directorio en $url<br>";
          //file_put_contents($file, file_get_contents($file).$url.";");
        }
        else
        {
          $resultado .= "[ ! ]Nada encontrado<br>";
        }
      }
      return $resultado;
    }

 ?>
