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
               // Starting clock time in seconds
               $start_time = microtime(true);
               $directorios = getDirectories($url,399);
               // End clock time in seconds
               $end_time = microtime(true);
               // Calculate script execution time
               $execution_time = ($end_time - $start_time);
               echo "<h2>Resultados obtenidos en ".$execution_time." segundos...</h2><br>";
               //MOSTRANDO DIRECTORIOS ENCONTRADOS
               echo "<h1>Mostrando ".count($directorios["found"])." directorios encontrados</h1><br>";
               foreach ($directorios["found"] as $directorio)
               {
                  echo "<strong style='color:green;'>[ * ] </strong>
                  Directorio encontrado en <strong style='color:green;'>
                  <a href='$directorio'>$directorio</a></strong>";
                  echo "<br>";
               }
               //MOSTRANDO DIRECTORIOS NO ENCONTRADOS
               echo "<h1>Mostrando ".count($directorios["notFound"])." directorios NO encontrados</h1><br>";
               foreach ($directorios["notFound"] as $directorio)
               {
                  echo "<strong style='color:red;'>[ ! ] </strong>
                  Directorio NO encontrado en <strong style='color:red;'>
                  <a href='$directorio'>$directorio</a></strong>";
                  echo "<br>";
               }
           }
          }
        }
      ?>
   </body>
 </html>
