<?php
   require_once "funciones.php";
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Hunting dirs...</title>
   </head>
   <body>
     <a href="index.html">Volver</a><br>
     <?php
       if(isset($_POST["enviar"]))
       {
         if(!empty($_POST["url"]) && !empty($_POST["option"]))
         {
           $file = "resultado.txt";
           $url = $_POST["url"];
           $opcion = $_POST["option"];
           if($opcion == "fuerzaBruta")
           {
               doBruteForceDir($url);
           }
           else
           {
             if($url[strlen($url)] != "/")
             {
               $url .= "/";
             }
             $urls = array();
             $lista = file_get_contents("lista.txt");
             $directorios = explode("\n", $lista);
             foreach ($directorios as $directorio)
             {
               $urls[] = $url.$directorio;
             }
             echo "<h1>Total directorios probados => ".count($urls)."</h1><br>";
             $xD2 = 0;
             $vacio = array();
             $start_time = microtime(true);

             if(rollingCurl($urls,1,null,$xD2,$vacio))
             {
               $end_time = microtime(true);
               $execution_time = ($end_time - $start_time);
               echo "<h2>Resultados obtenidos en ".$execution_time." segundos...</h2><br>";
               echo "<h1>Encontrados ".count($vacio)." resultados....</h1><br>";
               foreach ($vacio as $valor)
               {
                 echo "<strong style='color:green;'>[ * ] </strong>
                 Directorio encontrado en <strong style='color:green;'>
                 <a href='$valor'>$valor</a></strong>";
                 echo "<br>";
               }
             }
           }
          }
        }
      ?>
   </body>
 </html>
