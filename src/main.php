<?php
    require_once "funciones.php";
 ?>
<?php
  $url = "https://www.youtube.com/";
  $file = "resultado.txt";

  if(!is_file($file))
  {
      $contents = "";
      file_put_contents($file, $contents);
  }
  $lista = file_get_contents("lista.txt");
  $directorios = explode("\n", $lista);
  foreach ($directorios as $directorio)
  {
    $recurso = $url.$directorio;
    echo "<strong>Probando => $recurso ...</strong><br>";

    if(fopen($recurso, "r"))
    {
      echo "[ * ]Encontrado directorio en $url<br>";
      file_put_contents($file, file_get_contents($file).$url.";");
    }
    else
    {
      echo "[ ! ]...<br>";
    }
  }
 ?>
