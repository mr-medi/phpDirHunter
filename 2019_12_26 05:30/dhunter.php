<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>

<?php
require_once "php/funciones.php";
?>

<?php
$file = "resultado.txt";
$dictionariesToHunt = [];

$domainsToHunt = GRFC($dictionariesToHunt);

$TEMPORAL = $domainsToHunt[0];

if( $TEMPORAL[strlen($domainsToHunt[0])-1] != "/")
$TEMPORAL .= "/";

if($dictionariesToHunt[0] == "bruteforce")
doBruteForceDir($domainsToHunt[0]);


$list = file_get_contents('lista.txt');
$directorios = explode("\n", $list);

$urls=[];
   foreach ($directorios as $val)
   $urls[] = $TEMPORAL.$val;
             
echo "<p>Total directorios probados: ". count($urls) ."</p>";

$xD2 = 0;
$vacio = [];
$start_time = microtime(true);

   if(rollingCurl($urls,1,null,$xD2,$vacio))
   {
   $end_time = microtime(true);
   $execution_time = ($end_time - $start_time);

   echo "<p>Resultados obtenidos en ".$execution_time." segundos...</p>";

   echo "<p>Encontrados ". count($vacio) ." resultados....</p>";
    
  
      foreach ($vacio as $valor)
      {
      echo "<strong style='color:green;'>[ * ] </strong> Directorio encontrado en <strong style='color:green;'>$valor</strong>";
      }
   }
?>

</body>
</html>
