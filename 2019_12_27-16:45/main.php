<?php
   require_once "funciones.php";
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
     <title>Hunting dirs...</title>
   </head>
   <body>
     <?php
        $file = "resultado.txt";
        $dictionariesToHunt = [];
        $start_time = microtime(true);
        $datos = GRFC($dictionariesToHunt);
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        $i = 0;
        $opciones = $datos[0];
        $dominios = $datos[1];
        //COMPROBANDO QUE LAS URL ACABEN EN '/'
        foreach ($dominios as $domain)
        {
            if($domain[strlen($domain)-1] != "/")
            {
                $dominios[$i] = $domain."/";
            }
            $i++;
        }

        foreach ($opciones as $opcion)
        {
            if($opcion == "fuerzaBruta")
            {
                echo "<strong style='color:green;'>[ * ]Starting  Brute Force </strong><br>";
                $dirs = getUrlsBruteForce($dominios[0]);
                $vacio = [];
                $xD2 = 0;
                $start_time = microtime(true);
                if(rollingCurl($dirs,1,null,$xD2,$vacio))
                {
                    $end_time = microtime(true);
                    $execution_time = ($end_time - $start_time);
                    echo "<h3>Resultados para : <strong>$dominios[0]</strong></h3><br>";
                    echo "<p>Total directorios probados  : <strong>". count($dirs) ."</strong> </p>";
                    echo "<p>Resultados obtenidos en <strong>".$execution_time."</strong> segundos...</p>";
                    echo "<p>Encontrados <strong>". count($vacio) ."</strong> resultados....</p>";
                    foreach ($vacio as $valor)
                    {
                        echo "<strong style='color:green;'>[ * ] </strong>
                        Directorio encontrado en <strong style='color:green;'>$valor</strong><br>";
                    }
                }
            }
            elseif($opcion == "dic")
            {
                echo "<strong style='color:green;'>[ * ]Starting searching by Dictionary file </strong><br>";
                $list = file_get_contents('lista.txt');
                $directorios = explode("\n", $list);
                //POR CADA URL COMPROBAMOS LOS DIRECTORIOS
                foreach ($dominios as $dominio)
                 {
                      $vacio = [];
                      $xD2 = 0;
                      $start_time = microtime(true);
                      $urls = [];
                      foreach ($directorios as $directorio)
                      {
                           $urls[] = $dominio.$directorio;
                      }
                      if(rollingCurl($urls,1,null,$xD2,$vacio))
                      {
                            $end_time = microtime(true);
                            $execution_time = ($end_time - $start_time);
                            echo "<h3>Resultados para : <strong>$dominio</strong></h3><br>";
                            echo "<p>Total directorios probados  : <strong>". count($urls) ." </strong></p>";
                            echo "<p>Resultados obtenidos en <strong>".$execution_time."</strong> segundos...</p>";
                            echo "<p>Encontrados <strong>". count($vacio) ."</strong> resultados....</p>";
                            foreach ($vacio as $valor)
                            {
                                  echo "<strong style='color:green;'>[ * ] </strong>
                                  Directorio encontrado en <strong style='color:green;'>$valor</strong><br>";
                            }
                    }
                 }
            }
        }
        if(count($opciones) == 0)
        {
            echo "<strong style='color:red;'>[ ! ]Especifique una opcion!.... </strong><br>";
        }
      ?>
   </body>
 </html>
