<?php
    require_once "funciones.php";
 ?>
<?php
  if(isset($_POST["enviar"]))
  {
    if(!empty($_POST["url"]))
    {
      $file = "resultado.txt";
      $url = $_POST["url"];
      echo getDirectories($url);
     }
   }
 ?>
