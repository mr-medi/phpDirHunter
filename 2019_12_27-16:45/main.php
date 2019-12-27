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
     <a href="index.html">Volver</a><br>
     <?php
        $file = "resultado.txt";
        $dictionariesToHunt = [];
        $start_time = microtime(true);
        $domainsToHunt = GRFC($dictionariesToHunt);
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        echo "<p>Resultados obtenidos en ".$execution_time." segundos...</p>";
        $i = 0;
        //COMPROBANDO QUE LAS URL ACABEN EN /
        foreach ($domainsToHunt as $domain)
        {
            if($domain[strlen($domain)-1] != "/")
            {
                $domainsToHunt[$i] = $domain."/";
            }
            $i++;
        }

        if($dictionariesToHunt[0] == "bruteforce")
            doBruteForceDir($TEMPORAL);

        $list = file_get_contents('lista.txt');
        $directorios = explode("\n", $list);
        //POR CADA URL COMPROBAMOS LOS DIRECTORIOS
        foreach ($domainsToHunt as $dominio)
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
                echo "<h3>Resultados para el dominio : <strong>$dominio</strong></h3><br>";
                echo "<p>Total directorios probados  : ". count($urls) ." </p>";
                echo "<p>Resultados obtenidos en <strong>".$execution_time."</strong> segundos...</p>";
                echo "<p>Encontrados <strong>". count($vacio) ."</strong> resultados....</p>";
                foreach ($vacio as $valor)
                {
                      echo "<strong style='color:green;'>[ * ] </strong>
                      Directorio encontrado en <strong style='color:green;'>$valor</strong><br>";
                }
            }
         }
      ?>
   </body>
 </html>
